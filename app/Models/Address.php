<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Address extends Model
{
    public function invoices(){
        return $this->belongsToMany(Invoice::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
