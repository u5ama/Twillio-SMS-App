<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class AppReferenceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        App::setLocale($request->header('Accept-Language'));
        if(isset($this->name) && $this->name == null) {
            App::setLocale('en');
            $name = $this->name;
        }else{
            App::setLocale($request->header('Accept-Language'));
            $name = $this->name;
        }
        return [
            'id' => $this->id,
            'name' => $name,
            'icon' => $this->icon,
            'image' => $this->image,
            'slug' => $this->slug,

        ];
    }
}
