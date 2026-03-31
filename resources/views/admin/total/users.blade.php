@php($user_roles = ['admin', 'user'])
<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" href="#admin" data-toggle="tab">Администраторы</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#user"
           data-toggle="tab">Пользователи</a>
    </li>
</ul>

<div class="tab-content">
    @php($i = 1)
    @foreach ($user_roles as $val)
        <div class="tab-pane  fade <?= ($i == 1) ? 'show active' : '' ?>" id="{{ $val }}">
            <table class="table table-striped table-bordered" id="list">
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
                @foreach ($posts->where('role', $val) as $post)
                    <tr id="item-{{ $post->id }}">
                        <td><?= $post->id ?></td>
                        <td class="click"
                            data-url="{{ url_a() . "$sel/edit/$post->id" . getPage() }}"><?= char_lim($post->username, 50) ?></td>
                        <td><?= $post->email ?></td>
                        @include('admin.list_components.status')
                        @include('admin.list_components.edit')
                        @include('admin.list_components.delete')
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @php($i++)
    @endforeach
</div>
