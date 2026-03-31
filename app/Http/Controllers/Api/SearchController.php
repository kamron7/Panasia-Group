<?php
namespace App\Http\Controllers\Api;

use App\Models\Doctors;
use App\Http\Controllers\Core\ApiController;
use App\Models\Video_materials;
use App\Models\Federations;
use App\Models\Manage;
use App\Models\Main;
use App\Models\Sports;
use App\Models\Gallery;
use App\Models\Video;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\DCategoryResources;
use App\Http\Resources\ManageResources;
use App\Http\Resources\FederationsResources;
use App\Http\Resources\VideoMaterialsResources;
use App\Http\Resources\MainResources;
use App\Http\Resources\CatsResources;
use App\Http\Resources\GalleryResources;
use App\Http\Resources\VideoResources;
use App\Http\Resources\NewsResources;

class SearchController extends ApiController
{
    public function search(Request $request): JsonResource
    {
        $query = $request->query('query');

        if (!$query) {
            return new JsonResource([]);
        }

        $query = mb_convert_encoding(mb_strtolower($query), 'UTF-8', 'auto');

        $results = $this->searchExactPhrase($query, $request);

        return new JsonResource($results);
    }

    /**
     * Search for the exact phrase in the relevant models.
     */
    private function searchExactPhrase(string $query, Request $request): array
    {
        $results = [];
        $words = array_filter(explode(' ', strtolower($query)));

        $models = [
            Doctors::class => DCategoryResources::class,
            Video_materials::class => VideoMaterialsResources::class,
            Federations::class => FederationsResources::class,
            Manage::class => ManageResources::class,
            Main::class => MainResources::class,
            Sports::class => CatsResources::class,
            Gallery::class => GalleryResources::class,
            Video::class => VideoResources::class,
            News::class => NewsResources::class,
        ];

        foreach ($models as $model => $resource) {
            $queryResult = $model::where(function ($queryBuilder) use ($words) {
                foreach ($words as $word) {
                    $queryBuilder->whereRaw('LOWER(title->>?::text) LIKE ?', [LANG, '%' . $word . '%']);
                }
            })->orderBy('created_at', 'desc')->get();

            if (!$queryResult->isEmpty()) {
                $scoredResults = $queryResult->map(function ($item) use ($words) {
                    $title = mb_strtolower($item->title->{LANG} ?? '');

                    foreach ($words as $word) {
                        $title = preg_replace('/\b' . preg_quote($word, '/') . '\b/i', '<span class="highlight">$0</span>', $title);
                    }

                    $matchCount = count(array_filter($words, function ($word) use ($title) {
                        return strpos($title, strtolower($word)) !== false;
                    }));

                    return ['item' => $item, 'match_count' => $matchCount];
                })->sortByDesc('match_count')->values();

                if (is_array($resource)) {
                    foreach ($resource as $res) {
                        $results = array_merge($results, $res::collection($scoredResults->pluck('item'))->toArray($request));
                    }
                } else {
                    $results = array_merge($results, $resource::collection($scoredResults->pluck('item'))->toArray($request));
                }
            }
        }

        usort($results, function ($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        return $results;
    }


}
