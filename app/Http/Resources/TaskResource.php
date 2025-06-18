<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'priority' => [
                'id' => $this->priority,
                'name' => $this->priority->name,
            ],
            'file' => asset('storage/' . $this->file),
            'control' => [
                'status' => $this->isControl,
                'expire_date' => $this->control_at,
                'remaining_days' => $this->remainingDaysControl
            ]
        ];
    }
}
