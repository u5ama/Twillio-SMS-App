<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageUploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Buses;
use App\Models\Company;
use App\Models\Driver;
use App\Models\User;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\UserVehicle;
use App\Models\CarModel;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function index()
    {
        $this->middleware('auth:admin');

        $passengers = User::where('user_type','user')->get()->count();
        $drivers =  User::where('user_type','driver')->get()->count();

        return view('admin.dashboard.index', [
            'passengers' => $passengers,
            'drivers' => $drivers,
        ]);
    }

    public function changeThemes($id)
    {
        Session::put('panel_mode', $id);
        Admin::where('id', Auth::user()->id)->update(['panel_mode' => $id]);
        return redirect()->route('admin.dashboard');
    }

    public function changeThemesMode($local)
    {
        Session::put('locale', $local);

        Admin::where('id', Auth::user()->id)->update(['locale' => $local]);
        return redirect()->route('admin.dashboard');
    }


    public function profile()
    {
        $user = Admin::where('id', Auth::user()->id)->first();
        if ($user) {
            return view('admin.dashboard.profile', ['user' => $user]);
        } else {
            abort(404);
        }
    }

    public function editProfile(Request $request)
    {
        $id = $request->input('edit_value');
        $user = Admin::where('id', $id)->first();
        $user->name = $request->input('name');
        if ($request->hasFile('image')) {
            $files = $request->file('image');
            $user->image = ImageUploadHelper::imageUpload($files);
        }
        $user->save();

        return response()->json(['success' => true, 'message' => config('languageString.user_updated')]);
    }


}
