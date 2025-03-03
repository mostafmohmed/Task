<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    // Relationship with OrderItem (e.g. many-to-many)
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class,'prodect_id');
    }
}
