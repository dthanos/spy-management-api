<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return
            [
                'id' => $this->id,
                'name' => $this->name,
                'surname' => $this->surname,
                'agency' => $this->agency,
                'country_of_operation' => $this->country_of_operation,
                'date_of_birth' => $this->date_of_birth,
                'date_of_death' => $this->date_of_death,

                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ];
    }
}
