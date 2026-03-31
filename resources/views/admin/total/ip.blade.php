<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th width="20%">{{ a_lang('name') }}</th>
        <th width="20%">IP</th>
        <th width="1%">{{ a_lang('status') }}</th>
        <th width="1%"></th>
        <th width="1%"></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($posts as $post)
        <tr>
            <td>{{ $post->name }}</td>
            <td>{{ $post->ip_address }}</td>
            @include('admin.list_components.status')
            @include('admin.list_components.edit')
            @include('admin.list_components.delete')
        </tr>
    @endforeach
    </tbody>
</table>

@if ($pager)
    {!! $pager !!}
@endif
