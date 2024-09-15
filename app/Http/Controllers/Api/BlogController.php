<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(){
        $blogs=Blog::with('category')->orderBy('ID','desc') ->paginate(20);

        return response()->json(['blogs'=>$blogs],200);

    }
    public function blogdetail($id){
        $blog=Blog::where('id',$id) ->with('category')->first();

        return response()->json(['blog'=>$blog],200);

    }
    public function store(BlogRequest $request)
    {
        return $this->saveCategory($request);
    }
    public function update(BlogRequest $request, $id=null)
    {
        return $this->saveCategory($request,$id);
    }


    private function saveCategory( BlogRequest $request, $id=null)
{
    //  $validedData = $request->validate([
    //     'name'=>'required|string',

    //  ]);
     $resimadi = null; // Bu satırı ekleyin

     if ($request->hasFile('image')) {

        //  unlink(public_path('images/'.$career->image));
         $resim = $request->image;
         $resimadi = rand(0,100) . '.' . $resim->getClientOriginalExtension();
         $resim->move(public_path("images"), $resimadi);

     }
     $blog = isset($id) ? Blog::find($id) : Blog::create(  [
        'name'=> $request->name,
        'content'=>$request->input('content'),
        'category_id'=>$request->category_id,
        'status'=> $request->status ??  1,
        "image"=>'images/'.$resimadi,
    ]);
     if (is_null($blog)) {
         return response()->json(['message' => 'Blog Bulunamadı'], 404);
     }


     if(isset($id) ){
        if(isset($category->image))
        {
            unlink(filename: public_path($blog->image));

        }
        $blog->slug=null;
        $blog->update(
            [
                'name'=> $request->name,
                'status'=> $request->status ?? 1,
                'content'=>$request->input('content'),
                 'category_id'=>$request->category_id,
                "image"=>'images/'.$resimadi,
            ]
        );
     }

     return response()->json(['message' => !empty($id) ? 'Basaroyla Blog Gıncellendi' : 'Basarıyla Blog Olusturuldu','data'=>$blog],200);



}
}
