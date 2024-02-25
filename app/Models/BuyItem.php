<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyItem extends Model
{
    use HasFactory;
    public $timestamps = false; // updated_atが存在しないため設定が必要
    protected $fillable = ['user_id', 'item_id', 'quantity', 'created_at'];
}
