<?php

namespace App\Http\Controllers\Admin;

use App\Models\Currency;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all();
        return view('admin.setting.index', ['settings' => $settings]);
    }

    public function settingUpdate(Request $request): \Illuminate\Http\JsonResponse
    {
        $settings = Setting::all();
        foreach ($settings as $setting) {
            Setting::where('meta_key', $setting->meta_key)->update([
                'meta_value' => $request->input($setting->meta_key) == NULL ? 1 : $request->input($setting->meta_key),
            ]);
        }
        return response()->json(['success' => true, 'message' => config('languageString.setting_updated')]);
    }
}
