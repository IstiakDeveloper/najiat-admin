<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'short_description', 'description', 'image', 'image_gallery', 'author', 'category_id', 'regular_price', 'sale_price', 'purchase_price', 'pdf_file'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
