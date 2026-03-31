<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Ramsey\Collection\Collection;

class VideoMaterialsViewResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $base_url = url_u();
        $query = $request->query('query');
        $words = array_filter(explode(' ', strtolower($query)));
        $highlightedTitle = $this->highlightText($this->title->{LANG} ?? '', $words);
        $content = _t($this['content']);
        if ($content) {
            $content = str_replace(
                'src="/storage/uploads/',
                'src="' . $base_url,
                $content
            );
            $content = preg_replace('/https:\s*\/\//', 'https://', $content);
            $content = str_replace('\"', '"', $content);
        }

        $images = [];

        if ($this->group === 'interview') {
            $images = $this->getImages();
        } else if ($this->group === 'social-video') {
            $images = $this->img ? [url_u() . 'video_materials/' . $this->img] : [];
        }
        $baseArray = [
            'id' => $this->resource['id'] ?? null,
            'title' => $highlightedTitle,
            'alias' => $this->resource['alias'] ?? '',
            'views' => $this->resource['views'] ?? 0,
            'content' => $content ?? '',
            'key_link' => "/{$this->group}-slug/{$this['alias']}" ?? '',
            'keywords' => $this->resource['keywords'] ?? '',
            'description' => _t($this->resource['description']) ?? '',
            'images' => $images,
            'created_at' => isset($this->resource['created_at']) ? $this->resource['created_at']->format('d.m.Y') : null,
        ];

        return $baseArray;
    }
    private function getImages()
    {
        $images = $this->resource->images instanceof Collection ? $this->resource->images : collect($this->resource->images);

        return $images->map(function ($image){
            return [
                'url' =>  url_u() . 'video_materials/' . $image->url,
                'is_main' => $image->is_main,
            ];
        })->toArray();
    }
    private function highlightText(string $text, array $words): string
    {
        foreach ($words as $word) {
            $text = preg_replace('/\b' . preg_quote($word, '/') . '\b/i', '<span class="highlight">$0</span>', $text);
        }
        return $text;
    }

}
