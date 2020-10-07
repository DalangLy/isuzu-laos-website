<?php

namespace App\Http\Controllers;

use App\Mail\TestDriveMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Kreait\Firebase\Factory;
use RealRashid\SweetAlert\Facades\Alert;

class TestDriveController extends Controller
{
    public function submitTestDriveEmail(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'surname' => 'required',
            'tel'=> 'required',
            'email' => 'required|email',
            'dcheckbox1'=>'required',
            'dradio' => 'required'
        ]);

        $data = array();
        $data['name'] = $request->name;
        $data['surname'] = $request->surname;
        $data['tel'] = $request->tel;
        $data['email'] = $request->email;
        $data['dcheckbox1'] = $request->dcheckbox1;
        $data['dradio'] = $request->dradio;

        //Mail::to(['panharith@oxygenkh.com','dalang@oxygenkh.com', 'leaphea@oxygenkh.com', 'a_pisutthida@tripetch-isuzu.co.th'])->send(new TestDriveMail($data));
        Mail::to(['dalangly@gmail.com'])->send(new TestDriveMail($data));

        Alert::success('Sent!', "We appreciate you contacting Isuzu Laos. One of our colleagues will get back in touch with you soon! Have a great day!");
        return back();
    }

    public function show(){
        $firebase = (new Factory)
            ->withServiceAccount(__DIR__.'/dsys-721ca-05894e5e8fd8.json')
            ->withDatabaseUri('https://dsys-721ca.firebaseio.com/')
            ->createDatabase();

        $database = $firebase->getReference('isuzu/test_drive');
        foreach ($database->getSnapshot()->getValue() as $item){
            dd($item);
        }
    }
}
