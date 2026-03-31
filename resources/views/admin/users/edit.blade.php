<x-app-layout>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0"> Редактировать пользователя</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url_a() }}">Главная</a>
                            </li>
                            <li class="breadcrumb-item"><a
                                    href="{{ url_a() . 'users' }}">Назад </a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST" class="form-horizontal"
          enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <fieldset>
            <div class="form-group">
                <label class="control-label" for="focusedInput">Имя пользователя</label>
                <div class="controls">
                    <input name="username" class="form-control input-xlarge focused" required="" id="username"
                           type="text" value="{{ old('username', $user->username) }}"
                           autocomplete="new-username">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="focusedInput">E-mail</label>
                <input name="email"
                       class="form-control input-xlarge focused"
                       id="email" type="email"
                       value="{{ old('email', $user->email) }}"
                       autocomplete="new-email">
            </div>

            <div class="form-group">
                <label class="control-label" for="focusedInput">Пароль</label>
                <p><a href="#!" class="generate_password">Генератор пароля:</a>&nbsp; <b id="generate_pass"></b></p>
                <div class="controls">
                    <input name="password" class="form-control input-xlarge focused" type="password" id="password_value"
                           value="{{ old('password', 0) }}" autocomplete="new-password">
                </div>
            </div>
            @if (session('error') !== null)
                <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
            @elseif (session('errors') !== null)
                <div class="alert alert-danger" role="alert">
                    @if (is_array(session('errors')))
                        @foreach (session('errors') as $error)
                            {{ $error }}
                            <br>
                        @endforeach
                    @else
                        {{ session('errors') }}
                    @endif
                </div>
            @endif
            <div class="form-group">
                <label class="control-label" for="focusedInput">Заблокировать пользователя</label>
                <div class="controls">
                    <select name="ban" class="form-control input-xlarge focused">
                        <option value="null">Нет</option>
                        <option value="banned" {{ (@$user->status == 'banned') ? 'selected' : '' }}> Да</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label" for="selectError">Тип пользователя</label>
                <div class="controls">
                    <select name="user_type" id="selectError" class="form-control">
                        @foreach ($user_types as $ut)
                            <option
                                value="{{ $ut }}" {{ old('user_type', $ut) == $user->role }} >{{ $ut }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="vs-checkbox-con vs-checkbox-primary">
                    <input type="checkbox" name="status"
                           value="1" {{ $user->status == '1' ? 'checked' : '' }}>
                    <span class="vs-checkbox vs-checkbox-lg">
                        <span class="vs-checkbox--check">
                            <i class="vs-icon feather icon-check"></i>
                        </span>
                    </span>
                    <span class="">Активный</span>
                </div>
            </div>

            <input type="hidden" id="post_id" name="post_id"
                   value="{{ old('user_id', $user->id ) }}"/>

            <div class="form-actions">
                <button type="reset" class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light"
                        onclick="history.go(-1)">Отмена
                </button>
                <button type="submit"
                        class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Сохранить
                </button>
            </div>
        </fieldset>
    </form>

    <script>
        jQuery('.generate_password').click(function (e) {
            e.preventDefault();
            jQuery.ajax({
                type: 'post',
                data: {'_token': "{{csrf_token()}}"},
                url: '{{ url_a() . 'users/generate_password' }}',
                success: function (data) {
                    jQuery('#generate_pass').html(data.pass);
                    jQuery('#password_value').val(data.pass);
                },
                error: function (data) {
                }
            });
            return false;
        });

    </script>
</x-app-layout>
