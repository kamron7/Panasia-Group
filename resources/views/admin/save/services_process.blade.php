@php
    $tab_input = [
        'title'         => a_lang('title'),         // e.g. "Deal Origination"
        'short_content' => a_lang('short_content'), // description paragraph
    ];
    $btns = [];
    $includes = ['alias', 'status', 'btns'];
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    {{-- options = step label, e.g. "Step 01" --}}
    <x-admin.input :post="$post ?? null" name="options" :value="a_lang('step_label')"/>
    @include("admin/save_components/includes")
</x-admin.save>
