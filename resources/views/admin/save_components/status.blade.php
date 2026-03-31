@if(isset($post) and $post)
    <div class="form-group">
        <label class="control-label" for="focusedInput">Статус</label>
        <div class="controls">
            @php($checked = ($post->status ?? false) ? 'checked="checked"' : '')
            <div class="onoffswitch1">
                <input type="checkbox" name="status" class="onoffswitch-checkbox checkbox-onoff-save"
                       id="myonoffswitch-{{ $post->id }}" {{ $checked }} data-postid="{{ $post->id }}">
                <label class="onoffswitch-label" for="myonoffswitch-{{ $post->id }}">
                    <span class="onoffswitch-inner"></span>
                    <span class="onoffswitch-switch"></span>
                </label>
            </div>
        </div>
    </div>
@endif
