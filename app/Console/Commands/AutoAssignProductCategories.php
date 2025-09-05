<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Console\Command;

class AutoAssignProductCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:auto-assign-categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tự động gán tất cả sản phẩm vào các danh mục phù hợp dựa trên gender';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Bắt đầu tự động gán sản phẩm vào danh mục...');
        
        $products = Product::with('categories')->get();
        $categories = Category::all();
        
        $this->info("Tìm thấy {$products->count()} sản phẩm và {$categories->count()} danh mục");
        
        $assignedCount = 0;
        
        foreach ($products as $product) {
            $assignedCategories = $product->categories->pluck('id')->toArray();
            $newAssignments = 0;
            
            foreach ($categories as $category) {
                $shouldAssign = false;
                
                // Kiểm tra dựa trên tên category và gender của product
                if ($product->gender === 'male' && 
                    (stripos($category->name, 'nam') !== false || 
                     stripos($category->name, 'male') !== false ||
                     stripos($category->name_en, 'male') !== false)) {
                    $shouldAssign = true;
                }
                
                if ($product->gender === 'female' && 
                    (stripos($category->name, 'nữ') !== false || 
                     stripos($category->name, 'female') !== false ||
                     stripos($category->name_en, 'female') !== false)) {
                    $shouldAssign = true;
                }
                
                if ($product->gender === 'unisex' && 
                    (stripos($category->name, 'unisex') !== false || 
                     stripos($category->name_en, 'unisex') !== false)) {
                    $shouldAssign = true;
                }
                
                // Nếu nên gán và chưa được gán vào category này thì gán
                if ($shouldAssign && !in_array($category->id, $assignedCategories)) {
                    $product->categories()->attach($category->id);
                    $newAssignments++;
                    $assignedCount++;
                    
                    $this->line("✓ Gán sản phẩm '{$product->name}' ({$product->gender}) vào danh mục '{$category->name}'");
                }
            }
            
            if ($newAssignments > 0) {
                $this->info("  → Sản phẩm '{$product->name}': {$newAssignments} danh mục mới");
            }
        }
        
        $this->info("Hoàn thành! Đã gán {$assignedCount} sản phẩm vào danh mục phù hợp.");
        
        return Command::SUCCESS;
    }
}
