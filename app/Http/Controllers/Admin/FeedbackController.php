<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\AdminController;
use App\Models\Feedback;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FeedbackController extends AdminController
{
    private Feedback $feedback;

    public function __construct()
    {
        parent::__construct();

        $this->feedback = new Feedback();
        $this->data['sel'] = 'feedback';
    }

    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        session(['sel' => 'feedback']);
        $data = $this->feedback->pager(['limit' => 12]);
        $this->data['posts'] = $data->items();
        $this->data['pager'] = $data->links();
        return view('admin/feedback/index', $this->data);
    }

    public function edit($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $this->data['post'] = $this->feedback->getById($id);
        return view('admin/feedback/view', $this->data);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->feedback->my_save(['status' => $request->post('status')], $id);
        return go_to(url_a() . 'feedback' . getPage());
    }
}
