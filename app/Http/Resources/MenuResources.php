<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResources extends JsonResource
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
            'cat_id' => $this->cat_id,
            'sort_order' => $this->sort_order,
            'title' => _t($this->title),
            'is_static' => $this->is_static,
            'group' => $this->group,
            'link' => $this->inner_link ?? $this->external_link,
            'alias' => $this->alias,
            'children' => $this->when(
                $this->whenLoaded('children'),
                fn() => MenuResources::collection($this->children)
            ),
        ];
    }
}
