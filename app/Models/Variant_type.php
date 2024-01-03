<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Variant_prop;

class Variant_type extends Model
{
    use HasFactory;

    public $fillable=[ 'name'];

    public function toVariantProp()
    {
        return $this->hasMany(Variant_prop::class, 'variant_type_id');
    }
}
