<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Store;
use App\Models\Product;
use App\Models\ProductCate;

class StoreSeeder extends Seeder
{
    public function run()
    {
        // 建立五個店家的資料
        for ($i = 6; $i <= 15; $i++) {
            // 建立 store 資料
            $tmp = $i;
            $store = Store::create([
                'private_id' => $tmp,
                'phone' => '12345678',
                'email' => "store{$tmp}@example.com",
                'owner_name' => "Owner{$tmp}"
            ]);

            // 建立 store_info 資料
            $store->info()->create([
                'name' => "TestStore {$tmp}",
                'address' => "Address {$tmp}",
                'intro' => "Introduction for Store {$tmp}",
                'tag' => 'tag1, tag2',
                'picUrl' => 'https://example.com/store.jpg'
            ]);

            // 建立 product_cate 資料
            $category = ProductCate::create([
                'name' => "TestType{$tmp}"
            ]);
            for ($j = 0 ; $j < 10; $j++){
                // 建立 products 資料
                $product = Product::create([
                    'product_cate_id' => $category->id,
                    'store_id' => $store->id,
                    'name' => "Product {$tmp}_{$j}",
                    'description' => "Description for Product {$tmp}_{$j}",
                    'price' => 100.00 + $tmp,
                    'picUrl' => 'https://example.com/product.jpg'
                ]);
            }

        }
    }
}

?>