<td>
    @if(isset($cats[$post->cat_id]))
        {{ _t($cats[$post->cat_id]->title) }}
    @endif
</td>
