<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductImageController extends Controller
{
    public function store(Request $request, Product $product): JsonResponse
    {
        // Debug logging
        \Log::info('ProductImage upload started', [
            'product_id' => $product->id,
            'request_all' => $request->all(),
            'all_files' => $request->allFiles(),
            'has_images' => $request->hasFile('images'),
            'headers' => $request->headers->all()
        ]);

        // Lấy files từ request - xử lý cả 'images' và các key khác
        $files = $request->file('images');
        if (empty($files)) {
            // Thử tìm files trong tất cả các key
            $allFiles = $request->allFiles();
            foreach ($allFiles as $key => $fileArray) {
                if (is_array($fileArray) && !empty($fileArray)) {
                    $files = $fileArray;
                    \Log::info("Found files under key: {$key}");
                    break;
                }
            }
        }

        // Kiểm tra xem có file nào được gửi không
        if (empty($files)) {
            \Log::error('No images found in request', [
                'request_all' => $request->all(),
                'all_files' => $request->allFiles()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Không có ảnh nào được chọn',
                'errors' => ['images' => ['Vui lòng chọn ít nhất một ảnh']],
                'debug' => [
                    'all_files' => $request->allFiles(),
                    'request_keys' => array_keys($request->all())
                ]
            ], 422);
        }

        // Log thông tin files
        \Log::info('Files found:', [
            'count' => count($files),
            'files_info' => collect($files)->map(function($file) {
                return [
                    'name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType(),
                    'extension' => $file->getClientOriginalExtension(),
                    'is_valid' => $file->isValid(),
                    'error' => $file->getError(),
                    'error_message' => $file->getErrorMessage()
                ];
            })->toArray()
        ]);

        // Kiểm tra từng file trước khi validation
        $invalidFiles = [];
        foreach ($files as $index => $image) {
            if (!$image->isValid()) {
                $invalidFiles[] = "Ảnh thứ " . ($index + 1) . " ({$image->getClientOriginalName()}): " . $image->getErrorMessage();
            }
            
            // Kiểm tra thêm PHP upload errors
            if ($image->getError() !== UPLOAD_ERR_OK) {
                $errorMessages = [
                    UPLOAD_ERR_INI_SIZE => 'File quá lớn (vượt quá upload_max_filesize)',
                    UPLOAD_ERR_FORM_SIZE => 'File quá lớn (vượt quá MAX_FILE_SIZE)',
                    UPLOAD_ERR_PARTIAL => 'File chỉ được upload một phần',
                    UPLOAD_ERR_NO_FILE => 'Không có file nào được upload',
                    UPLOAD_ERR_NO_TMP_DIR => 'Thiếu thư mục tạm',
                    UPLOAD_ERR_CANT_WRITE => 'Không thể ghi file',
                    UPLOAD_ERR_EXTENSION => 'Upload bị dừng bởi extension'
                ];
                
                $errorMsg = $errorMessages[$image->getError()] ?? 'Lỗi upload không xác định';
                $invalidFiles[] = "Ảnh thứ " . ($index + 1) . " ({$image->getClientOriginalName()}): " . $errorMsg;
            }
        }

        if (!empty($invalidFiles)) {
            \Log::error('Invalid files detected', ['invalid_files' => $invalidFiles]);
            return response()->json([
                'success' => false,
                'message' => 'Một số file không hợp lệ',
                'errors' => ['files' => $invalidFiles]
            ], 422);
        }

        // Validation rules
        $validator = Validator::make(['images' => $files], [
            'images' => 'required|array',
            'images.*' => 'required|file|image|mimes:jpeg,png,jpg,webp|max:4096', // 4MB
        ]);

        if ($validator->fails()) {
            \Log::error('ProductImage validation failed', [
                'errors' => $validator->errors()->toArray(),
                'files_count' => count($files)
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ: ' . $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $uploadedImages = [];
        $errors = [];
        
        // Chỉ đặt ảnh đầu tiên làm primary nếu sản phẩm chưa có ảnh nào
        $isFirstImage = !$product->images()->exists();

        foreach ($files as $index => $image) {
            try {
                // Kiểm tra file có hợp lệ không
                if (!$image->isValid()) {
                    $errors[] = "Ảnh thứ " . ($index + 1) . ": File không hợp lệ - " . $image->getErrorMessage();
                    continue;
                }

                $filename = time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('products/' . $product->id, $filename, 'public');
                
                \Log::info('Image stored successfully', [
                    'filename' => $filename,
                    'path' => $path,
                    'full_path' => storage_path('app/public/' . $path)
                ]);

                // Tạo product image
                $productImage = new ProductImage([
                    'image_path' => $path,
                    'alt_text' => $request->input('alt_text.' . $index),
                    'sort_order' => $product->images()->count(),
                    'is_primary' => false // Mặc định không phải primary
                ]);
                
                $product->images()->save($productImage);
                
                // Nếu là ảnh đầu tiên và sản phẩm chưa có ảnh primary nào, đặt làm primary
                if ($isFirstImage) {
                    $productImage->makePrimary();
                }

                $uploadedImages[] = $productImage;
                $isFirstImage = false; // Các ảnh tiếp theo không phải primary
                
                \Log::info('ProductImage created successfully', [
                    'image_id' => $productImage->id,
                    'product_id' => $product->id,
                    'is_primary' => $productImage->is_primary
                ]);
            } catch (\Exception $e) {
                \Log::error('Error processing image', [
                    'index' => $index,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                
                $errors[] = "Ảnh thứ " . ($index + 1) . ": " . $e->getMessage();
                continue; // Tiếp tục với ảnh tiếp theo
            }
        }

        if (count($uploadedImages) === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Không upload được ảnh nào. Lỗi: ' . implode(', ', $errors),
                'errors' => $errors
            ], 422);
        }

        $responseMessage = 'Đã upload ' . count($uploadedImages) . ' ảnh thành công';
        if (count($errors) > 0) {
            $responseMessage .= '. Một số ảnh bị lỗi: ' . implode(', ', $errors);
        }

        return response()->json([
            'success' => true,
            'message' => $responseMessage,
            'images' => $uploadedImages->map(function($img) {
                return [
                    'id' => $img->id,
                    'image_url' => $img->image_url,
                    'is_primary' => $img->is_primary
                ];
            }),
            'errors' => $errors
        ]);
    }

    public function update(Request $request, ProductImage $image): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'alt_text' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_primary' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors()
            ], 422);
        }

        // Nếu đặt làm ảnh chính
        if ($request->boolean('is_primary')) {
            $image->makePrimary();
        }

        $image->update($request->only(['alt_text', 'sort_order']));

        return response()->json([
            'success' => true,
            'message' => 'Đã cập nhật ảnh thành công',
            'image' => $image->fresh()
        ]);
    }

    public function destroy(ProductImage $image): JsonResponse
    {
        // Không cho phép xóa ảnh cuối cùng
        if ($image->product->images()->count() <= 1) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa ảnh cuối cùng của sản phẩm'
            ], 400);
        }

        // Nếu đang xóa ảnh chính, đặt ảnh khác làm chính
        if ($image->is_primary) {
            $nextImage = $image->product->images()->where('id', '!=', $image->id)->first();
            if ($nextImage) {
                $nextImage->makePrimary();
            }
        }

        $image->deleteImage();

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa ảnh thành công'
        ]);
    }

    public function reorder(Request $request, Product $product): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'image_order' => 'required|array',
            'image_order.*' => 'required|integer|exists:product_images,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors()
            ], 422);
        }

        foreach ($request->input('image_order') as $index => $imageId) {
            ProductImage::where('id', $imageId)->update(['sort_order' => $index]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Đã sắp xếp lại thứ tự ảnh'
        ]);
    }

    public function setPrimary(ProductImage $image): JsonResponse
    {
        $image->makePrimary();

        return response()->json([
            'success' => true,
            'message' => 'Đã đặt làm ảnh chính'
        ]);
    }
}
