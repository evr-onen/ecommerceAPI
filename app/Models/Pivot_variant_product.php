<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pivot_variant_product extends Model
{
    use HasFactory;
    public $fillable=['variant_product_id', 'variant_prop_id'];

    public function toVariantPropFromPivotProduct()
    {
        
         return $this->belongsTo(Variant_prop::class, 'variant_prop_id');
    }
}
