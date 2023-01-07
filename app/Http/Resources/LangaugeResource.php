<?php

namespace App\Http\Resources;

use App\Models\LanguageString;
use Illuminate\Http\Resources\Json\JsonResource;

class LangaugeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $preference = LanguageString::where('name_key','language_preference')->first()->translateOrNew($this->language_code)->name;
        $select_language = LanguageString::where('name_key','select_app_language')->first()->translateOrNew($this->language_code)->name;
        $app_language_description = LanguageString::where('name_key','app_language_description')->first()->translateOrNew($this->language_code)->name;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_rtl' => $this->is_rtl,
            'language_code' => $this->language_code,
            'language_image' => $this->language_image,
            'key_preference' => $preference,
            'key_select_language' => $select_language,
            'key_app_language_description' => $app_language_description,
        ];
    }
}
