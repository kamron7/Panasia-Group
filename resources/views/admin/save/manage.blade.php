@php
    $tab_input = [
        'title' => a_lang('title'),
    ];
     $tab_input2 = [
        'short_content' => a_lang('post'),
        'content' => a_lang('Reception_days'),
    ];
    $btns = array('media');
    $includes = array('status', 'alias', 'btns');
//     $cats = \App\Models\Region::gets(['sort' => 'asc']);
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    <x-admin.input :post="$post ?? null" name="options" :value="a_lang('phone')"/>
    @include("admin/save_components/includes")
</x-admin.save>
