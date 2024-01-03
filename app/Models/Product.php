<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $fillable=['name', 'price', 'discount_flat','category_id', 'discount_percent', 'stock', 'description', 'short_description'];


    public function toVariantProducts()
    {
        
         return $this->hasMany(Variant_product::class, 'product_id');
    }

    public function productImages()
    {
        
         return $this->hasMany(Product_image::class, 'product_id' );
    }

    function comments(){
     return $this->hasMany(Comment::class,  'product_id' );
 }
}
