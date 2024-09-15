<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Mail;

class ContactController extends Controller
{
    public function index()
    {
        $contacts=Contact::paginate(20);
        return response()->json(['message'=>'basarıyla listelendi','data'=>$contacts],200);
    }

    public function store(Request $request)
    {
        $validedData = $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'phone'=>'nullable',
            'subject'=>'nullable',
            'body'=>'nullable',
            'status'=>'nullable',

        ]);
        $validedData['ip']=request()->ip();
        $contact=Contact::create($validedData);
        return response()->json(['message'=>'Mesajınız Basarıyla Gönderildi','data'=>$contact],200);
    }

    public function mailSend(Request $request)
    {
        $subject=$request->input('subject');
        $message=$request->input('message');
        $email=$request->input('email');
        $contact=Contact::where('email',$email)->first();

        if(empty( $contact))
        {
            return response()->json(['message'=> 'Mail Bulunamadı'],404);

        }

        $contact->message=$message;
        Mail::to($email)->send(new ContactMail($subject,$contact));
        return response()->json(['message'=> 'Mail Basaroyla Gönderildi'],200);





    }
}
