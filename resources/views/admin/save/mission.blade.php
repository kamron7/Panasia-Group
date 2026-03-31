@php
    $tab_input = [
        'title' => a_lang('title'),  // heading, e.g. "Integrating Central Asian energy..."
    ];
    $tab_note = [
        'content' => a_lang('content'),  // full mission body paragraph
    ];
    $btns = [];
    $includes = ['status', 'btns'];
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    @include("admin/save_components/includes")
</x-admin.save>
