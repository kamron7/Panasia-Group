<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Core\AdminController;
use App\Libraries\MediaLib;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    private MediaLib $medialib;

    public function __construct()
    {
        $this->medialib = new MediaLib();
    }

    public function set_main($model, $post_id, $id): \Illuminate\Http\JsonResponse
    {
        return $this->medialib->set_main($id, $model, $post_id);
    }

    public function sort($model, $post_id): void
    {
        $items = request()->input('media_files');
        $this->medialib->sort($model, $post_id, $items);
        echo 'sorted';
    }


    public function save(): bool|string
    {
        $data = array(
            'category' => request()->post('category'),
            'post_id' => request()->post('post_id'),
            'model' => request()->post('model'),
            'type' => request()->post('type'),
        );

        $result = $this->medialib->save($data);

        return json_encode($result);
    }

    public function delete1($model, $post_id, $id): void
    {
        $this->medialib->delete($model, $post_id, $id);
    }

    public function delete_all($model, $post_id): void
    {
        $this->medialib->delete_all($model, $post_id);
    }

    public function get_media_data($model, $post_id, $id)
    {
        return $this->medialib->get_media_data($model, $post_id, $id);
    }

    public function update_media_data()
    {
        return $this->medialib->update_media_data();
    }

    public function update_media_image()
    {
        return $this->medialib->update_media_image();
    }

    public function svgColor(MediaLib $mediaLib)
    {
        return $mediaLib->update_media_svg_color();
    }

    public function videoThumbnail(\Illuminate\Http\Request $r, \App\Libraries\MediaLib $lib)
    {
        return $lib->upload_video_thumbnail();
    }

    public function getVideoThumbnail(\Illuminate\Http\Request $r, \App\Libraries\MediaLib $lib)
    {
        return $lib->get_video_thumbnail();
    }

    public function deleteVideoThumbnail(\Illuminate\Http\Request $request, \App\Libraries\MediaLib $mediaLib)
    {
        return $mediaLib->delete_video_thumbnail();
    }

}
