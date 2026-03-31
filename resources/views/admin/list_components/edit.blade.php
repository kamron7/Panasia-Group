@php($type_group = isset($edit_type_group) ? "/$post->group" : '')
@php($type_cat = isset($edit_type_cat))
<td>
    <div class="btn-group">
        @php($link = $sel == 'docs' ? "/$group/$cat_id"  : $type_group)
        @php($link = $type_cat ? "/$cat->id" : $link)
        <a href="{{ url_a() . "$sel/edit$link/$post->id" . getPage() }}"
           class="btn btn-small btn-info"><i class="icon-edit icon-white"></i></a>
    </div>
</td>
