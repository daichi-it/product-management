<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    } 

    public function favorite_items()
    {
        return $this->belongsToMany(Item::class, 'favorites', 'user_id', 'item_id');
    }
    
    public function is_favorite($itemId)
    {
        return $this->favorites()->where('item_id', $itemId)->exists();
    }
    
    public function cart_items()
    {
        return $this->belongsToMany(Item::class, 'cart_items', 'user_id', 'item_id')
            ->withPivot('quantity');
    }

    public function isInCart($itemId)
    {
        return $this->cart_items()->where('item_id', $itemId)->exists();
    }
}
