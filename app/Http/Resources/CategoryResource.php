<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
        'image'=>  asset('uploads/category/') .$this->image
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
