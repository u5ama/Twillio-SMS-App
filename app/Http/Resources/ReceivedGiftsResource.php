<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReceivedGiftsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        $percent = ($this->gifts->price/100) * $this->gifts->commission;

        return [
            'fan_name'=>$this->fan->name,
            'fan_email'=>$this->fan->email,
            'fan_mobile_no'=>$this->fan->mobile_no,
            'fan_profile_pic'=>$this->fan->profile_pic,
            'gift_id'=>$this->gifts->id,
            'gift_name'=>$this->gifts->name,
            'gift_price'=>$this->gifts->price,
            'gift_image'=>$this->gifts->image,
            'gift_commission'=>$this->gifts->commission,
            'gift_status'=>$this->gift_status,
//            'gift_total_price' => $this->gifts->price + $percent
        ];
    }
}
