<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentResource extends JsonResource
{
    /**
     * Mengubah resource menjadi array untuk dikirim sebagai JSON.
     * (Transform the resource into an array for JSON response.)
     */
    public function toArray(Request $request): array
    {
        return [
            'course_id' => $this->course_id,
            'notes' => $this->notes,
        ];
    }
}
