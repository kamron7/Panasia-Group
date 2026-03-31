@php
    $tab_input = [
        'title' => a_lang('title'),
    ];
    $tab_input2 = [
        'option1' => a_lang('option1_votes'),
        'option2' => a_lang('option2_votes'),
        'option3' => a_lang('option3_votes'),
        'option4' => a_lang('option4_votes'),
        'option5' => a_lang('option5_votes'),
        'option6' => a_lang('option6_votes'),
    ];
    $includes = array('status',);
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    @include("admin/save_components/includes")
</x-admin.save>
