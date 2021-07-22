<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'title' => $this->title,
            'image' => $this->image,
            'slug' => $this->slug,
            'summary' => $this->summary,
            'body' => $this->body,
            'live' => (bool) $this->live,
            'post_category' => new PostCategoryResource($this->whenLoaded('post_category')),
            'user' => new PrivateUserResource($this->whenLoaded('user')),
            'created_at' => $this->created_at,
            'tags' => new TagResource($this->whenLoaded('tags')),
            'comments' => new CommentResource(
                $this->whenLoaded('comments')
            //   ->where('parent_id', null)
            //   ->where('approved', true)
            //   ->where('deleted_at', '==', null)
            )
        ];
    }
}
