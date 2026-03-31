<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Main;
use App\Models\Site;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rules\File;

class MyController extends Controller
{
//    protected Base $site;
    protected array $data;
//    protected Base $posts;

    protected Main $main;
    protected Site $site;

    public function __construct()
    {

        $this->site = new Site();
        $this->main = new Main();

        if (session()->missing('locale'))
            session(['locale' => config('app.locale')]);

        $this->data['session'] = session();
    }

    protected function uploadFile($folder, $model, $id = null, $fileName = 'userfile',): string|RedirectResponse|null
    {
        $file = request()->file($fileName);
        request()->validate([
            $fileName => File::types(explode(',', "csv,txt,xlx,xls,pdf,png,jpg,jpeg"))
                ->min('1kb')->max('10mb')]);

        if ($file and !empty($file) && $file->getSize() > 0) {
            if ($file->isValid()) {
                $img = $file->hashName();
                if ($id) {
                    $post = getTables()[$model]::getById($id);
                    if ($post->img)
                        delete_file("uploads/$folder/$post->img");
                }

                upload_file($file, "uploads/$folder", $img);
                return $img;
            } else {
                session()->flash('error_success', "<p>" . p_lang('success_email_error1') . "</p>");
                return redirect()->back();
            }
        }
        return null;
    }
}
