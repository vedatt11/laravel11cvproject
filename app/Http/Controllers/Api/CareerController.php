<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Career;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function index()
    {
        $careers=Career::all();
        return response()->json($careers);
    }
    public function store(Request $request){
        return $this->saveCareer($request);
    }
    public function update(Request $request , $id){
        return $this->saveCareer($request ,$id);
    }





private function saveCareer(Request $request, $id=null)
{
     $validedData = $request->validate([
        'title'=> 'required|string',
        'company'=>'required|string',
        'start_date'=>'required|date',
        'end_date'=>'nullable|date',
        'description'=> 'nullable|string'

     ]);
     $startDate= Carbon::parse($validedData['start_date'])->format('Y-m-d');
     $end_Date= isset($validedData['end_date']) ? Carbon::parse($validedData['end_date'])->format('Y-m-d'):null;
     if ($request->hasFile('image')) {

        //  unlink(public_path('images/'.$career->image));
         $resim = $request->image;
         $resimadi = rand(0,100) . '.' . $resim->getClientOriginalExtension();
         $resim->move(public_path("images"), $resimadi);

     }
     $career = isset($id) ? Career::find($id) : Career::create(  [
        'title'=> $validedData['title'],
        'company'=>$validedData['company'],
       'start_date'=>$startDate,
       'end_date'=>$end_Date,
       'description'=> $validedData['description'],
        'status'=> $request->status ?? !empty($end_Date) ? 0 : 1,
        "image"=>'images/'.$resimadi,
    ]);
     if (is_null($career)) {
         return response()->json(['message' => 'Kariyer Bulunamadı'], 404);
     }


     if(isset($id) ){
        unlink(public_path($career->image));
        $career->update(
            [
                'title'=> $validedData['title'],
                'company'=>$validedData['company'],
               'start_date'=>$startDate,
               'end_date'=>$end_Date,
               'description'=> $validedData['description'],
                'status'=> $request->status ?? !empty($end_Date) ? 0 : 1,
                "image"=>'images/'.$resimadi,
            ]
        );
     }

     return response()->json(['message' => !empty($id) ? 'Basaroyla Gıncellendi' : 'Basarıyla Kaydedildi'],200);



}
}



