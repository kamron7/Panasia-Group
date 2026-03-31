@php
    $tab_input = [
        'title' => a_lang('title'),
    ];
    $tab_note = [
        'content' => a_lang('content'),
    ];
$btns = array('media');
    $includes = array('status', 'alias', 'btns');
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    <x-admin.input :post="$post ?? null" name="code" :value="a_lang('link')"/>
{{--    <x-admin.input :post="$post ?? null" name="video_code" :value="a_lang('links')"/>--}}
    @include("admin/save_components/includes")
</x-admin.save>
