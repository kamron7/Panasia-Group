<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoMaterialsResources extends JsonResource
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

        $images = '';

        if ($this->group === 'interview') {
            $images = getImgMain($this) ? url_u() . 'video_materials/' . getImgMain($this) : '';
        } else if ($this->group === 'social-video') {
            $images = $this->resource['img'] ? url_u() . 'video_materials/' . $this->resource['img'] : '';
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
            'images' =>$images,
            'created_at' => isset($this->resource['created_at']) ? $this->resource['created_at']->format('d.m.Y') : null,
        ];

        return $baseArray;
    }
    private function highlightText(string $text, array $words): string
    {
        foreach ($words as $word) {
            $text = preg_replace('/\b' . preg_quote($word, '/') . '\b/i', '<span class="highlight">$0</span>', $text);
        }
        return $text;
    }

}
