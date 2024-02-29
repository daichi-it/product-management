<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ShippingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        for ($i = 1; $i <= 20; $i++) {
            DB::table('shippings')->insert([
                'name' => "出荷先 {$i}",
                'address' => "テスト県 テスト市　テスト町　出荷先{$i}番地",
                'tel' => '000-0000-00' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ]);
        }
    }
}
