<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of user's reviews
     */
    public function index()
    {
        $reviews = Auth::user()->reviews()
            ->with(['product', 'order'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new review
     */
    public function create(Request $request)
    {
        $productId = $request->input('product_id');
        $orderId = $request->input('order_id');

        // Validate that user has purchased this product
        $orderItem = OrderItem::where('order_id', $orderId)
            ->where('product_id', $productId)
            ->whereHas('order', function ($query) {
                $query->where('user_id', Auth::id())
                      ->where('status', 'delivered');
            })
            ->first();

        if (!$orderItem) {
            return redirect()->back()->with('error', 'Bạn chưa mua sản phẩm này hoặc đơn hàng chưa hoàn thành.');
        }

        // Check if user already reviewed this product for this order
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->where('order_id', $orderId)
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Bạn đã đánh giá sản phẩm này cho đơn hàng này.');
        }

        $product = Product::findOrFail($productId);
        $order = Order::findOrFail($orderId);

        return view('reviews.create', compact('product', 'order'));
    }

    /**
     * Store a newly created review
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|numeric|between:1,5',
            'comment' => 'nullable|string|max:1000',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            'videos.*' => 'nullable|mimes:mp4,mov,avi|max:51200', // 50MB max
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Validate that user has purchased this product
        $orderItem = OrderItem::where('order_id', $request->order_id)
            ->where('product_id', $request->product_id)
            ->whereHas('order', function ($query) {
                $query->where('user_id', Auth::id())
                      ->where('status', 'delivered');
            })
            ->first();

        if (!$orderItem) {
            return redirect()->back()->with('error', 'Bạn chưa mua sản phẩm này hoặc đơn hàng chưa hoàn thành.');
        }

        // Check if user already reviewed this product for this order
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->where('order_id', $request->order_id)
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Bạn đã đánh giá sản phẩm này cho đơn hàng này.');
        }

        // Create review
        $review = Review::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'order_id' => $request->order_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_verified' => true, // Verified purchase
        ]);

        // Create notification for admin about new review
        $notificationService = new \App\Services\NotificationService();
        $notificationService->createNewReviewNotification($review);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('reviews/images', 'public');
                
                $review->images()->create([
                    'file_path' => $path,
                    'file_name' => $image->getClientOriginalName(),
                    'file_type' => 'image',
                    'mime_type' => $image->getMimeType(),
                    'file_size' => $image->getSize(),
                    'sort_order' => $index,
                ]);
            }
        }

        // Handle video uploads
        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $index => $video) {
                $path = $video->store('reviews/videos', 'public');
                
                $review->images()->create([
                    'file_path' => $path,
                    'file_name' => $video->getClientOriginalName(),
                    'file_type' => 'video',
                    'mime_type' => $video->getMimeType(),
                    'file_size' => $video->getSize(),
                    'sort_order' => $index + 100, // Videos after images
                ]);
            }
        }

        return redirect()->route('reviews.index')
            ->with('success', 'Đánh giá của bạn đã được gửi thành công!');
    }

    /**
     * Show the form for editing a review
     */
    public function edit(Review $review)
    {
        // Check if user owns this review
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if review can be edited (within 24 hours)
        if (!$review->canBeEdited()) {
            return redirect()->route('reviews.index')
                ->with('error', 'Không thể chỉnh sửa đánh giá sau 24 giờ.');
        }

        return view('reviews.edit', compact('review'));
    }

    /**
     * Update the specified review
     */
    public function update(Request $request, Review $review)
    {
        // Check if user owns this review
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if review can be edited (within 24 hours)
        if (!$review->canBeEdited()) {
            return redirect()->route('reviews.index')
                ->with('error', 'Không thể chỉnh sửa đánh giá sau 24 giờ.');
        }

        $validator = Validator::make($request->all(), [
            'rating' => 'required|numeric|between:1,5',
            'comment' => 'nullable|string|max:1000',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'videos.*' => 'nullable|mimes:mp4,mov,avi|max:51200',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update review
        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_edited' => true,
            'edited_at' => now(),
        ]);

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('reviews/images', 'public');
                
                $review->images()->create([
                    'file_path' => $path,
                    'file_name' => $image->getClientOriginalName(),
                    'file_type' => 'image',
                    'mime_type' => $image->getMimeType(),
                    'file_size' => $image->getSize(),
                    'sort_order' => $review->images()->count() + $index,
                ]);
            }
        }

        // Handle new video uploads
        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $index => $video) {
                $path = $video->store('reviews/videos', 'public');
                
                $review->images()->create([
                    'file_path' => $path,
                    'file_name' => $video->getClientOriginalName(),
                    'file_type' => 'video',
                    'mime_type' => $video->getMimeType(),
                    'file_size' => $video->getSize(),
                    'sort_order' => $review->images()->count() + $index + 100,
                ]);
            }
        }

        return redirect()->route('reviews.index')
            ->with('success', 'Đánh giá đã được cập nhật thành công!');
    }

    /**
     * Remove the specified review
     */
    public function destroy(Review $review)
    {
        // Check if user owns this review
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        // Delete associated files
        foreach ($review->images as $image) {
            Storage::disk('public')->delete($image->file_path);
        }

        $review->delete();

        return redirect()->route('reviews.index')
            ->with('success', 'Đánh giá đã được xóa thành công!');
    }

    /**
     * Get reviews for a product (for product detail page)
     */
    public function getProductReviews(Request $request, Product $product)
    {
        $query = $product->approvedReviews()
            ->with(['user', 'images'])
            ->orderBy('created_at', 'desc');

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Filter by has images
        if ($request->boolean('has_images')) {
            $query->withImages();
        }

        // Sort by
        switch ($request->get('sort', 'newest')) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'rating_high':
                $query->orderBy('rating', 'desc')->orderBy('created_at', 'desc');
                break;
            case 'rating_low':
                $query->orderBy('rating', 'asc')->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $reviews = $query->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'reviews' => $reviews,
                'html' => view('products.partials.reviews-list', compact('reviews'))->render()
            ]);
        }

        return $reviews;
    }

    /**
     * Delete a review image
     */
    public function deleteImage(Request $request, Review $review)
    {
        // Check if user owns this review
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $imageId = $request->input('image_id');
        $image = $review->images()->findOrFail($imageId);

        // Delete file
        Storage::disk('public')->delete($image->file_path);
        
        // Delete record
        $image->delete();

        return response()->json(['success' => true]);
    }
}
