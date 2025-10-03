<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCart extends Model
{
    public function get_product(){
        return $this->hasOne(Product::class,'id','product_id');
    }

    public function get_user(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
