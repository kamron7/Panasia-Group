@if(isset($btns))
    <div class="form-group">
        <div class="controls">
            @if(in_array('media', $btns))
                <a href="#myModal" role="button" class="btn btn-info" data-toggle="modal"><i
                        class="icon-file icon-white"></i> {{ a_lang('media') }}</a>
            @endif
            @if(in_array('docs', $btns))
                <a target="_blank" href="{{ url_a() . "docs/$sel/" . ($post->id ?? getDocsKey()) }}"
                   class="btn btn-info">  {{ a_lang('documents') }}</a>
            @endif
        </div>
    </div>
@endif
