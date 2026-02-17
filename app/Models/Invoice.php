<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Invoice extends Model
{

    protected $fillable = ['status'];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function address(){
        return $this->belongsTo(Address::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class)->withPivot( "taglia", "quantita");
    }

    public function ship(){
        return $this->belongsTo(Ship::class);
    }
}
