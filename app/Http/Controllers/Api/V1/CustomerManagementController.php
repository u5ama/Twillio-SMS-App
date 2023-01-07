<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CustomerWallet;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;

class CustomerManagementController extends Controller
{
    public function addCustomerWallet(Request $request){
        try {
            Log::info('app.requests', ['request' => $request->all(),'URL'=>$request->url()]);
            $token = JWTAuth::getToken();
            $user = JWTAuth::toUser($token);

            $validator = Validator::make($request->all(), [
                'fname' => 'required',
                'lname' => 'required',
                'address' => 'required',
                'city' => 'required',
                'province' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'bank' => 'required',
                'account_number' => 'required',
            ]);

            if ($validator->fails()) {
                $errors = $validator->messages();
                return response()->json(compact('errors'), 401);
            }

            $wallet = CustomerWallet::updateOrCreate([
                'user_id' => $user->id
            ],[
                'fname' => $request->fname,
                'lname' => $request->lname,
                'address' => $request->address,
                'city' => $request->city,
                'province' => $request->province,
                'email' => $request->email,
                'phone' => $request->phone,
                'bank' => $request->bank,
                'account_number' => $request->account_number,
            ]);

            return response()->json(['success' => true,'wallet'=>$wallet], 200);
        }
        catch(\Exception $e){
            $message = $e->getMessage();
            $error = ['field'=>'customer_data','message'=>$message];
            $errors =[$error];
            return response()->json(['success'=>false,'code'=>'500','errors' => $errors], 500);
        }
    }

    public function getCustomerWallet(Request $request){
        try {
            Log::info('app.requests', ['request' => $request->all(),'URL'=>$request->url()]);
            $token = JWTAuth::getToken();
            $user = JWTAuth::toUser($token);

            $wallet = CustomerWallet::where('user_id', $user->id)->first();
            return response()->json(['success' => true,'wallet'=>$wallet], 200);
        }
        catch(\Exception $e){
            $message = $e->getMessage();
            $error = ['field'=>'getCustomerWallet','message'=>$message];
            $errors =[$error];
            return response()->json(['success'=>false,'code'=>'500','errors' => $errors], 500);
        }
    }

    public function deleteCustomerWallet(Request $request){
        try {
            Log::info('app.requests', ['request' => $request->all(),'URL'=>$request->url()]);
            $token = JWTAuth::getToken();
            $user = JWTAuth::toUser($token);

            CustomerWallet::where('user_id', $user->id)->delete();

            return response()->json(['success' => true,'message'=> 'Wallet removed Successfully!'], 200);
        }
        catch(\Exception $e){
            $message = $e->getMessage();
            $error = ['field'=>'deleteCustomerWallet','message'=>$message];
            $errors =[$error];
            return response()->json(['success'=>false,'code'=>'500','errors' => $errors], 500);
        }
    }

}
