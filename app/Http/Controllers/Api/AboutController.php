<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $content = About::first();

        if ($content) {
            return response()->json($content, 200); // JSON formatında yanıt döndürür
        } else {
            return response()->json(['message' => 'Veri bulunamadı'], 404); // JSON formatında hata mesajı döndürür
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

        ]);
        $content= About::first();
        if ($request->hasFile('image')) {
            unlink(public_path($content->image));
            $resim = $request->image;
            $resimadi = rand(0,100) . '.' . $resim->getClientOriginalExtension();
            $resim->move(public_path("images"), $resimadi);

            $request->merge(['image' => "vedat"]);
        }
        else{
            return response()->json(['message'=> 'Resim Bulunamadı'],404);

        }
        $content->update(
            [
                "title"=>$request->title,
                "image"=>'images/'.$resimadi,
            ]
        );
        return response()->json(['message'=> 'Basarıyla Guncellendi','data'=>$content],200);

    }
}
