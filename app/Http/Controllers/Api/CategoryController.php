<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories=Category::orderBy('ID','desc') ->paginate(20);
        return response()->json(['tags'=>$categories],200);

    }
    public function store(Request $request)
    {
        return $this->saveCategory($request);
    }
    public function update(Request $request, $id=null)
    {
        return $this->saveCategory($request,$id);
    }


    private function saveCategory(Request $request, $id=null)
{
     $validedData = $request->validate([
        'name'=>'required|string',

     ]);
     $resimadi = null; // Bu satırı ekleyin

     if ($request->hasFile('image')) {

        //  unlink(public_path('images/'.$career->image));
         $resim = $request->image;
         $resimadi = rand(0,100) . '.' . $resim->getClientOriginalExtension();
         $resim->move(public_path("images"), $resimadi);

     }
     $category = isset($id) ? Category::find($id) : Category::create(  [
        'name'=> $validedData['name'],
        'status'=> $request->status ??  1,
        "image"=>'images/'.$resimadi,
    ]);
     if (is_null($category)) {
         return response()->json(['message' => 'Etiket Bulunamadı'], 404);
     }


     if(isset($id) ){
        if(isset($category->image))
        {
            unlink(filename: public_path($category->image));

        }
        $category->slug=null;
        $category->update(
            [
                'name'=> $validedData['name'],
                'status'=> $request->status ?? 1,
                "image"=>'images/'.$resimadi,
            ]
        );
     }

     return response()->json(['message' => !empty($id) ? 'Basaroyla Etiket Gıncellendi' : 'Basarıyla Etiket Olusturuldu'],200);



}
}
