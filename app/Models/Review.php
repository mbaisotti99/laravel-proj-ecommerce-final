<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Review extends Model
{
    public function product() {
        return $this->belongsTo(Product::class);
    }
}
