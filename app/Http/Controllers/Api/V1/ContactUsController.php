<?php

namespace App\Http\Controllers\Api\V1;


use App\Models\ContactUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class ContactUsController extends Controller
{
    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $user_id = $user->id;

        $validator = Validator::make($request->all(), [
            'message' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 403);
        }

        $contact_us = new ContactUs();
        $contact_us->user_id = $user_id;
        $contact_us->message = $request->input('message');
        $contact_us->save();

        
        return response()->json([
            'message' => Config('languageString.contact_message_thank_you_message'),
        ], 200);

    }

}
