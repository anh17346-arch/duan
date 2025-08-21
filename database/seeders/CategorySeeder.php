<?php
namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder {
    public function run(): void {
        $items = ['Nước hoa nam','Nước hoa nữ','Unisex'];
        foreach ($items as $name) {
            Category::firstOrCreate(
                ['name'=>$name],
                ['slug'=>Str::slug($name)]
            );
        }
    }
}
    