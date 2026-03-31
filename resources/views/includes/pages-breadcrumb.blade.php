<section class="banner-inner"
         style="background-image: url('{{ asset('assets/public/images/banner-inner.jpg') }}');">
    <div class="container">
        <div class="banner-inner__wrapper">
            <ul>
                <li>
                    <a href="{{ url('/') }}">{{ p_lang('home') }}</a>
                </li>

                @php
                    $parent = $post->parent()->first();
                @endphp

                @if($parent)
                    <li>
                        <span style="color: white"> / </span>
                        <a href="{{ \App\Models\Menu::resolveLink($parent) }}">
                            {{ _t($parent->title) }}
                        </a>
                    </li>
                @endif

                <li>
                    <span style="color: white"> / </span>
                    <a href="#">{{ _t($title) }}</a>
                </li>
            </ul>

            <h2>{{ _t($title) }}</h2>
        </div>
    </div>
</section>
