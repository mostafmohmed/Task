<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produect extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function images(){
        return $this->hasMany(Produect_Image::class,'produect_id');
    }
}

