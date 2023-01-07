<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GuestUserResource extends JsonResource
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
            "id"=>$this->id,
            'email'=>$this->email,
            'country_code'=>(isset($this->country_code) && $this->country_code != null) ? $this->country_code : "",
            'mobile_no'=>(isset($this->mobile_no) && $this->mobile_no != null) ? $this->mobile_no : "",
            'name'=>(isset($this->name) && $this->name != null) ? $this->name : "",
            'user_type'=>$this->user_type,
            'locale'=>$this->locale
        ];
    }
}
