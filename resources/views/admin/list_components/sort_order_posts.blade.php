<td>
    <div class="btn-group sort_order_block">
        <form action="{{ url_a() . "$sel/sort_order_posts" }}" method="post"
              style="margin-bottom: -10px;">
            @csrf
            <input type="text" name="sort_order" style="width: 45px;"
                   value="{{ $post->sort_order }}"/>
            <input type="hidden" name="id" value="{{ $post->id }}"/>
            <button type="submit" class="btn"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
        </form>
    </div>
</td>