@if(!in_array($sel, ['polls', 'opendata', 'orders']))
    <table class="table table-striped table-bordered table-hover" id="list">
        <thead>
        <tr>
            @if(!in_array($sel, ['news', 'products', 'video', 'opendata']))
                <th width="1%"></th>
            @endif
            @if(in_array($sel, [ 'news']))
                <th width="2%"></th>
            @endif
            @if(!in_array($sel, ['pages', 'news']))
                <th width="5%"></th>
            @endif
            @if(!in_array($sel, ['opendata']))
                <th width="5%" class="text-center">{{ a_lang('date_create') }}</th>
            @endif
            <th width="40%">{{ a_lang('title') }}</th>
            @if($sel == 'pages')
                <th width="15%">{{ a_lang('options') }}</th>
            @endif
            <th width="3%">{{ a_lang('lang') }}</th>
            <th width="1%"></th>
            <th width="1%"></th>
            <th width="1%">{{ a_lang('status') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            @php
                $currentLang = app()->getLocale();

                $titleArray = is_string($post->title) ? json_decode($post->title, true) : (array)$post->title;

                $displayTitle = '';

                if (!empty($titleArray[$currentLang])) {
                    $displayTitle = $titleArray[$currentLang];
                }
                else {
                    $fallbackLangs = ['en', 'ru', 'oz'];
                    foreach ($fallbackLangs as $lang) {
                        if (!empty($titleArray[$lang])) {
                            $displayTitle = $titleArray[$lang];
                            break;
                        }
                    }
                }

                if (empty($displayTitle) && !empty($titleArray)) {
                    $displayTitle = reset($titleArray);
                }
            @endphp
            <tr id="item-{{ $post->id }}">
                @if(!in_array($sel, ['news']))
                    <td>
                        @if($sel == 'pages')
                            {{$post->id}}
                        @else
                            <a class="btn btn-mini move" href="#" title="Перемещать"><i class="fa fa-arrows"></i></a>
                        @endif
                    </td>
                @endif
                @if(in_array($sel, ['gallery', 'news']))
                    @include('admin.list_components.img')
                @endif
                @if(!in_array($sel, ['opendata']))
                    @include('admin.list_components.time')
                @endif
                <td class="click"
                    data-url="{{ url_a() . "$sel/edit/$post->id" . getPage() }}">{{ char_lim($displayTitle, 90) }}</td>
                @if($sel == 'pages')
                    <td><code style="font-size:11px;color:#6c757d;">{{ $post->options }}</code></td>
                @endif
                @if(in_array($sel, ['news']))
                    @include('admin.list_components.cats_name', ['cats' => $cats])
                @endif
                @include('admin.list_components.lang')
                @include('admin.list_components.edit')
                @include('admin.list_components.status')
                @include('admin.list_components.delete')
            </tr>
        @endforeach
        </tbody>
    </table>

    @if ($pager)
        {!! $pager !!}
    @endif

    <script>
        function toGo($this) {
        }
    </script>
@endif

@if($sel === 'opendata')
    <table class="table table-striped table-bordered table-hover" id="list">
        <thead>
        <tr>
            <th width="5%">ID</th>
            <th width="60%">{{ a_lang('title') }}</th>
            <th width="5%" class="text-center">{{ a_lang('table_') }}</th>
            <th width="5%" class="text-center">Версии</th>
            <th width="1%" class="text-center"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            @php
                $currentLang = app()->getLocale();

                $titleArray = is_string($post->title)
                    ? json_decode($post->title, true)
                    : (array)$post->title;

                $displayTitle = '';

                if (!empty($titleArray[$currentLang])) {
                    $displayTitle = $titleArray[$currentLang];
                } else {
                    $fallbackLangs = ['en', 'ru', 'oz'];
                    foreach ($fallbackLangs as $lang) {
                        if (!empty($titleArray[$lang])) {
                            $displayTitle = $titleArray[$lang];
                            break;
                        }
                    }
                }

                if (empty($displayTitle) && !empty($titleArray)) {
                    $displayTitle = reset($titleArray);
                }

                $ruTitle = $titleArray['ru'] ?? null;
                $archiveId = $ruTitle ? ($archiveMap[$ruTitle] ?? null) : null;
            @endphp

            <tr id="item-{{ $post->id }}">
                <td>{{ $post->id }}</td>

                <td class="click"
                    data-url="{{ url_a() . "opendata/edit/$post->id" . getPage() }}">
                    {{ char_lim($displayTitle, 90) }}
                </td>

                <td class="text-center">
                    <a href="{{ route('admin.opendata.table', $post->id) }}"
                       class="btn btn-small btn-success"
                       title="Просмотр таблицы">
                        Таблица
                    </a>
                </td>

                <td class="text-center">
                    @if($archiveId)
                        <a href="{{ url_a() . "docs/archive_data/$archiveId" }}"
                           class="btn btn-small btn-primary"
                           title="Документ-версии архива">
                            Версии
                        </a>
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>

                <td class="text-center">
                    @include('admin.list_components.status')
                    @include('admin.list_components.edit')
                    @include('admin.list_components.delete')
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @if ($pager)
        {!! $pager !!}
    @endif
@endif


@if($sel === 'polls')
    <table class="table table-striped table-bordered table-hover" id="list">
        <thead>
        <tr>
            <th width="1%">ID</th>
            <th width="50%">{{ a_lang('title') }}</th>
            <th width="5%" class="text-center">{{ a_lang('option1_votes') }}</th>
            <th width="5%" class="text-center">{{ a_lang('option2_votes') }}</th>
            <th width="5%" class="text-center">{{ a_lang('option3_votes') }}</th>
            <th width="5%" class="text-center">{{ a_lang('option4_votes') }}</th>
            <th width="5%" class="text-center">{{ a_lang('option5_votes') }}</th>
            <th width="5%" class="text-center">{{ a_lang('option6_votes') }}</th>
            <th width="1%" class="text-center"></th>
            <th width="2%" class="text-center">Статус</th>
            <th width="1%" class="text-center"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr id="item-{{ $post->id }}">
                <td class="text-center">{{ $post->id }}</td>
                <td>{{ char_lim(_t($post->title), 90) }}</td>
                <td class="text-center">{{ $post->option1_votes }}</td>
                <td class="text-center">{{ $post->option2_votes }}</td>
                <td class="text-center">{{ $post->option3_votes }}</td>
                <td class="text-center">{{ $post->option4_votes }}</td>
                <td class="text-center">{{ $post->option5_votes }}</td>
                <td class="text-center">{{ $post->option6_votes }}</td>
                @include('admin.list_components.edit')
                @include('admin.list_components.status')
                @include('admin.list_components.delete')
            </tr>
        @endforeach
        </tbody>
    </table>

    @if ($pager)
        {!! $pager !!}
    @endif
@endif


