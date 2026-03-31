<div class="tabbable"> <!-- Only required for left/right tabs -->
    <ul class="nav nav-tabs lang_nav" role="tablist">
        @php($i = 1)
        @foreach (getSiteLang() as $key => $language)
            <li class="nav-item">
                <a class="lang_{{ $key }} nav-link {{($i == 1) ? 'active' : '' }} "
                   href="#tab{{ $i++ }}"
                   data-toggle="tab">{{$language }}</a>
            </li>
        @endforeach
    </ul>

    <div class="tab-content">
        @php($i = 1)
        @foreach (getSiteLang() as $key => $val)
            <div class="tab-pane fade {{($i == 1) ? 'show active' : '' }}" id="tab{{ $i++ }}">
                @if(isset($tab_input))
                    @foreach($tab_input as $name => $value)
                        <div class="form-group">
                            <label class="control-label" for="focusedInput">
                                {{$value}}
                            </label>
                            <div class="controls">
                                <input name="{{$name}}[{{ $key }}]"
                                       class="form-control input-xlarge focused titles"
                                       value="{{old("$name [$key]", _t($post->$name ?? '', $key))}}"
                                       type="text">
                            </div>

                        </div>
                    @endforeach
                @endif
                    @if(isset($tab_input2))
                        @foreach($tab_input2 as $name => $value)
                            <div class="form-group">
                                <label class="control-label" for="focusedInput">
                                    {{$value}}
                                </label>
                                <div class="controls">
                                    <input name="{{$name}}[{{ $key }}]"
                                           class="form-control input-xlarge focused"
                                           value="{{old("$name [$key]", _t($post->$name ?? '', $key))}}"
                                           type="text">
                                </div>

                            </div>
                        @endforeach
                    @endif
                @if(isset($tab_note))
                    @foreach($tab_note as $name => $value)
                        <div class="form-group">
                            <label for="input_post_content" class="control-label">{{$value}}</label>
                            <textarea class="form-control {{$name != 'html_content' ? 'moxiecut' : ''}} "
                                      name="{{$name}}[{{ $key }}]"
                                      rows="10">{!! old("$name [$key]", _t($post->$name ?? '', $key)) !!}</textarea>
                        </div>
                    @endforeach
                @endif
                @if(isset($tab_area))
                    @foreach($tab_area as $name => $value)
                        <div class="form-group">
                            <label for="input_post_content" class="control-label">{{$value}}</label>
                            <textarea class="moxiecut form-control"
                                      name="{{$name}}[{{ $key }}]"
                                      rows="10">{!! old("$name [$key]", _t($post->$name ?? '', $key)) !!}</textarea>
                        </div>
                    @endforeach
                @endif
            </div>
        @endforeach
    </div>
</div>
