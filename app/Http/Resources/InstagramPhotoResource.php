<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InstagramPhotoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'description' => $this->description,
            'id' => $this->id,
            'instagram_id' => $this->instagram_id,
            'taken_at' => (string) $this->taken_at,
            'url_to_original' => $this->url_to_original,
            'image_url' => $this->getFirstMediaUrl(),
        ];
    }
}
