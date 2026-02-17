<?php

namespace App\Models;

use App\Categorie;
use MongoDB\Laravel\Eloquent\Model;

class Product extends Model
{
    protected $casts = [
        'categorie' => Categorie::class,
        "taglie" => "array",
    ];  
    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function invoices(){
        return $this->belongsToMany(Invoice::class);
    }
}
