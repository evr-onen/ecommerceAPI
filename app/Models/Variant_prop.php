<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Variant_prop extends Model
{
    use HasFactory;

    public $fillable=['variant_type_id', 'name'];

  

    public function toVariantType()
    {
        
         return $this->belongsTo(Variant_type::class, 'variant_type_id');
    }

    public function toPivotVariantProducts()
    {
        
         return $this->hasMany(Pivot_variant_product::class, 'variant_prop_id');
    }

}
