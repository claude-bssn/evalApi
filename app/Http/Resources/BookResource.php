<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\GenreResource;

class BookResource extends JsonResource
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
            "id" => $this->id,
            "title"=> $this->title,
            "description"=> $this->description,
            "author_id"=> $this->author_id,
            "publication_year"=> $this->publication_year,
            "pages_nb"=> $this->pages_nb,
            "genres"=> GenreResource::collection($this->genres),
        ];
    }
}
