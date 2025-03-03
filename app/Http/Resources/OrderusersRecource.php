<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderusersRecource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [ 
            "building_number"=>$this->building_number,
        "total_price"=>$this->total_price,
        "user_phone"=>$this->user_phone,
    
        "country"=>$this->country,
        "payment_method"=>$this->payment_method,
        "created_at"=>$this->created_at,
        ];
    }
}
