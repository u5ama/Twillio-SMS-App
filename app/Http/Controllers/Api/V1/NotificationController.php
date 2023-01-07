<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\QuickServiceResource;
use App\Models\Notification;
use App\Models\QuickService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {

        $query = Notification::orderBy('id', 'desc')->paginate(10);
        $notifications = NotificationResource::collection($query);
        if(count($notifications) > 0){

            return response()->json(['data' => $notifications], 200);
        } else{
            return response()->json([
                'message' => Config('languageString.no_data_found'),
            ], 422);
        }
    }

    public function notificationDetails($id): \Illuminate\Http\JsonResponse
    {
        $array = [];
        $notification = Notification::where('id', $id)->first();
        if($notification){
            $array['id'] = $notification->id;
            $array['title'] = $notification->title;
            $array['message'] = $notification->message;
            $array['description'] = $notification->description;
            $array['image'] = $notification->image;
            $array['date'] = Carbon::parse($notification->created_at)->diffForHumans();
            return response()->json(['data' => $array], 200);
        } else{
            return response()->json([
                'message' => Config('languageString.no_data_found'),
            ], 422);
        }
    }
}
