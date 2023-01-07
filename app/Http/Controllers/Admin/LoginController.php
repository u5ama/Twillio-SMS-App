<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use DB;
use App\Models\User;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        if(Auth::guard('admin')->check()){
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function loginCheck(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return redirect()
                ->route('admin.login')
                ->withErrors($validator)
                ->withInput();

        }
        $admin = Admin::where('email', $request->input('email'))
            ->first();

        if(!$admin){
            return redirect()
                ->route('admin.login')
                ->withErrors(['email' => ["Invalid Email"]])
                ->withInput();
        }

        if(!Hash::check($request->input('password'), $admin->password)){
            return redirect()
                ->route('admin.login')
                ->withErrors(['password' => ["Invalid Password"]])
                ->withInput();
        }

        if($admin){
            Auth::guard('admin')->login($admin);

            Session::put('panel_mode', $admin->panel_mode);
            Session::put('locale', $admin->locale);
            return redirect()->route('admin.dashboard');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        \Illuminate\Support\Facades\Session::flush();
        return redirect()->route('admin.login');
    }
}
