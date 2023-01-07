<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\SMSLogs;
use Illuminate\Http\Request;

class TwilioController extends Controller
{

    /**
     * receive an incoming SMS message
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function receiveSMS(Request $request)
    {
        $message = $request->input('Body');
        $phoneNumber = $request->input('From');

        $messageBody = explode(',',$message);

        $type = substr($messageBody[0], strpos($messageBody[0], ":") + 1);
        $name = '';
        $phone = '';
        $tagNumber = '';
        $taxiNumber = '';
        $busNumber = '';
        $address = '';

        if ($type == 'driver'){
            $name = substr($messageBody[1], strpos($messageBody[1], ":") + 1);
            $phone = substr($messageBody[2], strpos($messageBody[2], ":") + 1);
            $tagNumber = substr($messageBody[3], strpos($messageBody[3], ":") + 1);
            $taxiNumber = substr($messageBody[4], strpos($messageBody[4], ":") + 1);

        }elseif ($type == 'bus'){
            $name = substr($messageBody[1], strpos($messageBody[1], ":") + 1);
            $phone = substr($messageBody[2], strpos($messageBody[2], ":") + 1);
            $tagNumber = substr($messageBody[3], strpos($messageBody[3], ":") + 1);
            $busNumber = substr($messageBody[4], strpos($messageBody[4], ":") + 1);

        }elseif ($type == 'station'){
            $name = substr($messageBody[1], strpos($messageBody[1], ":") + 1);
            $address = substr($messageBody[2], strpos($messageBody[2], ":") + 1);
        }



        // do something with the message
        SMSLogs::create([
            'from_number' => $phoneNumber,
            'type' => $type,
            'name' => $name,
            'address' => $address,
            'phone' => $phone,
            'tagNumber' => $tagNumber,
            'taxiNumber' => $taxiNumber,
            'busNumber' => $busNumber,
            'message' => $message,
        ]);

        return response()->json([
            'success' => true
        ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }
}
