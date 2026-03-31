@php
    $tab_input = [
        'title' => a_lang('title'),         // display value, e.g. "info@panasiagroup.ae"
        'short_content' => a_lang('label'), // card label, e.g. "Email"
    ];
    $btns = [];
    $includes = ['alias', 'status', 'btns'];
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    {{-- options = link href (mailto:, tel:, or empty for plain text) --}}
    <x-admin.input :post="$post ?? null" name="options" :value="a_lang('link')"/>
    {{-- options2 = icon type: email | phone | location | clock --}}
    <x-admin.input :post="$post ?? null" name="options2" :value="a_lang('icon')"/>
    @include("admin/save_components/includes")
</x-admin.save>
