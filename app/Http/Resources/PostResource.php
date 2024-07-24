<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'category' => $this->category->name,
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'author' => new UserResource($this->author),
            'scheduled_at' => $this->scheduled_at,
            'status' => $this->status ?? 'draft',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
