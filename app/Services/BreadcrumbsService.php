<?php


namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

class BreadcrumbsService
{
    public function generate(Request $request, $group = null, $alias = null)
    {
        $breadcrumbs = [];

        $breadcrumbs['parent'] = [
            'title' => 'Home',
            'is_static' => false,
            'external_link' => null,
            'inner_link' => '/',
            'alias' => 'home',
        ];

        if ($group) {
            $breadcrumbs['child'] = [
                'title' => Str::title(str_replace('_', ' ', $group)),
                'is_static' => false,
                'external_link' => null,
                'inner_link' => "/$group",
                'alias' => $group,
            ];

            if ($alias) {
                $breadcrumbs['child'] = [
                    'title' => $alias,
                    'is_static' => false,
                    'external_link' => null,
                    'inner_link' => "/$group/$alias",
                    'alias' => $alias,
                ];
            }
        }

        return $breadcrumbs;
    }
}
