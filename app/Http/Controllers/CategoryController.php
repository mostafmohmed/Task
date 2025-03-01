<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use App\Http\Requests\Categoryrequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function get(){
        $category=Category::all();
        return apiresponse(200,'all category',new CategoryCollection( $category) );
    }
    public function create(Categoryrequest $request){
        
        $category=Category::create($request->except('image','_token'));
        if ($request->hasFile('image')) {
            $file=$request->image;
            $filename = Str::random().time().$file->getClientOriginalExtension();
            $path = $file->storeAs('',$filename ,['disk'=>'category'] );
            $category->update([
                'image'=> $filename
            ]);
        }
      
        return apiresponse(200,'create category sucess',   CategoryResource::make( $category)  );
    }
    public function delete($id){
       $category= Category::find($id);
       if (!$category) {
       return apiresponse(404,'category not found');
       }
       $path = public_path().'/uploads/category/'.$category->image;
      
   if (File::exists( $path )) {
       File::delete( $path );
       # code...;
   }
       $category->delete();
    }
    public function update($id,Categoryrequest $request){
        $category= Category::find($id);
        if (!$category) {
        return apiresponse(404,'category not found');
        }
                               

if ($request->hasFile('image')) {
 
        $path = public_path().'/uploads/category/'.$category->image;
        $file=$request->image;
    if (File::exists( $path )) {
        File::delete( $path );
        # code...;
    }
    $filename = Str::random().time().$file->getClientOriginalExtension();
    $path = $file->storeAs('/',$filename ,['disk'=>'category'] );
    $category->update([
        'image'=> $filename
    ]);

}
if (!$request->hasFile('image')) {
      
    $category->update($request->except('_token','image'));
}
return apiresponse(200,'update category sucess');



       
        
     }
}
