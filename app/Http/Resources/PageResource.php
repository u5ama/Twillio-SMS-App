<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
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
            'id'          => $this->id,
            'page_name'   => $this->name,
            'name'        => $this->name,
            'slug'        => $this->slug,
            'description' => $this->description,
            'updated_at'  => date('d-m-Y', strtotime($this->updated_at)),
        ];
    }
}
