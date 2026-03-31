<td>
    <div class="onoffswitch1">
        @php($checked = ($post->status) ? 'checked="checked"' : '')
        <input type="checkbox" name="status" class="onoffswitch-checkbox checkbox-onoff"
               id="myonoffswitch-{{ $post->id }}" {{ $checked }} data-postid="{{ $post->id }}">
        <label class="onoffswitch-label" for="myonoffswitch-{{ $post->id }}">
            <span class="onoffswitch-inner"></span>
            <span class="onoffswitch-switch"></span>
        </label>
    </div>
</td>