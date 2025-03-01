<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Produectresource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         $data=[
            'status'=>$this->status,
          'price'=>$this->price,
          'quantity'=>$this->quantity,
          'discount_price'=>$this->discount_price,
         
          'images'=>  CategoryResource::collection($this->images)  
         ];
         if (app()->getLocale()=='en') {
            $data['name_en']=$this->name_en;
            $data['des_en']=$this->des_en;
           
         }
         if (app()->getLocale()=='ar') {
            $data['name_ar']=$this->name_ar;
            $data['des_ar']=$this->des_ar;
            
         }
         return $data;
    }
}
