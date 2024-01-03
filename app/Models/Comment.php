<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    public $fillable=['product_id', 'user_id', 'comment', 'rating'];

    function user(){
        return $this->hasOne(User::class, 'id', 'user_id' );
    }
    function userBelongsToExample(){
        return $this->hasOne(User::class, 'user_id' );
    }
}
