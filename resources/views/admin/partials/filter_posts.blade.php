<div class="text-center mb-3">
    <div class="list-group list-group-horizontal justify-content-center mb-2">
        @php($sort = request('sort', ''))
        <a href="?sort=DESC"
           class="list-group-item {{ ($sort == 'DESC') ? 'active-list' : '' }}">
            Сортировка по убыванию
        </a>
        <a href="?sort=ASC"
           class="list-group-item {{ ($sort == 'ASC') ? 'active-list' : '' }}">
            Сортировка по возрастанию
        </a>
        @if(request()->has('sort'))
            <a href="{{ url()->current() }}" class="list-group-item">
                Очистить сортировку
            </a>
        @endif
    </div>

    @if($sel === 'pages')
        <form method="GET" class="d-inline-flex align-items-center gap-2">
            <input type="text" name="title"
                   placeholder="Фильтр по заголовку"
                   value="{{ request('title') }}"
                   class="filter-input">
            <button style="padding: 10px; font-size: 15px" type="submit" class="btn btn-primary btn-sm">Фильтровать</button>
            @if(request()->has('title'))
                <a style="padding: 10px; font-size: 15px" href="{{ url()->current() }}" class="btn btn-secondary btn-sm">Очистить</a>
            @endif

            @foreach(request()->except(['title', 'page']) as $key => $val)
                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
            @endforeach
        </form>
    @endif
</div>

<style>
    .active-list {
        color: #fff;
        background-color: #007bff;
        border-radius: 4px;
        font-weight: 500;
    }

    .list-group-horizontal .list-group-item {
        margin: 0 4px;
        padding: 6px 12px;
        border-radius: 4px;
        border: 1px solid #ddd;
        transition: all 0.2s ease;
    }

    .list-group-horizontal .list-group-item:hover {
        background-color: #f0f0f0;
        cursor: pointer;
    }

    .filter-input {
        padding: 6px 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        min-width: 200px;
        transition: border-color 0.2s;
    }

    .filter-input:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 3px rgba(0,123,255,0.5);
    }

    form.d-inline-flex > * {
        vertical-align: middle;
    }
</style>