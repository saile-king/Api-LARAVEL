<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth;

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
        $user = Auth::user();

        return [
            'type' => $this->getTable(),
            'id' => $this->id,

            "atributes" => [
                'title' => $this->title,
                'content' => $this->content
            ],

            $this->mergeWhen(($this->isAuthorLoaded() && $this->isCommentLoaded()), [
                "relationships" => new PostsRelationshipResource($this),
            ]),

            

            "links" => [
                'self' => route('posts.show', ['post' => $this->id]),
            ] 
        ];

    }
}
