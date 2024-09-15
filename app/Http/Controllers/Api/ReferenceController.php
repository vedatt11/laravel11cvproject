<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reference;
use Illuminate\Http\Request;

class ReferenceController extends Controller
{
    public function index(){
        $references=Reference::orderBy('ID','desc') ->paginate(20);
        return response()->json(['References'=>$references],200);

    }
    public function store(Request $request)
    {
        return $this->saveReference($request);
    }
    public function update(Request $request, $id=null)
    {
        return $this->saveReference($request,$id);
    }

    public function referencedetail($id){
        $Reference=Reference::where('id',$id) ->first();

        return response()->json(['Reference'=>$Reference],200);

    }


    private function saveReference(Request $request, $id=null)
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
     $Reference = isset($id) ? Reference::find($id) : Reference::create(  [
        'name'=> $validedData['name'],
        'status'=> $request->status ??  1,
        'link'=>$request->link ?? '#',
        "image"=>'images/'.$resimadi,
    ]);
     if (is_null($Reference)) {
         return response()->json(['message' => 'Reference Bulunamadı'], 404);
     }


     if(isset($id) ){
        if ($Reference->image && file_exists(public_path($Reference->image))) {
            unlink(public_path($Reference->image));
        }

        $Reference->update(
            [
                'name'=> $validedData['name'],
                'status'=> $request->status ?? 1,
                'link'=>$request->link ?? '#',

                "image"=>'images/'.$resimadi,
            ]
        );
     }

     return response()->json(['message' => !empty($id) ? 'Basaroyla Referance Gıncellendi' : 'Basarıyla Referance Olusturuldu'],200);



}
}
