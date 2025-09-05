<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    /**
     * Display a listing of reviews
     */
    public function index(Request $request)
    {
        $query = Review::with(['user', 'product', 'order', 'images'])
            ->orderBy('created_at', 'desc');

        // Filter by product
        if ($request->filled('product')) {
            $query->where('product_id', $request->product);
        }

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Filter by status
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'pending':
                    $query->whereNull('is_approved');
                    break;
                case 'approved':
                    $query->where('is_approved', true);
                    break;
                case 'rejected':
                    $query->where('is_approved', false);
                    break;
            }
        }

        // Filter by date
        if ($request->filled('date')) {
            switch ($request->date) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', now()->month);
                    break;
                case 'quarter':
                    $query->where('created_at', '>=', now()->subMonths(3));
                    break;
            }
        }

        // Search by user name, product name, or comment
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                              ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('product', function ($productQuery) use ($search) {
                    $productQuery->where('name', 'like', "%{$search}%");
                })
                ->orWhere('comment', 'like', "%{$search}%");
            });
        }

        $reviews = $query->paginate(20);
        $products = Product::orderBy('name')->get();

        return view('admin.reviews.index', compact('reviews', 'products'));
    }

    /**
     * Show the specified review
     */
    public function show(Review $review)
    {
        $review->load(['user', 'product', 'order', 'images']);
        return view('admin.reviews.show', compact('review'));
    }

    /**
     * Approve a review
     */
    public function approve(Review $review)
    {
        $review->update(['is_approved' => true]);
        
        return redirect()->back()
            ->with('success', 'Đánh giá đã được phê duyệt.');
    }

    /**
     * Reject a review
     */
    public function reject(Review $review)
    {
        $review->update(['is_approved' => false]);
        
        return redirect()->back()
            ->with('success', 'Đánh giá đã bị từ chối.');
    }

    /**
     * Remove the specified review
     */
    public function destroy(Review $review)
    {
        // Delete associated files
        foreach ($review->images as $image) {
            Storage::disk('public')->delete($image->file_path);
        }

        $review->delete();
        
        return redirect()->route('admin.reviews.index')
            ->with('success', 'Đánh giá đã được xóa thành công.');
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $selectedReviews = $request->input('selected_reviews', []);

        if (empty($selectedReviews)) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một đánh giá.');
        }

        switch ($action) {
            case 'approve':
                Review::whereIn('id', $selectedReviews)->update(['is_approved' => true]);
                $message = 'Đã phê duyệt ' . count($selectedReviews) . ' đánh giá.';
                break;
                
            case 'reject':
                Review::whereIn('id', $selectedReviews)->update(['is_approved' => false]);
                $message = 'Đã từ chối ' . count($selectedReviews) . ' đánh giá.';
                break;
                
            case 'delete':
                $reviews = Review::whereIn('id', $selectedReviews)->get();
                foreach ($reviews as $review) {
                    foreach ($review->images as $image) {
                        Storage::disk('public')->delete($image->file_path);
                    }
                    $review->delete();
                }
                $message = 'Đã xóa ' . count($selectedReviews) . ' đánh giá.';
                break;
                
            default:
                return redirect()->back()->with('error', 'Hành động không hợp lệ.');
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Get review statistics
     */
    public function statistics()
    {
        try {
            // Simple statistics first
            $totalReviews = Review::count();
            $approvedReviews = Review::where('is_approved', true)->count();
            $pendingReviews = Review::whereNull('is_approved')->count();
            $rejectedReviews = Review::where('is_approved', false)->count();

            // Basic rating distribution
            $ratingDistribution = [];
            for ($i = 1; $i <= 5; $i++) {
                $ratingDistribution[$i] = Review::where('rating', $i)->count();
            }

            // Simple monthly averages
            $monthlyAverages = [];
            for ($i = 5; $i >= 0; $i--) {
                $date = now()->subMonths($i);
                $monthName = $date->format('M Y');
                $average = Review::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->avg('rating');
                $monthlyAverages[$monthName] = round($average ?? 0, 1);
            }

            // Recent reviews (limit to 5 for testing)
            $recentReviews = Review::with(['user', 'product'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            // Top rated products (simplified)
            $topRatedProducts = collect();
            $lowestRatedProducts = collect();

            // Only get products if there are reviews
            if ($totalReviews > 0) {
                $topRatedProducts = Product::withCount('reviews')
                    ->withAvg('reviews', 'rating')
                    ->having('reviews_count', '>', 0)
                    ->orderBy('reviews_avg_rating', 'desc')
                    ->limit(5)
                    ->get();

                $lowestRatedProducts = Product::withCount('reviews')
                    ->withAvg('reviews', 'rating')
                    ->having('reviews_count', '>', 0)
                    ->orderBy('reviews_avg_rating', 'asc')
                    ->limit(5)
                    ->get();
            }

            return view('admin.reviews.statistics', compact(
                'totalReviews',
                'approvedReviews',
                'pendingReviews',
                'rejectedReviews',
                'ratingDistribution',
                'monthlyAverages',
                'recentReviews',
                'topRatedProducts',
                'lowestRatedProducts'
            ));
        } catch (\Exception $e) {
            \Log::error('Review statistics error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tải thống kê: ' . $e->getMessage());
        }
    }
}
