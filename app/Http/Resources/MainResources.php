<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MainResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

//        $base_url = url_u();
//
//        $content = _t($this['content']);
//
//        if ($content) {
//            $content = str_replace(
//                'src="/storage/uploads/',
//                'src="' . $base_url,
//                $content
//            );
//            $content = preg_replace('/https:\s*\/\//', 'https://', $content);
//            $content = str_replace('\"', '"', $content);
//        } else {
//            $content = _t($this['content']);
//        }
//
//        $query = $request->query('query');
//        $words = array_filter(explode(' ', strtolower($query)));
//        $highlightedTitle = $this->highlightText($this->title->{LANG} ?? '', $words);

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
            'file' => optional(collect($this->files)->firstWhere('is_main', '1'))->url
                ? url_u() . $this->group . '/' . collect($this->files)->firstWhere('is_main', '1')->url
                : null,

            'file_not_main' => optional(collect($this->files)->firstWhere('is_main', '0'))->url
                ? url_u() . $this->group . '/' . collect($this->files)->firstWhere('is_main', '0')->url
                : null,

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

}
