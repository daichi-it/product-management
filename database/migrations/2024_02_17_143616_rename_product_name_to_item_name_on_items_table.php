<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            // $table->renameColumn('product_name', 'item_name');
            DB::statement('ALTER TABLE items CHANGE product_name item_name VARCHAR(255)');
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            DB::statement('ALTER TABLE items CHANGE item_name product_name VARCHAR(255)');
            // $table->renameColumn('item_name', 'product_name');
        });
    }
};
