@php
    $languages = ['en', 'uz', 'ru', 'oz'];
    $available_languages = [];
@endphp

@foreach ($languages as $lang)
    @php
        $title = _t($post->title, $lang) ?? null;
        if ($title) {
            $available_languages[$lang] = $title;
        }
    @endphp
@endforeach

<td>
    <div class="lang-switcher">
        @foreach ($available_languages as $lang => $title)
            @php
                $display_lang = ($lang == 'oz') ? 'OZ' : strtoupper($lang);

                $flag_class = '';

                switch ($lang) {
                    case 'en':
                        $flag_class = 'flag-icon-us';
                        break;
                    case 'uz':
                        $flag_class = 'flag-icon-uz';
                        break;
                    case 'ru':
                        $flag_class = 'flag-icon-ru';
                        break;
                    case 'oz':
                        $flag_class = 'flag-icon-uz';
                        break;
                }
            @endphp

            <div class="div_flag" data-lang="{{ $lang }}">
                <span class="flag-icon {{ $flag_class }}"></span> <p>{{ $display_lang }}</p>
            </div>
        @endforeach
    </div>
</td>

<style>
    .lang-switcher{
        display: flex;
        align-items: center;
    }
    .lang-switcher .div_flag{
        display: flex;
        border: 1px solid #cac9c9;
        border-radius: 6px;
        padding: 3px 5px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
    }
    .lang-switcher .div_flag p{
        margin-bottom: 0;
    }
    .lang-switcher .div_flag span{
        margin-right: 5px;
        position: relative;
        padding-right: 5px;
    }
    .lang-switcher .div_flag + .div_flag{
        margin-left: 8px;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.0/css/flag-icon.min.css">
