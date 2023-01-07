<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Helpers\SendSmsHelper;
use App\Http\Requests\API\RegisterWithEmailJobSeeker;
use App\Http\Requests\API\YourBusinessProfileRequest;
use App\Mail\ResetPasswordEmail;
use App\Http\Requests\API\AppleLoginRequest;
use App\Http\Requests\API\FacebookLoginRequest;
use App\Http\Requests\API\GoogleLoginRequest;
use App\Http\Requests\API\ConfirmOtpRequest;
use App\Http\Requests\API\LoginWithMobileNoRequest;
use App\Http\Requests\API\LoginWithEmailRequest;
use App\Http\Requests\API\LoginOtpRequest;
use App\Models\LanguageString;
use App\Models\UserBusinessProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPasswordMail;
use App\Http\Requests\API\ForgotPasswordRequest;
use App\Http\Requests\API\ResetPasswordRequest;
use App\Http\Requests\API\RegisterWithEmailRequest;
use App\Http\Requests\API\RegisterWithMobileNoRequest;
use App\Models\User;
use App\Models\Device;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function registerWithEmailBusinessMan(RegisterWithEmailRequest $request)
    {

        $validated = $request->validated();
        if($validated['app_mode'] == 'business_mode') {
            $user = new User();
            $user->email = $validated['email'];
            $user->password = Hash::make($validated['password']);
            $user->is_business_man = 1;
            $user->app_mode = 'business_mode';
            $user->locale = $request->header('Accept-Language');
            $user->status = 'Active';
            $user->save();

            $token = JWTAuth::fromUser($user);

            $device = new Device();
            $device->user_id = $user->id;
            $device->device_type = $request->device_type;
            $device->device_token = $request->device_token;
            $device->device_u_id = $request->device_u_id;
            $device->save();

            $userPorfile = UserBusinessProfile::updateOrCreate(['user_id' => $user->id],
                [
                    'business_name' => $request->business_name,
                    'user_id' => $user->id
                ]
            );
        }
        if($validated['app_mode'] == 'job_seeker_mode'){

            $user = new User();
            $user->email = $validated['email'];
            $user->password = Hash::make($validated['password']);
            $user->is_job_seeker = 1;
            $user->app_mode = 'job_seeker_mode';
            $user->name = $request->name;
            $user->locale = $request->header('Accept-Language');
            $user->status = 'Active';
            $user->save();

            $token = JWTAuth::fromUser($user);

            $device = new Device();
            $device->user_id = $user->id;
            $device->device_type = $request->device_type;
            $device->device_token = $request->device_token;
            $device->device_u_id = $request->device_u_id;
            $device->save();

        }
        if($validated['app_mode'] != 'business_mode' && $validated['app_mode'] != 'job_seeker_mode'){

            $message = LanguageString::translated()->where('name_key','error')->first()->name;
            $error = ['field'=>'app_mode','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 403);
        }
        return response()->json([
            'token' => $token,
            'user'  => User::getUser($user->id),
        ], 200);

    }

    public function registerWithEmailJobSeeker(RegisterWithEmailJobSeeker $request)
    {

        $validated = $request->validated();

        $user = new User();
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->user_type = 'job_seeker';
        $user->locale = $request->header('Accept-Language');
        $user->status = 'Active';
        $user->name = $validated['name'];
        $user->save();

        $token = JWTAuth::fromUser($user);

        $device = new Device();
        $device->user_id = $user->id;
        $device->device_type = $request->device_type;
        $device->device_token = $request->device_token;
        $device->device_u_id = $request->device_u_id;
        $device->save();


        return response()->json([
            'token' => $token,
            'user'  => User::getUser($user->id),
        ], 200);

    }
    public function yourBusinessProfile(YourBusinessProfileRequest $request)
    {

        $user = JWTAuth::parseToken()->authenticate();
        $validated = $request->validated();

        if(UserBusinessProfile::where(['user_id'=>$user->id])->exists()){
            $userBusinessProfile = UserBusinessProfile::where(['user_id'=>$user->id])->first();
            $userBusinessProfile->business_type_id = $validated['type_of_business_id'];
            $userBusinessProfile->field_id = $validated['field'];
            $userBusinessProfile->number_of_employees_id = $validated['number_of_employees'];
            $userBusinessProfile->countries_of_operation = implode(',', $validated['countries_of_operation']);
            $userBusinessProfile->about_business = $validated['about_business'];
            $userBusinessProfile->save();
            $user1 = User::find($user->id);
            $user1->country_code = $validated['country_code'];
            $user1->mobile_no = $validated['mobile_no'];
            $user1->save();

        }else{
            $message = LanguageString::translated()->where('name_key','user_type_wrong')->first()->name;
            $error = ['field'=>'language_strings','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 403);
        }


        return response()->json([
            'user'  => User::getUser($user->id),
        ], 200);

    }

    public function registerWithMobileNo(RegisterWithMobileNoRequest $request)
    {

        $validated = $request->validated();

        $user = new User();
        $user->name = $validated['name'];
        $user->country_code = $validated['country_code'];
        $user->mobile_no = $validated['mobile_no'];
        $user->save();

        $token = JWTAuth::fromUser($user);


        return response()->json([
            'token' => $token,
            'otp'   => 7777,
        ], 200);

    }

    public function loginWithMobileNo(LoginWithMobileNoRequest $request)
    {

        $validated = $request->validated();

        $user = User::where('country_code', $validated['country_code'])
            ->where('mobile_no', $validated['mobile_no'])
            ->first();
        if($user){

            if($user->status == 'InActive'){
                return response()->json([
                    'message' => config('languageString.user_not_active'),
                ], 403);
            }
            return response()->json([
                'otp'     => 7777,
                'message' => config('languageString.otp_sent'),
            ], 200);
        } else{
            return response()->json([
                'message' => config('languageString.user_not_found'),
            ], 422);
        }


    }

    public function verifyOtp(LoginOtpRequest $request)
    {
        $validated = $request->validated();

        if($validated['otp'] == 7777){
            $user = User::where('country_code', $validated['country_code'])->where('mobile_no', $validated['mobile_no'])->first();
            if($user){

                $device = new Device();
                $device->user_id = $user->id;
                $device->device_type = $validated['device_type'];
                $device->device_token = $validated['device_token'];
                $device->save();

                $token = JWTAuth::fromUser($user);

                return response()->json(['token' => $token], 200);
            } else{
                return response()->json(['message' => config('languageString.user_not_found')], 422);
            }
        } else{
            return response()->json(['message' => config('languageString.invalid_otp')], 422);
        }
    }


    public function loginWithEmail(LoginWithEmailRequest $request)
    {
        $validated = $request->validated();

        $credentials = $request->only('email', 'password');
        try{
            if(!$token = JWTAuth::attempt($credentials)){
                $message = LanguageString::translated()->where('name_key','credential_not_match')->first()->name;
                $error = ['field'=>'mobile_number_not_created','message'=>$message];
                $errors =[$error];
                return response()->json(['errors' => $errors], 403);
            }
        } catch(JWTException $e){
            $message = LanguageString::translated()->where('name_key','could_not_create_token')->first()->name;
            $error = ['field'=>'could_not_create_token','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }

        $this->deleteToken($request->device_token);

        $user = User::where('email', $request->email)->first();
        if($user){
            if($user->status == 'InActive'){

                $message = LanguageString::translated()->where('name_key','user_not_active')->first()->name;
                $error = ['field'=>'mobile_number_not_created','message'=>$message];
                $errors =[$error];
                return response()->json(['errors' => $errors], 403);
            }
            $token = JWTAuth::fromUser($user);
            $this->deleteToken($request->device_token);
            $device = new Device();
            $device->user_id = $user->id;
            $device->device_type = $request->device_type;
            $device->device_token = $request->device_token;
            $device->device_u_id = $request->device_u_id;
            $device->save();
            return response()->json([
                'token' => $token,
                'user' => User::getUser($user->id),
            ], 200);
        } else{

            $message = LanguageString::translated()->where('name_key','user_not_registered')->first()->name;
            $error = ['field'=>'mobile_number_not_created','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);

        }
    }


    public function forgotPassword(Request $request)
    {
        $rules = [
            'email' => 'required|email',
        ];
        $validator = Validator::make($request->all(), $rules);


        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 403);
        }

        $user = User::where(['email' => $request->input('email')])->first();

        if($user){

            $token = Password::getRepository()->create($user);

            $array = [
                'name'                   => $user->name,
                'actionUrl'              => route('reset-password', [$token]),
                'mail_title'             => "Password Reset",
                'reset_password_subject' => "Reset your password",
                'main_title_text'        => "Password Reset",
            ];
            Mail::to($request->input('email'))->send(new ResetPasswordEmail($array));


            return response()->json([
                'message' => Config('languageString.please_check_your_mail'),
            ], 200);

        } else{
            return response()->json([
                'message' => Config('languageString.user_not_found'),
            ], 403);
        }

    }

    public function resetPassword(Request $request)
    {
        $rules = [
            'token'        => 'required',
            'new_password' => 'required|min:8|max:20',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 403);
        }

        $new_password = $request->input('new_password');
        $tokens = DB::table('password_resets')->select('email', 'token')->get();

        if(count($tokens) > 0){
            foreach($tokens as $token){
                if(Hash::check($request->input('token'), $token->token)){
                    $user = User::where('email', $token->email)->first();
                    if($user){
                        $user->password = bcrypt($new_password);
                        $user->update();

                        DB::table('password_resets')->where('email', $user->email)
                            ->delete();
                        return response()->json([
                            'message' => Config('languageString.password_reset_successfully'),
                        ], 200);

                    } else{
                        return response()->json([
                            'message' => Config('languageString.user_not_fund'),
                        ], 403);
                    }
                }
            }
        }

        return response()->json([
            'message' => Config('languageString.this_link_is_expire'),
        ], 403);

    }

    public function confirmOtp(ConfirmOtpRequest $request)
    {
        $user = User::where('id', $request->user_id)->where('forgot_password_otp', $request->otp)->first();
        if($user){
            User::where('id', $request->user_id)->update([
                'forgot_password_otp' => NULL,
            ]);
            $token = JWTAuth::fromUser($user);
            return response()->json([
                'message' => config('languageString.otp_is_verified'),
                'token'   => $token,
                'data'    => $user,
            ], 200);
        } else{
            return response()->json([
                'message' => config('languageString.invalid_otp'),
            ], 422);
        }
    }


    public function facebookLogin(FacebookLoginRequest $request)
    {
        $validated = $request->validated();

        if($validated['app_mode'] == 'business_mode') {

            if ($request->email != NULL) {
                $user = User::where('email', $request->email)->first();
                if ($user) {
                    if ($user->facebook_id == null) {
                        return response()->json([
                            'message' => Config('languageString.this_email_is_already_used_another_method_of_login'),
                        ], 422);
                    } else {
                        User::where(['id' => $user->id])
                            ->update([
                                'name' => $request->name,
                                'facebook_id' => $request->facebook_id,
                                'is_business_man' => 1,
                                'app_mode' => 'business_mode'
                            ]);

                    }
                }
            }

            $user = User::where('facebook_id', $request->facebook_id)->first();
            if ($user) {
                User::where(['id' => $user->id])
                    ->update([
                        'name' => $request->name,
                        'email' => $request->email,
                        'is_business_man' => 1,
                        'app_mode' => 'business_mode'
                    ]);
            } else {
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = bcrypt('furas_business_man1234567');
                $user->mobile_no = '';
                $user->is_business_man = 1;
                $user->app_mode = 'business_mode';
                $user->country_code = '';
                $user->facebook_id = $request->facebook_id;
                $user->status = 'Active';
                $user->save();
            }
            $userPorfile = UserBusinessProfile::updateOrCreate(['user_id' => $user->id],
                [
                    'user_id' => $user->id
                ]
            );


            $token = JWTAuth::fromUser($user);

            $this->deleteToken($request->device_token);

            $device = new Device();
            $device->user_id = $user->id;
            $device->device_type = $request->device_type;
            $device->device_token = $request->device_token;
            $device->device_u_id = $request->device_u_id;
            $device->save();

            return response()->json([
                'social_login' => true,
                'token' => $token,
                'user' => User::getUser($user->id),
            ], 200);
        }
        if($validated['app_mode'] == 'job_seeker_mode'){

            if ($request->email != NULL) {
                $user = User::where('email', $request->email)->first();
                if ($user) {
                    if ($user->facebook_id == null) {
                        return response()->json([
                            'message' => Config('languageString.this_email_is_already_used_another_method_of_login'),
                        ], 422);
                    } else {
                        User::where(['id' => $user->id])
                            ->update([
                                'name' => $request->name,
                                'facebook_id' => $request->facebook_id,
                                'is_job_seeker' => 1,
                                'app_mode' => 'job_seeker_mode'
                            ]);

                    }
                }
            }

            $user = User::where('facebook_id', $request->facebook_id)->first();
            if ($user) {
                User::where(['id' => $user->id])
                    ->update([
                        'name' => $request->name,
                        'email' => $request->email,
                        'is_job_seeker' => 1,
                        'app_mode' => 'job_seeker_mode'
                    ]);
            } else {
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = bcrypt('furas_business_man1234567');
                $user->mobile_no = '';
                $user->is_job_seeker = 1;
                $user->app_mode = 'job_seeker_mode';
                $user->country_code = '';
                $user->facebook_id = $request->facebook_id;
                $user->status = 'Active';
                $user->save();
            }



            $token = JWTAuth::fromUser($user);

            $this->deleteToken($request->device_token);

            $device = new Device();
            $device->user_id = $user->id;
            $device->device_type = $request->device_type;
            $device->device_token = $request->device_token;
            $device->device_u_id = $request->device_u_id;
            $device->save();

            return response()->json([
                'social_login' => true,
                'token' => $token,
                'user' => User::getUser($user->id),
            ], 200);
        }
        if($validated['app_mode'] != 'business_mode' && $validated['app_mode'] != 'job_seeker_mode'){

            $message = LanguageString::translated()->where('name_key','error')->first()->name;
            $error = ['field'=>'app_mode','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 403);
        }
    }

    public function googleLogin(GoogleLoginRequest $request)
    {

        $validated = $request->validated();
        if($validated['app_mode'] == 'business_mode') {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                if ($user->google_id == null) {
                    User::where('id', $user->id)
                        ->update([
                            'name' => $request->name,
                            'google_id' => $request->google_id,
                            'is_business_man' => 1,
                            'app_mode' => 'business_mode'
                        ]);
                } else if ($user->google_id != $request->google_id) {
                    return response()->json([
                        'message' => Config('languageString.this_email_is_already_used_another_method_of_login'),
                    ], 422);
                } else {
                    $user = User::where('google_id', $request->google_id)->first();
                    if ($user) {
                        User::where(['id' => $user->id])
                            ->update([
                                'name' => $request->name,
                                'google_id' => $request->google_id,
                                'is_business_man' => 1,
                                'app_mode' => 'business_mode'
                            ]);
                    } else {
                        $user = new User();
                        $user->name = $request->name;
                        $user->email = $request->email;
                        $user->mobile_no = '';
                        $user->password = bcrypt('furas_business_man1234567');
                        $user->is_business_man = 1;
                        $user->app_mode = 'business_mode';
                        $user->country_code = '';
                        $user->google_id = $request->google_id;
                        $user->status = 'Active';
                        $user->save();
                    }
                }
            } else {
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->google_id = $request->google_id;
                $user->mobile_no = '';
                $user->password = bcrypt('furas_business_man1234567');
                $user->is_business_man = 1;
                $user->app_mode = 'business_mode';
                $user->country_code = '';
                $user->status = 'Active';
                $user->save();
            }
            $userPorfile = UserBusinessProfile::updateOrCreate(['user_id' => $user->id],
                [
                    'user_id' => $user->id
                ]
            );

            $token = JWTAuth::fromUser($user);
            $this->deleteToken($request->device_token);

            $device = new Device();
            $device->user_id = $user->id;
            $device->device_type = $request->device_type;
            $device->device_token = $request->device_token;
            $device->device_u_id = $request->device_u_id;
            $device->save();

            return response()->json([
                'social_login' => true,
                'token' => $token,
                'user' => User::getUser($user->id),
            ], 200);
        }
        if($validated['app_mode'] == 'job_seeker_mode'){
            $user = User::where('email', $request->email)->first();
            if ($user) {
                if ($user->google_id == null) {
                    User::where('id', $user->id)
                        ->update([
                            'name' => $request->name,
                            'google_id' => $request->google_id,
                            'is_job_seeker' => 1,
                            'app_mode' => 'job_seeker_mode'
                        ]);
                } else if ($user->google_id != $request->google_id) {
                    return response()->json([
                        'message' => Config('languageString.this_email_is_already_used_another_method_of_login'),
                    ], 422);
                } else {
                    $user = User::where('google_id', $request->google_id)->first();
                    if ($user) {
                        User::where(['id' => $user->id])
                            ->update([
                                'name' => $request->name,
                                'google_id' => $request->google_id,
                                'is_job_seeker' => 1,
                                'app_mode' => 'job_seeker_mode'
                            ]);
                    } else {
                        $user = new User();
                        $user->name = $request->name;
                        $user->email = $request->email;
                        $user->mobile_no = '';
                        $user->password = bcrypt('furas_business_man1234567');
                        $user->is_job_seeker = 1;
                        $user->app_mode = 'job_seeker_mode';
                        $user->country_code = '';
                        $user->google_id = $request->google_id;
                        $user->status = 'Active';
                        $user->save();
                    }
                }
            } else {
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->google_id = $request->google_id;
                $user->mobile_no = '';
                $user->password = bcrypt('furas_business_man1234567');
                $user->is_job_seeker = 1;
                $user->app_mode = 'job_seeker_mode';
                $user->country_code = '';
                $user->status = 'Active';
                $user->save();
            }


            $token = JWTAuth::fromUser($user);
            $this->deleteToken($request->device_token);

            $device = new Device();
            $device->user_id = $user->id;
            $device->device_type = $request->device_type;
            $device->device_token = $request->device_token;
            $device->device_u_id = $request->device_u_id;
            $device->save();

            return response()->json([
                'social_login' => true,
                'token' => $token,
                'user' => User::getUser($user->id),
            ], 200);
        }

        if($validated['app_mode'] != 'business_mode' && $validated['app_mode'] != 'job_seeker_mode'){

            $message = LanguageString::translated()->where('name_key','error')->first()->name;
            $error = ['field'=>'app_mode','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 403);
        }


    }

    public function appleLogin(AppleLoginRequest $request)
    {
        $validated = $request->validated();
        if($validated['app_mode'] == 'business_mode') {
            if ($request->email != NULL) {
                $user = User::where('email', $request->email)->first();
                if ($user) {
                    if ($user->apple_id == null) {
                        return response()->json([
                            'message' => Config::get('languageString.this_email_is_already_used_another_method_of_login'),
                        ], 422);
                    } else {
                        User::where(['id' => $user->id])
                            ->update([
                                'name' => $request->name,
                                'apple_id' => $request->apple_id,
                                'is_business_man' => 1,
                                'app_mode' => 'business_mode'
                            ]);
                    }
                }
            }

            $user = User::where('apple_id', $request->apple_id)->first();

            if ($user) {
                User::where(['id' => $user->id])
                    ->update([
                        'name' => $request->name,
                        'email' => $request->email,
                        'is_business_man' => 1,
                        'app_mode' => 'business_mode'
                    ]);
            } else {
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->mobile_no = '';
                $user->country_code = '';
                $user->password = bcrypt('furas_business_man1234567');
                $user->is_business_man = 1;
                $user->app_mode = 'business_mode';
                $user->apple_id = $request->apple_id;
                $user->status = 'Active';
                $user->save();
            }

            $userPorfile = UserBusinessProfile::updateOrCreate(['user_id' => $user->id],
                [
                    'user_id' => $user->id
                ]
            );

            $token = JWTAuth::fromUser($user);

            $this->deleteToken($request->device_token);

            $device = new Device();
            $device->user_id = $user->id;
            $device->device_type = $request->device_type;
            $device->device_token = $request->device_token;
            $device->device_u_id = $request->device_u_id;
            $device->save();

            return response()->json([
                'social_login' => true,
                'token' => $token,
                'user' => User::getUser($user->id),
            ], 200);
        }
        if($validated['app_mode'] == 'job_seeker_mode'){
            if ($request->email != NULL) {
                $user = User::where('email', $request->email)->first();
                if ($user) {
                    if ($user->apple_id == null) {
                        return response()->json([
                            'message' => Config::get('languageString.this_email_is_already_used_another_method_of_login'),
                        ], 422);
                    } else {
                        User::where(['id' => $user->id])
                            ->update([
                                'name' => $request->name,
                                'apple_id' => $request->apple_id,
                                'is_job_seeker' => 1,
                                'app_mode' => 'job_seeker_mode'
                            ]);
                    }
                }
            }

            $user = User::where('apple_id', $request->apple_id)->first();

            if ($user) {
                User::where(['id' => $user->id])
                    ->update([
                        'name' => $request->name,
                        'email' => $request->email,
                        'is_job_seeker' => 1,
                        'app_mode' => 'job_seeker_mode'
                    ]);
            } else {
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->mobile_no = '';
                $user->country_code = '';
                $user->password = bcrypt('furas_business_man1234567');
                $user->is_job_seeker = 1;
                $user->app_mode = 'job_seeker_mode';
                $user->apple_id = $request->apple_id;
                $user->status = 'Active';
                $user->save();
            }


            $token = JWTAuth::fromUser($user);

            $this->deleteToken($request->device_token);

            $device = new Device();
            $device->user_id = $user->id;
            $device->device_type = $request->device_type;
            $device->device_token = $request->device_token;
            $device->device_u_id = $request->device_u_id;
            $device->save();

            return response()->json([
                'social_login' => true,
                'token' => $token,
                'user' => User::getUser($user->id),
            ], 200);
        }

        if($validated['app_mode'] != 'business_mode' && $validated['app_mode'] != 'job_seeker_mode'){

            $message = LanguageString::translated()->where('name_key','error')->first()->name;
            $error = ['field'=>'app_mode','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 403);
        }




    }

    public function deleteToken($device_token)
    {
        Device::where('device_token', $device_token)->delete();
        return true;
    }

    public function guestUser(Request $request){
        Log::info('app.requests', ['request' => $request->all()]);

        try{

            $messages = [
                'required' => 'the_field_is_required',
                'string' => 'the_string_field_is_required',
                'max' => 'the_field_is_out_from_max',
                'min' => 'the_field_is_low_from_min',
                'unique' => 'the_field_should_unique',
                'confirmed' => 'the_field_should_confirmed',
                'email' => 'the_field_should_email',
                'exists' => 'the_field_should_exists',
            ];
            $validator = Validator::make($request->all(), [

                'device_type' => 'required',
                'device_token' => 'required',
                'device_u_id' => 'required',
            ], $messages);

            if ($validator->fails()) {
                $errors = [];
                foreach ($validator->errors()->messages() as $field => $message) {
                    $messageval = LanguageString::translated()->where('name_key', $message[0])->first()->name;
                    $field_msg = LanguageString::translated()->where('name_key', $field)->first()->name;
                    $errors[] = [
                        'field' => $field,
                        'message' => strtolower($field_msg) . ' ' . strtolower($messageval),
                    ];
                }
                return response()->json(compact('errors'), 403);
            }

            $guestUser = User::where('user_type','guest')->first();
            $this->deleteToken($request->device_token);

            $device = new Device();
            $device->user_id = $guestUser->id;
            $device->device_type = $request->device_type;
            $device->device_token = $request->device_token;
            $device->device_u_id = $request->device_u_id;
            $device->save();

            $token = JWTAuth::fromUser($guestUser);
            return response()->json([
                'token' => $token,
                'user' => User::getUser($guestUser->id),
            ], 200);
        }catch(\Exception $e){
            $message = LanguageString::translated()->where('name_key','error')->first()->name;
            $error = ['field'=>'language_strings','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }



}
