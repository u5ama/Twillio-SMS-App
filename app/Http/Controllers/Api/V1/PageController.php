<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\PageResource;
use App\Models\Page;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request,$id)
    {
        $page = [];

            if(isset($request->slug) && $request->slug != null){

                $page = new PageResource(Page::where('slug',$request->slug)->first());
            }else{
                $page = new PageResource(Page::where('id',$id)->first());
            }


        return response()->json( $page,200, ['Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function allPages()
    {
        $allpage = [];
        $allpage = PageResource::collection(Page::all());

        return response()->json( $allpage,200, ['Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }
}
