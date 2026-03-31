<table class="table table-striped table-bordered table-hover" id="list">
    <thead>
    <tr>
        <th width="1%"></th>
        <th width="5%"></th>
        <th width="5%" class="text-center">{{ a_lang('date_create') }}</th>
        <th width="50%">{{ a_lang('title') }}</th>
        <th width="1%"></th>
        <th width="1%">{{ a_lang('status') }}</th>
        <th width="1%"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($posts as $post)
        <tr id="item-{{ $post->id }}">
            <td>
                <a class="btn btn-mini move" href="#" title="Перемещать"><i class="fa fa-arrows"></i></a>
            </td>
            @include('admin.list_components.sort_order_posts')
            @include('admin.list_components.time')
            <td class="click" data-url="{{ url_a() . "$sel/edit/$cat->id/$post->id" . getPage() }}">{{ char_lim(_t($post->title), 90) }}</td>
            @include('admin.list_components.edit', ['edit_type_cat' => true])
            @include('admin.list_components.status')
            @include('admin.list_components.delete')
        </tr>
    @endforeach
    </tbody>
</table>

@if ($pager)
    {!! $pager !!}
@endif
