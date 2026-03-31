@if(isset($cats) and  $cats)
    <div class="form-group ">
        <label class="control-label" for="focusedInput">{{ a_lang('sources1') . ' ' . a_lang('category') }}</label>
        <div class="controls">
            <select id="category_id2" name="cat_id" class="input-xlarge focused form-control w-auto">
                <option value="0">{{ a_lang('no_category') }}</option>
                @foreach ($cats as $item)
                    @php($item = (object)$item)
                    <option value="{{ $item->id }}"
                        {{ $post->cat_id ?? -1 == $item->id ? 'selected="selected"' : '' }}>
                        {{ $item->title }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
@endif
