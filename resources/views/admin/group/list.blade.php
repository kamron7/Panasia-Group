<table class="table table-striped table-bordered table-hover" id="list">
    <thead>
    <tr>
        <th width="5%"></th>
        @if(!in_array($sel, ['news', 'events']))
            <th width="5%"></th>
        @endif
        <th width="5%" class="text-center">{{ a_lang('date_create') }}</th>
        <th width="50%">{{ a_lang('title') }}</th>
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
        <tr id="item-{{ $post->id }}" data-url="{{ url_a() . "$sel/edit/$post->group/$post->id?" . getPage() }}">
            @if(in_array($sel, ['events']))
                @include('admin.list_components.img')
            @else
                <td>
                    <a class="btn btn-mini move" href="#" title="Перемещать"><i class="fa fa-arrows"></i></a>
                </td>
            @endif
            @if(!in_array($sel, ['events', 'news']))
                @include('admin.list_components.sort_order_posts')
            @endif
            @include('admin.list_components.time')
                <td class="click"
                    data-url="{{ url_a() . "$sel/edit/$post->group/$post->id" . getPage() }}">{{ char_lim($displayTitle, 90) }}</td>
                @include('admin.list_components.lang')

            @include('admin.list_components.edit', ['edit_type_group' => true])
            @include('admin.list_components.status')
            @include('admin.list_components.delete')
        </tr>
    @endforeach
    </tbody>
</table>

@if ($pager)
    {!! $pager !!}
@endif
