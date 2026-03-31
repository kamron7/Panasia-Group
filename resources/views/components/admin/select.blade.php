@props(['name' => 'cat_id', 'value' => a_lang('category'), 'post' => (object) [], 'cats' => '', 'options' => '', 'class' => 'w-25' ])

<div class="form-group">
    <label class="control-label" for="focusedInput">{{$value}}</label>
    <div class="controls">
        <select id="{{$name}}" name="{{$name}}" class="input-xlarge focused form-control {{$class}} ">
            @if ($cats)
                <option value="0">Нет категории</option>
                @foreach ($cats as $cat)
                    @php($cat = (object)$cat)
                    @if ($cat->id !== ($post->id ?? ''))
                        <option value="{{ $cat->id }}"
                                @if ($cat->id == ($post->cat_id ?? ''))
                                    selected="selected" @endif>
                            @if(session('sel', false) == 'smi')
                                {{ $cat->title }}
                            @else
                                {{ _t($cat->title) }}
                            @endif
                        </option>
                    @endif
                @endforeach
            @endif
            @if($options)
                @foreach($options as $key => $val)
                    <option value="{{ $key }}"
                            @if ($key == ($post->$name ?? ''))
                                selected="selected" @endif>
                        {{$val}}
                    </option>
                @endforeach
            @endif
        </select>
    </div>
</div>
