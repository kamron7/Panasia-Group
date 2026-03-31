<x-app-layout>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Управление пользователями </h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= url_a() ?>">Главная</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Управление пользователями </a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
            <div class="form-group breadcrum-right">
                <a href="<?= url_a() . 'users/create' ?>" class="btn btn-primary pull-right" type="button">
                    <i class="icon-plus-sign icon-white"></i>
                    Добавить пользователя
                </a>
            </div>
        </div>
    </div>
    <style type="text/css">
        .red {
            background-color: #FE5A5A !important;
        }

        .red i, .no-red i {
            margin-top: 2px;
        }

        .no-red {
            background: green !important;
        }
    </style>
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link <?= ($sub_sel == 'admin') ? 'active' : '' ?>" href="#admin" data-toggle="tab">Администраторы</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($sub_sel == 'user') ? 'active' : '' ?>" href="#user"
               data-toggle="tab">Пользователи</a>
        </li>
    </ul>

    <div class="tab-content">
        @php($i = 1)
        @foreach ($user_roles as $key => $val)
            <div class="tab-pane  fade <?= ($i == 1) ? 'show active' : '' ?>" id="{{ $val }}">
                @if ($role_admins && $val == 'admin')
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th width="3%">ID</th>
                            <th width="20%">Логин</th>
                            <th width="20%">Почта</th>
                            <th width="4%">Статус</th>
                            <th width="1%"></th>
                            <th width="1%"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($role_admins as $user)
                            <tr >
                                <td><?= $user->id ?></td>
                                <td><?= char_lim($user->username, 50) ?></td>
                                    <?php if ($user->user_type == 'admin' || $user->user_type == 'moderator') {
                                    $name = 'username';
                                } else {
                                    $name = 'phone';
                                }
                                    ?>
                                <td><?= $user->email ?></td>
                                <td>
                                    <div class="onoffswitch1" style="margin-right: 20px;">
                                            <?php $checked = ($user->status) ? 'checked="checked"' : ''; ?>
                                        <input type="checkbox" name="status" class="onoffswitch-checkbox checkbox-onoff"
                                               id="myonoffswitch-<?= $user->id ?>"
                                               <?= $checked ?> data-postid="<?= $user->id ?>">
                                        <label class="onoffswitch-label" for="myonoffswitch-<?= $user->id ?>">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <a class="btn btn-info" href="<?= url_a() . "users/$user->id/edit" ?>"><i
                                            class="fa fa-pencil-square-o"
                                            aria-hidden="true"></i><?php //= a_lang('change') ?>
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-danger" href="{{ route('users.delete', ['user' => $user->id]) }}"
                                       style="font-size: 14px;"><i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                @endif
                @if ($role_users && $val == 'user')
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th width="3%">ID</th>
                            <th width="20%">Логин</th>
                            <th width="20%">Почта</th>
                            <th width="4%">Статус</th>
                            <th width="1%"></th>
                            <th width="1%"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($role_users as $user)
                            <tr>
                                <td><?= $user->id ?></td>
                                <td><?= char_lim($user->username, 50) ?></td>
                                    <?php if ($user->user_type == 'admin' || $user->user_type == 'moderator') {
                                    $name = 'username';
                                } else {
                                    $name = 'phone';
                                }
                                    ?>
                                <td><?= $user->email ?></td>
                                <td>
                                    <div class="onoffswitch1" style="margin-right: 20px;">
                                            <?php $checked = ($user->status) ? 'checked="checked"' : ''; ?>
                                        <input type="checkbox" name="status" class="onoffswitch-checkbox checkbox-onoff"
                                               id="myonoffswitch-<?= $user->id ?>"
                                               <?= $checked ?> data-postid="<?= $user->id ?>">
                                        <label class="onoffswitch-label" for="myonoffswitch-<?= $user->id ?>">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <a class="btn btn-info" href="<?= url_a() . 'users/edit/'. $user->id ?>">
                                        <i class="fa fa-pencil-square-o"
                                           aria-hidden="true"></i><?php //= a_lang('change') ?>
                                    </a>
                                </td>
                                <td>
                                    <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="post"
                                          style="font-size: 14px;">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger" type="submit"><i class="fa fa-trash"
                                                                                        aria-hidden="true"></i></button>
                                    </form>
                                    {{--                                            <a class="btn btn-danger" href="{{ route('users.destroy', ['user' => $user->id]) }}" style="font-size: 14px;">--}}
                                    {{--                                                <i class="fa fa-trash" aria-hidden="true"></i>--}}
                                    {{--                                            </a>--}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            @php($i++)
        @endforeach
    </div>
</x-app-layout>

