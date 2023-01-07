<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SentGiftsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $percent = ($this->gifts->price/100) * $this->gifts->commission;

        return [
            'player_name'=>$this->player->name,
            'player_email'=>$this->player->email,
            'player_mobile_no'=>$this->player->mobile_no,
            'player_profile_pic'=>$this->player->profile_pic,
            'gift_id'=>$this->gifts->id,
            'gift_name'=>$this->gifts->name,
            'gift_price'=>$this->gifts->price,
            'gift_image'=>$this->gifts->image,
            'gift_total_price' => $this->gifts->price + $percent
        ];
    }
}
