<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Tymon\JWTAuth\Facades\JWTAuth;

class AppNavSettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id'=>$this->id,
            'slug'=>$this->slug,
            'app_mode'=>$this->app_mode,
            'icon_path'=>$this->icon_path,
            'image_path'=>$this->image_path,
            'name'=>$this->name
        ];
    }
}
