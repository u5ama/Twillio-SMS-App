<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\BuyGift;
use App\Models\CustomerInvoices;
use App\Models\GiftsNotifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class DriverController extends Controller
{

    public function redeemGift(Request $request)
    {
        try {
            $token = JWTAuth::getToken();
            $user = JWTAuth::toUser($token);
            Log::info('app.requests', ['request' => $request->all(), 'URL' => $request->url()]);

            $validator = Validator::make($request->all(), [
                'fan_id' => 'required',
                'gift_id' => 'required',
            ]);

            if ($validator->fails()) {
                $errors = $validator->messages();
                return response()->json(compact('errors'), 401);
            }

            if ($request->payment_status == 'success'){

                BuyGift::where(['gift_id'=> $request->gift_id, 'player_id' => $user->id])->update([
                    'gift_status' => 'redeem',
                ]);

                CustomerInvoices::create([
                    'player_id' => $user->id,
                    'gift_id' => $request->gift_id,
                    'user_id' => $request->fan_id,
                    'invoice_status' => 'redeem',
                    'amount' => $request->total_amount_charged,
                ]);

                GiftsNotifications::create([
                    'user_id' => $request->fan_id,
                    'sender_id' => $user->id,
                    'title' => 'Gift Received',
                    'message' => 'Gift sent is Received! Thanks',
                ]);

                $message = "Gift successfully redeemed!";
                return response()->json(['success'=>true,'message'=>$message ], 200);
            }else{
                $message = "Gift Not redeemed!";
                return response()->json(['success'=>false,'message'=>$message ], 200);
            }

        } catch (\Exception $e) {
            $message = $e->getMessage();
            $error = ['field'=>'error','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
