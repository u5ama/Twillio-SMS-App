<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\AppControlsResource;
use DB;
use App\Models\AppControl;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppControlsController extends Controller
{
    /**
     * Display a listing of the App Controls.
     * @throws Exception
     */
    public function index()
    {
      $app_controls = [];
      $app_controls = AppControlsResource::collection(AppControl::where('status','Active')->get());

       return response()->json( $app_controls,200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }
}
