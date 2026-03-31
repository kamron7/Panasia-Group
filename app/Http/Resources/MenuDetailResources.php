<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuDetailResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $base_url = url_u();
        $short_content = _t($this['short_content']);
        if ($short_content) {
            // Replace relative paths with the full base URL
            $short_content = str_replace(
                'src="/storage/uploads/',
                'src="' . $base_url,
                $short_content
            );
            // Fix any incorrect URL patterns (e.g., "https: //" to "https://")
            $short_content = preg_replace('/https:\s*\/\//', 'https://', $short_content);
            // Remove unwanted backslashes before quotes (\" -> ")
            $short_content = str_replace('\"', '"', $short_content);
        }
        return
            [
                'id' => $this['id'],
                'title' => _t($this['title']),
                'alias' => $this['alias'],
                'options' => $this['options'],
                'content' => _t($this['content']),
                'short_content' => $short_content,
                'link' => $this->inner_link ?? $this->external_link,
                'keywords' => _t($this['keywords']),
                'description' => _t($this['description']),
                'images' => getImgMain($this) ? url_u().'menu/'.getImgMain($this) : '',
                'created_at' => $this['created_at'] ? $this['created_at']->format('d.m.Y') : null,
            ];
    }
}
