<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Body;
use App\Http\Resources\SocialLinkResource;
use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SocialLinkController extends Controller
{
    public function __invoke(): \Illuminate\Http\JsonResponse
    {
        $query = SocialLink::where('status', 'Active')->get();
        $socialLinks = SocialLinkResource::collection($query);
        if(count($socialLinks) > 0){
            return response()->json($socialLinks, 200);
        } else{
            return response()->json([
                'message' => Config('languageString.social_link_not_found'),
            ], 422);
        }
    }
}
