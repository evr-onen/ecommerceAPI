<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant_product extends Model
{
    use HasFactory;
    public $fillable=['product_id', 'price', 'discount_flat', 'discount_percent', 'stock'];

    
    public function toProduct()
    {
        
         return $this->belongsTo(Product::class, 'product_id');
    }
    
    public function toPivotProps()
    {
        
         return $this->hasMany(Pivot_variant_product::class, 'variant_product_id');
    }


}
