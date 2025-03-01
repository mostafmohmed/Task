<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;

use App\Http\Requests\Produectrequest;
use App\Http\Resources\ProduectCollection;
use App\Http\Resources\Produectresource;
use App\ImageManger;
use App\Models\Produect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProduectController extends Controller
{




  


    public function generateImageName($image)
    {
        $file_name = Str::uuid() . time() . $image->getClientOriginalExtension();
        return $file_name;
    }
    private function storeImageInLocal($image , $path , $file_name , $disk)
    {
         $image->storeAs($path , $file_name , ['disk'=>$disk]);
    }
   
    public function delete($id){
        $Produect= Produect::find($id);
        if (!$Produect) {
        return apiresponse(404,'Produect not found');
        }
        if ( $Produect->images) {
            
            // $this->image->deleteImageFromLocal();
   foreach ($Produect->images as  $image) {
    $image_path = '/uploads/produect/'.$image->name_Image;
    if (File::exists(public_path($image_path))) {
        File::delete(public_path($image_path));
    }
    $Produect->delete();

    # code...
   }
          
               
        
        }

        return apiresponse(200,'delete sucess');

    }
    public function update($id,Request $request){
        $Produect=Produect::find($id);
        if (!$Produect) {
            return apiresponse(404,'Produect not found');
            }
            if ($request->hasFile('images')) {

foreach( $Produect->images as $image){
    $path = public_path().'/uploads/produect/'.$image->name_Image;

if (File::exists( $path )) {
    File::delete( $path );
    # code...;
}
}

                foreach($request->file('images') as $image){


                    $file_name = $this->generateImageName($image);

                    $Produect->images()->update([ 
                        'name_Image'=>$file_name,
                    ]);
                    $this->storeImageInLocal($image , '/' , $file_name , 'produect');
    
                    
                }
               
                   
            }
            $Produect->update($request->except('images'));
            return apiresponse(200,'update sucess',  $Produect);
    }
    public function get(){
        $produect=Produect::with('images')-> get();
        return apiresponse(200,'all produect ',new ProduectCollection( $produect) );
    }
    public function create( Produectrequest $request){
     
      $Produect=      Produect::create([
                'name_ar'=>$request->name_ar,
                'name_en'=>$request->name_en,
                'des_en'=>$request->des_en,
                'des_ar'=>$request->des_ar,
                'status'=>$request->status,
                'discount'=>$request-> discount,
                'price'=>$request->price,
                 'discount_price'=>$request-> discount?$request->price - ($request->price * ($request-> discount / 100)):null,
                 'quantity'=>$request->quantity

            ]) ;
            if ($request->hasFile('images')) {
               
                
                foreach($request->file('images') as $image){

                    $file_name = $this->generateImageName($image);
                  
                    $this->storeImageInLocal($image , '/' , $file_name , 'produect');
    
                    $Produect->images()->create([ 
                        'name_Image'=>$file_name,
                    ]);
                }
                    
                        
                  
               

            
            }
            return apiresponse(200,'create produect susess ', Produectresource::make( $Produect) );
    }
}
