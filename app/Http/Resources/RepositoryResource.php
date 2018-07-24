<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RepositoryResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'topics' => $this->topics,
            'language' => $this->language,
            'description' => $this->description,
            'star_count' => $this->stars,
            'formatted_star_count' => number_format($this->stars, 0, '.', ' '),
            'download_count' => $this->downloads,
            'formatted_download_count' => number_format($this->downloads, 0, '.', ' '),
            'is_new' => $this->new,
            'has_issues' => $this->has_issues,
            'url' => "https://github.com/spatie/{$this->name}",
            'issues_url' => $this->issues_url,
            'documentation_url' => $this->documentation_url,
            'blogpost_url' => $this->blogpost_url,
            'repository_created_at' => $this->repository_created_at->timestamp,
        ];
    }
}
