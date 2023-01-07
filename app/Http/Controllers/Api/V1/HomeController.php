<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\AppMenuResource;
use App\Models\AppMenu;
use App\Models\Language;
use App\Models\LanguageString;
use App\Models\OnBoarding;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        try {
            $locale = $request->header('Accept-Language');
            $language = Language::where(['status' => 'Active', 'language_code' => $locale])->first();

            $homes = OnBoarding::select('on_boardings.*')->orderBy('on_boarding_order_by', 'ASC')->get();

            $data = [];
            foreach ($homes as $key => $home) {
                $data[] = [
                    "id" => $home->id,
                    "icon" => $home->icon,
                    "image" => $home->image,
                    "on_boarding_order_by" => $home->on_boarding_order_by,
//                        "header_text"=> ($home->translateOrNew($language->language_code)->header_text != null) ? $home->translateOrNew($language->language_code)->header_text :$home->translateOrNew("en")->header_text,
                    "onBoarding_description" => $home->translateOrNew($language->language_code)->description,
                    "locale" => $language->language_code

                ];
            }

            return response()->json($data, 200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            $message = LanguageString::translated()->where('name_key', 'error')->first()->name;
            $error = ['field' => 'Languages', 'message' => $message];
            $errors = [$error];
            return response()->json(['success' => false, 'code' => '500', 'errors' => $errors], 500);
        }
    }

    public function getMenu(Request $request)
    {
        Log::info('app.requests', ['request' => $request->all(), 'URL' => $request->url()]);
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $app_mode = 'passenger';
                if ($user->user_type == 'Passenger') {
                    $app_mode = 'passenger_menu';
                }
                if ($user->user_type == 'Driver') {
                    $app_mode = 'drver_menu';
                }
            $Menus = AppMenu::where('user_type', $app_mode)->orderBy('ordering', 'asc')->get();

            $menu = [];
            $menu = AppMenuResource::collection($Menus);

            return response()->json($menu, 200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $error = ['field' => 'error', 'message' => $message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
