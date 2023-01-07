<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\GiftsNotifications;
use App\Utility\Utility;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{

    public function loginUser(Request $request)
    {
        try {
            Log::info('app.requests', ['request' => $request->all(),'URL'=>$request->url()]);
            $messages = [
                'mobile_no' => 'required',
            ];
            $validator = Validator::make($request->all(), $messages);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()->first()
                ], 401);
            }

            $user = User::where(['mobile_no'=>$request->mobile_no])->first();
            if (!$user) {
                return response()->json(['success'=>false, 'message' => 'Login Fail, please check email']);
            }
//            $password = $request->password;
//
//            if(!Hash::check($password, $user->password)) {
//                return response()->json(['success'=>false, 'message' => 'Login Fail, please check password']);
//            }
            $token=JWTAuth::fromUser($user);

            User::where('id',$user->id)->update(['user_JWT_Auth_Token'=>$token]);

            $user_data = User::getuser($user->id);

            return response()->json([
                'success' => true,
                'new_user' => false,
                'user' => $user_data,
                'token' => $token
            ], 200);

        }catch(\Exception $e){
            $message = $e->getMessage();
            $error = ['field'=>'driver_login','message'=>$message];
            $errors =[$error];
            return response()->json(['success'=>false,'code'=>'500','errors' => $errors], 500);
        }
    }

    public function register(Request $request)
    {
        try {
            Log::info('app.requests', ['request' => $request->all(),'URL'=>$request->url()]);
            $validator = Validator::make($request->all(), [
                'full_name' => 'required',
                'mobile_no' => 'required',
                'age' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = $validator->messages();
                return response()->json(compact('errors'), 401);
            }

            if(User::where(['mobile_no'=>$request->mobile_no])->exists()) {

                    $user = User::where(['mobile_no'=>$request->mobile_no])->first();
                    $token=JWTAuth::fromUser($user);
                    User::where('id',$user->id)->update(['user_JWT_Auth_Token'=>$token]);

                    $otp = rand(1000, 9999);
                    User::where('id',$user->id)->update(['verification_code'=>$otp,"otp_verified" => 0]);

                    $message_sms = "<#> QR app PIN: ".$otp.". Never share this PIN with anyone. No one will call you to ask for this.";
                    $user_number = $request->mobile_no;
                    $sendSMS = Utility::sendSMS($message_sms,$user_number);

                    return response()->json([
                        'otp' => $otp,
                        'token' => $token,
                    ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                        'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);

            }else {
                $user = new User();
                $user->name = $request->full_name;
                $user->mobile_no = $request->mobile_no;
                $user->age = $request->age;

                $user->user_type = 'user';
                $user->password = bcrypt($request->password);
                $user->status = 'InActive';
                $user->save();

                if(isset($user->user_JWT_Auth_Token) && $user->user_JWT_Auth_Token != null) {
                    $newToken = JWTAuth::manager()->invalidate(new \Tymon\JWTAuth\Token($user->user_JWT_Auth_Token), $forceForever = false);
                }

                $token=JWTAuth::fromUser($user);
                User::where('id',$user->id)->update(['user_JWT_Auth_Token'=>$token]);

                $otp = rand(1000, 9999);
                User::where('id',$user->id)->update(['verification_code'=>$otp,"otp_verified" => 0]);

                $message_sms = "<#> QR app PIN: ".$otp.". Never share this PIN with anyone. No one will call you to ask for this.";
                $user_number = $request->mobile_no;
                $sendSMS = Utility::sendSMS($message_sms,$user_number);

                return response()->json([
                    'otp' => $otp,
                    'token' => $token,
                ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }

        }catch(\Exception $e){
            $message = $e->getMessage();
            $error = ['field'=>'user_not_created','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    public function verifyOTP(Request $request)
    {
        try {
            $token = JWTAuth::getToken();
            $user = JWTAuth::toUser($token);

            Log::info('app.requests', ['request' => $request->all(),'URL'=>$request->url()]);
            $validator = Validator::make($request->all(), [
                'otp' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = $validator->messages();
                return response()->json(compact('errors'), 401);
            }

            $userData = User::where(['id'=>$user->id, 'verification_code'=>$request->otp])->update(["otp_verified" => 1]);
            if ($userData)
            {
                $token=JWTAuth::fromUser($user);
                User::where('id',$user->id)->update(['user_JWT_Auth_Token'=>$token]);
                $user_data = User::getuser($user->id);

                return response()->json([
                    'token' => $token,
                    'user' => $user_data,
                ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'OTP not verified!',
                ], 401, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }


        }catch(\Exception $e){
            $message = $e->getMessage();
            $error = ['field'=>'user_not_created','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
    /**
     * User edit Profile
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */

    public function editProfile(Request $request)
    {
        try {
            $token = JWTAuth::getToken();
            $user = JWTAuth::toUser($token);
            Log::info('app.requests', ['request' => $request->all(),'URL'=>$request->url()]);

            if(isset($request->profile_pic) && !empty($request->profile_pic) && $request->hasFile('profile_pic')){
                if($user->profile_pic != "assets/default/user.png") {
                    @unlink(public_path() . '/' . $user->profile_pic);
                }
                $mime= $request->profile_pic->getMimeType();
                $image = $request->file('profile_pic');
                $image_name =  preg_replace('/\s+/', '', $image->getClientOriginalName());
                $ImageName = time() .'-'.$image_name;
                $image->move('./assets/user/profile_pic/', $ImageName);
                $path_image = 'assets/user/profile_pic/'.$ImageName;
                $update = User::where('id', $user->id)->update(['profile_pic' => $path_image]);
            }

            if(isset($request->full_name) && !empty($request->full_name)){
                $update = User::where('id', $user->id)->update(['name' => $request->full_name]);
            }

            if(isset($request->mobile_no) && !empty($request->mobile_no)){

                if(User::where(['mobile_no'=>$request->mobile_no])->exists()){
                    $message = "Mobile Number Already exist";
                    $error = ['field'=>'profile_not_edit','message'=>$message];
                    $errors =[$error];
                    return response()->json(['errors' => $errors], 401);
                }else {
                    $update = User::where('id', $user->id)->update(['mobile_no' => $request->mobile_no, 'mobile_number_verified' => 0]);
                }

                if($update){
                    return response()->json([
                        'mobile_no'=> $request->mobile_no,
                    ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                        'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);

                }else{
                    $message = "Profile not edited";
                    $error = ['field'=>'user_profile_not_edit','message'=>$message];
                    $errors =[$error];
                    return response()->json(['errors' => $errors], 401);
                }
            }
            if(isset($request->email) && !empty($request->email)) {
                if (User::where(['email' => $request->email])->exists()) {
                    $message = "Email already exist";
                    $error = ['field' => 'p_email_already_exist', 'message' => $message];
                    $errors = [$error];
                    return response()->json(['errors' => $errors], 401);
                } else {
                    $messages = [
                        'required' => 'the_field_is_required'
                    ];
                    $validator = Validator::make($request->all(), [
                        'email' => 'required',
                    ], $messages);
                    if ($validator->fails()) {
                        $errors = $validator->messages();
                        return response()->json(compact('errors'), 401);
                    }
                    $update = User::where('id', $user->id)->update(['email' => $request->email]);
                }
            }
            if(isset($request->description)){
                $update = User::where('id', $user->id)->update(['description' => $request->description]);
            }

            if(isset($request->address)){
                $update = User::where('id', $user->id)->update(['address' => $request->address]);
            }

            return response()->json([
                'user' => User::getuser($user->id)
            ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);

        }catch(\Exception $e){
            $message = $e->getMessage();
            $error = ['field'=>'error','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    public function logout(Request $request)
    {
        Log::info('app.requests', ['request' => $request->all()]);
        try {
            $token = JWTAuth::getToken();
            JWTAuth::invalidate($token);
            $message = "User logout successfully!";
            return response()->json(['message'=>$message ], 200);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $error = ['field'=>'error','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }


    public function postNotifications(Request $request)
    {
        try {
            $token = JWTAuth::getToken();
            $user = JWTAuth::toUser($token);
            Log::info('app.requests', ['request' => $request->all(), 'URL' => $request->url()]);

            GiftsNotifications::create([
                'user_id' => $request->reciever_id,
                'sender_id' => $request->sender_id,
                'title' =>  $request->title,
                'message' =>  $request->message,
            ]);

            $message = "Notification successfully sent!";
            return response()->json(['success'=>true,'message'=>$message ], 200);

        } catch (\Exception $e) {
            $message = $e->getMessage();
            $error = ['field'=>'error','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

}
