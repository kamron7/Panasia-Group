<table class="table table-striped table-bordered table-hover" id="list">
    <thead>
    <tr>
        <th width="1%"></th>
        @if($sel == 'vacancy')
            <th width="1%"></th>
        @endif
        @if($sel == 'arxiv_vacancy')
            <th width="1%"></th>
        @endif
        {{--            <th width="5%"></th>--}}

        {{--        <th width="5%" class="text-center">{{ a_lang('date_create') }}</th>--}}

        <th width="50%">{{ a_lang('name') }}</th>

        <th width="1%"></th>
        <th width="1%"></th>
        <th width="1%">{{ a_lang('status') }}</th>
        <th width="1%"></th>
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
            <td><a class="btn btn-mini move" href="#" title="Перемещать"><i class="fa fa-arrows"></i></a></td>
            {{--                @if($sel !== 'banner')--}}
            {{--                    @include('admin.list_components.sort_order_posts')--}}
            {{--                @endif--}}
{{--            @if(in_array($sel, ['banner']))--}}
{{--                @include('admin.list_components.img')--}}
{{--            @endif--}}
            @if($sel == 'vacancy')
                @include('admin.list_components.arxiv')
            @endif
            @if($sel == 'arxiv_vacancy')
                @include('admin.list_components.ne_arxiv')
            @endif
            {{--            @include('admin.list_components.time')--}}
            <td class="click"
                data-url="{{ url_a() . "main/edit/$sel/$post->id" . getPage() }}">{{ char_lim($displayTitle, 90) }}</td>

            @include('admin.list_components.lang')
            @include('admin.list_components.edit', ['edit_type_group' => true, 'sel' => 'main'])
            @include('admin.list_components.status')
            @include('admin.list_components.delete', ['sel' => 'main'])
        </tr>
    @endforeach
    </tbody>
</table>
<script>
    $(document).on('click', '.js-change-group', function (e) {
        e.preventDefault();

        let $btn   = $(this);
        let id     = $btn.data('id');
        let group  = $btn.data('group');

        $.ajax({
            url: '{{ route('admin.main.change_group') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                group: group
            },
            success: function (res) {
                if (res.success) {
                    $('#item-' + id).fadeOut(200, function () {
                        $(this).remove();
                    });

                } else {
                    alert('Ошибка при смене группы');
                }
            },
            error: function () {
                alert('Ошибка при смене группы');
            }
        });
    });
</script>

@if ($pager)
    {!! $pager !!}
@endif





