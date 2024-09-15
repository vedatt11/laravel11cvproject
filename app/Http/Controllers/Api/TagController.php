<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(){
        $tags=Tag::orderBy('ID','desc') ->paginate(20);
        return response()->json(['tags'=>$tags],200);

    }
    public function store(Request $request)
    {
        return $this->saveTag($request);
    }
    public function update(Request $request, $id=null)
    {
        return $this->saveTag($request,$id);
    }

    public function Tagdetail($id){
        $tag=Tag::where('id',$id) ->first();

        return response()->json(['tag'=>$tag],200);

    }


    private function saveTag(Request $request, $id=null)
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
     $tag = isset($id) ? Tag::find($id) : Tag::create(  [
        'name'=> $validedData['name'],
        'status'=> $request->status ??  1,
        "image"=>'images/'.$resimadi,
    ]);
     if (is_null($tag)) {
         return response()->json(['message' => 'Etiket Bulunamadı'], 404);
     }


     if(isset($id) ){
        if ($tag->image && file_exists(public_path($tag->image))) {
            unlink(public_path($tag->image));
        }
         $tag->slug=null;

        $tag->update(
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
