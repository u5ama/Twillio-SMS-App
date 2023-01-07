<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'      => $this->id,
            'sender_name' => $this->sender->name,
//            'gift_name'      => $this->gift->name,
//            'gift_image'   => $this->gift->image,
            'title'   => $this->title,
            'message' => $this->message,
            'date'    => Carbon::parse($this->created_at)->diffForHumans(),
        ];
    }
}
