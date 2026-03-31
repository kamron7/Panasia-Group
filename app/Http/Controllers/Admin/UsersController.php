<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Core\AdminController;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class UsersController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['sel'] = 'users';
        $this->data['user_type'] = 'admin';
        $this->data['user_types'] = array('admin', 'user');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        session(['sel' => 'users']);
        session()->remove('sel_g');
        $this->data['role_admins'] = User::where('role', 'admin')->get();
        $this->data['role_users'] = User::where('role', 'user')->get();
        $this->data['user_roles'] = ['admin', 'user'];

        $this->data['sub_sel'] = 'admin';
        return view('admin.users.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->data['sub_sel'] = 'admin';
        return view('admin.users.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $validatedData = $request->validate([
                'username' => 'required|string|max:255',
                'email' => 'required|email|unique:users|max:255',
                'active' => 'required|boolean',
                'ban' => 'required|string',
                'password' => 'required|string|min:6',
            ]);

            $user = [
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
                'active' => $validatedData['active'],
                'status' => $validatedData['ban'],
                'pass' => $validatedData['password'],
                'password' => bcrypt($validatedData['password'])
            ];
//            dd($user);
            User::create($user);
            return go_to(url_a() . 'users');
        } catch (ValidationException $e) {
            // Validation failed, handle the error
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
//        $user = User::find($id);
        return view('admin.users.edit', [
            'user' => $user,
            'user_types' => ['admin', 'user'],
            'type' => $user->role
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $data = [
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'active' => $request->input('active'),
            'status' => $request->input('ban'),
            'role' => $request->input('user_type')
        ];
        if (strlen($request->input('password')) > 1) {
            $data = [
                'pass' => $request->input('password'),
                'password' => bcrypt($request->input('password'))
            ];
        }
        $user->update($data);
        return redirect()->route('users.index', $user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return redirect()->route('users.index');
    }

    public function generate_password(): Application|Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $pass = Str::random(10);
        return response(['pass' => $pass]);
    }
}
