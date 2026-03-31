@php
    $model = getTables()[$sel];
@endphp
<td>
    <a href="{{ url_a() . "$sel/cats/$post->id" }}"
       class="btn btn-small btn-info">
        {{ a_lang($sel."_inner") }}
        ({{ $model->count(['cat_id' => $post->id]) }})
    </a>
</td>
