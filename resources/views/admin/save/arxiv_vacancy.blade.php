@php
    $tab_input = [
        'title' => a_lang('title'),
    ];
    $tab_note = [
        'short_content' => a_lang('short_content'),
        'content' => a_lang('content'),
    ];
    $btns = ['media'];
    $includes = ['status', 'alias', 'btns'];

    $vacancyCats = \App\Models\Main::where('group', 'vacancy_category')->orderBy('sort_order')->get();
    $structurals = \App\Models\Main::where('group', 'structural')->orderBy('sort_order')->get();
    $regions     = \App\Models\Main::where('group', 'city')->orderBy('sort_order')->get();
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")

    <div class="form-group">
        <label for="cat_id">{{ a_lang('vacancy_category') }}</label>
        <select name="cat_id" id="cat_id" class="form-control">
            <option value="">{{ a_lang('select') }}</option>
            @foreach($vacancyCats as $cat)
                <option value="{{ $cat->id }}"
                        @if(isset($post) && $post->cat_id == $cat->id) selected @endif>
                    {{ _t($cat->title) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="cat_id2">{{ a_lang('structural') }}</label>
        <select name="cat_id2" id="cat_id2" class="form-control">
            <option value="">{{ a_lang('select') }}</option>
            @foreach($structurals as $cat)
                <option value="{{ $cat->id }}"
                        @if(isset($post) && $post->cat_id2 == $cat->id) selected @endif>
                    {{ _t($cat->title) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="options">{{ a_lang('city') }}</label>
        <select name="options" id="options" class="form-control">
            <option value="">{{ a_lang('select') }}</option>
            @foreach($regions as $region)
                <option value="{{ $region->id }}"
                        @if(isset($post) && $post->options == $region->id) selected @endif>
                    {{ _t($region->title) }}
                </option>
            @endforeach
        </select>
    </div>

    @include("admin/save_components/includes")
</x-admin.save>
