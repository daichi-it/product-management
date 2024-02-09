<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Item;


class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        for ($i = 1; $i <= 100; $i++) {
            Item::create([
                "product_name" => "商品名：" . $i,
                "arrival_source" => "入荷元：" . $i,
                "manufacturer" => "製造元：" . $i,
                "price" => rand(1, 99) * 100,
            ]);
        }
    }
}
