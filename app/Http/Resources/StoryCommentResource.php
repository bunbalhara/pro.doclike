<?php

namespace App\Http\Resources;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class StoryCommentResource extends JsonResource
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
            'patient' => User::find($this->patient_id),
            'body' => $this->body,
            'liked' => $this->liked,
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
