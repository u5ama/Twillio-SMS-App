<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppDefaultImagesResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'key'      => $this->default_key,
            'value' => $this->image,
        ];
    }
}
