<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $table        = 'products';
    protected $fillable     = ['product_name', 'description', 'price', 'stock', 'enabled', 'category_id', 'status', 'user_id'];
    const STATUS_ACTIVE     = 'SHOW';
    const STATUS_DELETED    = 'DELETED';

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
