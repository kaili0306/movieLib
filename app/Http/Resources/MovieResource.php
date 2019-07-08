<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class MovieResource extends Resource
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
            'title' => $this->title,
            'duration' => $this->duration,
            'summary' => $this->summary,
            'genre' => $this->genre,
            'director' => $this->director,
            'cast' => $this->cast,
            'datePublished' => $this->datePublished,
            'raters'=>RaterResource::collection($this->whenLoaded('raters')),
        ];
    }
}
