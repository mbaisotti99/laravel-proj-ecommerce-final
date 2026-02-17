<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Ship extends Model
{
    public function invoice(){
        return $this->belongsToMany(Invoice::class);
    }
}
