<?php

namespace App\Http\Controllers\Api\V1;


use App\Helpers\ImageUploadHelper;
use App\Models\ReportProblem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class ReportProblemController extends Controller
{
    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $user_id = $user->id;
        $validator = Validator::make($request->all(), [
            'message' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $report_problem = new ReportProblem();
        $report_problem->user_id = $user_id;
        $report_problem->message = $request->input('message');
        if($request->hasFile('image')){
            $files = $request->file('image');
            $report_problem->image = ImageUploadHelper::imageUpload($files);
        }
        $report_problem->save();


        return response()->json([
            'message' => Config('languageString.report_message_thank_you_message'),
        ],200);

    }

}
