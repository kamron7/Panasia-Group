<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Core\PublicController;
use App\Models\Menu;
use Illuminate\Http\Response;

class RssController extends PublicController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['sel'] = 'rss';
    }

    public function index($table, $group = null): Response
    {
        $model = getTables()[$table];
        $this->data['feed_name'] = p_lang('news'); // your website
        $this->data['encoding'] = 'utf-8'; // the encoding
        $this->data['feed_url'] = base_path(); // the url to your feed
        $this->data['page_description'] = 'Новости'; // some description
        $this->data['creator_email'] = '<span class="skimlinks-unlinked">' . url_p() . '</span>'; // your email

        if ($group) {
            $this->data['title'] = _t(Menu::getByInnerLinkPublic($group)->title);
            $this->data['news'] = $model->getsPublic(['limit' => 50, 'group' => $group]);
        } else {
            $this->data['title'] = _t(Menu::getByInnerLinkPublic($table)->title);
            $this->data['news'] = $model->getsPublic(['limit' => 50]);
        }

        return response()
            ->view('public/pages/rss', $this->data)
            ->header('Content-Type', 'application/xml');
    }
}
