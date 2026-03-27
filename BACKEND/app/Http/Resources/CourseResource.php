<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

    $isDetail = $request->is('api/v1/courses/*');

        return [
            "title" => $this->title,
            "description" => $this->description,
            "instructor" => $this->instructor->user->name, 
            "price" =>  $this->price,
            "image" => $this->image,
            
            "materials" => $this->whenLoaded('materials', function () {
                return $this->materials->map(function ($material) {
                    return [
                        "title" => $material->title,
                        "video" => $material->video_url 
                    ];
                });
            })
        ]; 
    }
}
