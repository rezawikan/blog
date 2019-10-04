<?php

namespace App\Http\Resources;

use Illuminate\Support\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->resource instanceof Collection) {
            return CommentResource::collection($this->resource);
        }

        return [
          'id' => $this->id,
          'body' => $this->body,
          'user' => new PrivateUserResource($this->whenLoaded('user')),
          'children' => new CommentResource($this->whenLoaded('children'))
        ];
    }
}
