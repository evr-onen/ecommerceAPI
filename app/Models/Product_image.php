<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_image extends Model
{
    use HasFactory;
    public $fillable=['name', 'product_id', 'path', 'priority'];

    public function productImagesToProduct()
    {
        
         return $this->belongsTo(Product::class, 'product_id');
    }
}
