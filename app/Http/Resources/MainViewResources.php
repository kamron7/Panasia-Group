<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Ramsey\Collection\Collection;

class MainViewResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this['id'] ?? null,
            'title' => _t($this['title']),
            'content' => _t($this['content']),
            'short_content' => _t($this['short_content']),
            'content_2' => _t($this['content_2']),
            'year_1' => _t($this['year_1']),
            'year_2' => _t($this['year_2']),
            'year_3' => _t($this['year_3']),
            'tuition fees international(uzs)' => $this->options,
            'tuition fees international' => $this->options2,
            'tuition fees international(cis)' => $this->options3,
            'modules' => $this->options4,
            'files' => $this['files'],
            'apply_link' => $this['apply_link'],
            'our_faculty' => _t($this['our_faculty']),
            'tuition_fees' => _t($this['tuition_fees']),
            'scholarships' => _t($this['scholarships']),
            'keywords' => _t($this['keywords']),
            'description' => _t($this['description']),
            'alias' => $this['alias'],
            'created_at' => $this['created_at'] ? $this['created_at']->format('d.m.Y') : null,
        ];

        return array_filter($data, function ($value) {
            return !is_null($value) && $value !== '';
        });
    }

    private function getImages()
    {
        $images = $this->resource->files instanceof Collection ? $this->resource->files : collect($this->resource->files);

        return $images->map(function ($image){
            return [
              'url' =>  url_u() . $this->group. '/' . $image->url,
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
