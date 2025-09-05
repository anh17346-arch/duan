<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\Product;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PromotionController extends Controller
{
    /**
     * Display a listing of promotions.
     */
    public function index()
    {
        $promotions = Promotion::with('product')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.promotions.index', compact('promotions'));
    }

    /**
     * Show the form for creating a new promotion.
     */
    public function create()
    {
        $products = Product::where('status', true)
            ->orderBy('name')
            ->get();

        return view('admin.promotions.create', compact('products'));
    }

    /**
     * Store a newly created promotion in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount_percentage' => 'required|numeric|min:1|max:100',
            'quantity' => 'nullable|integer|min:0',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Check if product already has an active promotion
        $existingPromotion = Promotion::where('product_id', $request->product_id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                      ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                      ->orWhere(function ($q) use ($request) {
                          $q->where('start_date', '<=', $request->start_date)
                            ->where('end_date', '>=', $request->end_date);
                      });
            })
            ->first();

        if ($existingPromotion) {
            return back()->withErrors(['product_id' => 'Sản phẩm này đã có khuyến mãi trong khoảng thời gian này.']);
        }

        $promotion = Promotion::create($request->all());

        // Gửi thông báo cho tất cả khách hàng về khuyến mãi mới
        try {
            $notificationService = app(NotificationService::class);
            $notificationService->createPromotionNotification($promotion, 'new_promotion');
        } catch (\Exception $e) {
            // Log lỗi nhưng không ảnh hưởng đến việc tạo khuyến mãi
            \Log::error('Failed to send promotion notification: ' . $e->getMessage());
        }

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Khuyến mãi đã được tạo thành công và thông báo đã được gửi cho khách hàng!');
    }

    /**
     * Show the form for editing the specified promotion.
     */
    public function edit(Promotion $promotion)
    {
        $products = Product::where('status', true)
            ->orderBy('name')
            ->get();

        return view('admin.promotions.edit', compact('promotion', 'products'));
    }

    /**
     * Update the specified promotion in storage.
     */
    public function update(Request $request, Promotion $promotion)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount_percentage' => 'required|numeric|min:1|max:100',
            'quantity' => 'nullable|integer|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Check if product already has an active promotion (excluding current one)
        $existingPromotion = Promotion::where('product_id', $request->product_id)
            ->where('id', '!=', $promotion->id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                      ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                      ->orWhere(function ($q) use ($request) {
                          $q->where('start_date', '<=', $request->start_date)
                            ->where('end_date', '>=', $request->end_date);
                      });
            })
            ->first();

        if ($existingPromotion) {
            return back()->withErrors(['product_id' => 'Sản phẩm này đã có khuyến mãi trong khoảng thời gian này.']);
        }

        $promotion->update($request->all());

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Khuyến mãi đã được cập nhật thành công!');
    }

    /**
     * Remove the specified promotion from storage.
     */
    public function destroy(Promotion $promotion)
    {
        $promotion->delete();

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Khuyến mãi đã được xóa thành công!');
    }
}
