<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(){
        $projects=Project::with('category')->orderBy('ID','desc') ->paginate(20);

        return response()->json(['blogs'=>$projects],200);

    }
    public function projectdetail($id){
        $project=Project::where('id',$id) ->with('category')->first();

        return response()->json(['blog'=>$project],200);

    }
    public function store(ProjectRequest $request)
    {
        return $this->saveCategory($request);
    }
    public function update(ProjectRequest $request, $id=null)
    {
        return $this->saveCategory($request,$id);
    }


    private function saveCategory( ProjectRequest $request, $id=null)
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
     $project = isset($id) ? Project::find($id) : Project::create(  [
        'name'=> $request->name,
        'content'=>$request->input('content'),
        'category_id'=>$request->category_id,
        'finish_time'=>Carbon::parse(time: $request->finish_time)->format('Y-m-d'),
        'link'=>$request->link,
        'tags'=>$request->tags,

        'status'=> $request->status ??  1,
        "image"=>'images/'.$resimadi,
    ]);
     if (is_null($project)) {
         return response()->json(['message' => 'Proje Bulunamadı'], 404);
     }


     if(isset($id) ){
        if(isset($category->image))
        {
            unlink(filename: public_path($project->image));

        }
        $project->slug=null;
        $project->update(
            [
                'name'=> $request->name,
                'status'=> $request->status ?? 1,
                'content'=>$request->input('content'),
                 'category_id'=>$request->category_id,
                 'finish_time'=>Carbon::parse(time: $request->finish_time)->format('Y-m-d'),
                 'link'=>$request->link,
                 'tags'=>$request->tags,
                "image"=>'images/'.$resimadi,
            ]
        );
     }

     return response()->json(['message' => !empty($id) ? 'Basaroyla Proje Gıncellendi' : 'Basarıyla Proje Olusturuldu','data'=>$project],200);



}
}
