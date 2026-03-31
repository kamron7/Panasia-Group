<?php

namespace App\Http\Controllers\Core;

use App\Libraries\MediaLib;
use App\Models\Base;
use App\Models\Docs;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Psr\Http\Message\ResponseInterface;

class AdminController extends MyController
{
    /* @var $model Base */
    protected mixed $model;
    protected ?string $sel;

    public function __construct()
    {
        parent::__construct();
        $this->data['site_lang'] = getSiteLang();
        $this->data['sel'] = $this->sel = $table = request()->segment(3);

        $exception = ['feedback'];
        if ($table and !in_array($table, $exception)) {
            if (!in_array($table, array_keys(getTables()))) {
                abort(404);
            }
            $this->model = getTables()[$this->sel];
        }
        AbstractPaginator::useBootstrapFive();
        MediaLib::deleteOldTemporaryFiles();
        $this->deleteTempsDocs();
    }

    public function sort_order(): void
    {

        $items = request('item');

        $sorted = (array)$items;
        $sort = request('sort', 'DESC');
        if ($sort == 'DESC') {
            rsort($sorted);
        } else {
            sort($sorted);
        }

        for ($i = 0; $i < count((array)$items); $i++) {
            $data = [
                'sort_order' => $sorted[$i]
            ];

            $this->model->my_save($data, $items[$i]);
        }
    }

    public function check_alias(): JsonResponse
    {
        $alias = request()->post('alias');

        if ($alias != '' || $alias != null) {
            $has_alias = $this->model->has_alias($alias, request()->post('postid') ?? -1);
            if ($has_alias == null) {
                return response()->json(['result' => false]);
            }
            return response()->json(['result' => true, 'alias' => $alias]);
        }
        return response()->json(['result' => false]);
    }

    public function sort_order_posts(): RedirectResponse
    {
        $id = @request()->post('id');
        $data = array(
            'sort_order' => @request()->post('sort_order'),
        );
        $this->model->my_save($data, $id);

        return go_to();
    }

    public function status_ajax(): JsonResponse
    {
        if (request()->get('status') and request()->get('postid')) {
            $id = request()->get('postid');
            if (request()->get('status') == 'true') {
                $status = true;
            } else {
                $status = false;
            }

            $data = array(
                'status' => $status,
            );

            $this->model->my_save($data, $id);

            $return['result'] = '<span style="color: green">' . __('updated') . '</span>';
            return response()->json($return)->setStatusCode(200);
        }

        return response()->json(['err' => 'status or postid not find']);
    }

    public function delete($id): ResponseInterface|RedirectResponse|null
    {
        $item = $this->model->getById($id);
        $this->model->destroy($id);
        $this->deleteFiles($item);
        $docs = Docs::gets(['cat_id' => $id, 'group' => $this->sel]);
        if ($docs) {
            foreach ($docs as $item) {
                $this->deleteFiles($item, 'docs');
            }
            Docs::destroy($docs);
        }
        return go_to();
    }

    protected function saveDocs($id): void
    {
        if ($key = session()->pull('docs_key')) {
            Docs::query()->where('cat_id', $key)->update(['cat_id' => $id]);
        }
    }

    private function deleteTempsDocs(): void
    {
        $docs = Docs::gets([['created_at', '<', now()->subDay()], ['cat_id', '<', '0']]);

        if ($docs) {
            foreach ($docs as $item)
                $this->deleteFiles($item, 'docs');
            Docs::destroy($docs);
        }
    }

    private function deleteFiles($item, $folder = false): void
    {
        $col = getColName($item);

        if (!$folder)
            $folder = $this->sel == 'main' ? $item->group : $this->sel;

        if ($item->img)
            if (Storage::disk('public')->exists("uploads/$folder/$item->img"))
                Storage::disk('public')->delete("uploads/$folder/$item->img");

        if ($item->$col)
            foreach ($item->$col as $file) {
                if (Storage::disk('public')->exists("uploads/$folder/$file->url")) {
                    Storage::disk('public')->delete("uploads/$folder/$file->url");
                }
            }
    }
}
