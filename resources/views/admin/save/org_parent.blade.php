@php
    $tab_input = [
        'title' => a_lang('title'),   // e.g. "PANASIA HOLDING LIMITED"
    ];
    $btns = [];
    $includes = ['status', 'btns'];
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    {{-- options = label, e.g. "Parent Holding" --}}
    <x-admin.input :post="$post ?? null" name="options" :value="a_lang('label')"/>
    {{-- options2 = subtitle/location, e.g. "Abu Dhabi, UAE" --}}
    <x-admin.input :post="$post ?? null" name="options2" :value="a_lang('location')"/>
    @include("admin/save_components/includes")
</x-admin.save>
