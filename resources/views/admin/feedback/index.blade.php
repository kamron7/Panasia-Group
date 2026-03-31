<x-app-layout>

    <h2>{{ a_lang('feedback') }} </h2>

    @if($posts)
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th width="1%">№</th>
                <th width="3%">{{ a_lang('date_and_time') }}</th>
                <th width="5%">Ф.И.О</th>
                <th width="6%">E-mail</th>
                <th width="6%">Телефон</th>
                
<th width="5%">Как вам обращаться</th>
                <th width="1%"></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($posts as $post)
                <a href="{{url_a() . "feedback/$post->id"}}">
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->created_at->format('d.m.Y H:i:s') }}</td>
                        <td>{{ $post->fio }}</td>
                        <td>{{ $post->email }}</td>
                        <td>{{ $post->phone }}</td>
<td>{{ char_lim($post->message, 25) }}</td>
                        @include('admin.list_components.edit')
                    </tr>
                </a>
            @endforeach
            </tbody>
        </table>
    @endif

    @if ($pager)
        {!! $pager !!}
    @endif
</x-app-layout>
