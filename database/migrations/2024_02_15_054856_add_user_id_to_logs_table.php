<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {            
        // logsテーブルにuser_idカラムをNULL許容で追加
        Schema::table('logs', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id');;
        });

        // 既存のデータには仮で"1"という値を設定
        DB::table('logs')->update(['user_id' => 1]);

        // user_idにnot NULLと外部キー制約を設定
        Schema::table('logs', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('logs', function (Blueprint $table) {
            // 外部キー制約を削除
            $table->dropForeign(['user_id']);

            // カラムを削除
            $table->dropColumn('user_id');
        });
    }
};
