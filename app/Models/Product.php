<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    // protected $key   = 'code'; // Si deseo que 'code' sea la primary key 
    protected $fillable =  ['code', 'name', 'description', 'price', 'url_image', 'like', 'dislike', 'user_id'];
    protected $hidden   =  ['created_at', 'updated_at'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}

