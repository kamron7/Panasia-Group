@php
    $tab_input = [
        'title' => a_lang('title'),
    ];
    $tab_note = [
        'short_content' => a_lang('short_content'),
        'content' => a_lang('content'),
    ];
    $btns = array('media', 'docs');
    $cats = \App\Models\Menu::gets(['sort' => 'asc']);
    $includes = array('meta', 'alias', 'status', 'btns');
@endphp
{{--@dd($post)--}}
<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    <div class="row">
        <div class="col-4">
            <x-admin.select :post="$post ?? null" name="cat_id" :value="a_lang('category')"
                            :cats="$cats" class="w-100"/>
        </div>
        <div class="col-4">
            <x-admin.input name="inner_link" :value="a_lang('options')" :post="$post ?? null"/>
        </div>
        <div class="col-4">
            <x-admin.input name="external_link" :value="a_lang('vnesh_link')" :post="$post ?? null"/>
        </div>
    </div>
{{--    <div class="form-group w-25">--}}
{{--        <label class="control-label">{{ a_lang('group') }}</label>--}}
{{--        <div class="controls">--}}
{{--            <?php $group = $post->group ?? 'bottom'; ?>--}}
{{--            <select name="group" class="form-control">--}}
{{--                <option value="bottom" {{ $group == 'bottom' ? 'selected' : '' }}>{{ a_lang('bottom') }}</option>--}}
{{--                <option value="top" {{ $group == 'top' ? 'selected' : '' }}>{{ a_lang('top') }}</option>--}}
{{--            </select>--}}
{{--        </div>--}}
{{--    </div>--}}

    @include("admin/save_components/includes")
</x-admin.save>
