@php
    use Illuminate\Support\Str;

    $sel = $sel ?? session('sel', '');
    $currentUrl = request()->path();
    $excludedUrls = ['new', 'congurat-view', 'relationships-view'];
    $isNewsPage = Str::contains($currentUrl, $excludedUrls);
@endphp

@if (isset($cat) && $cat && isset($list) && $list)
    <div class="sidebar">
        <div class="sidebar-menu">
            {{-- Sidebar title like old: <h5>...</h5> --}}
            <h5>{{ _t($cat->title) }}</h5>

            <ul class="list-unstyled main-collapse">
                @foreach ($list as $item)
                    @php
                        // ----- LINK + ACTIVE LOGIC (same backend idea as your current code) -----
                        if ($item->inner_link) {
                            $link     = $item->inner_link;
                            $active   = $item->inner_link;
                            $fullLink = url_p() . '/' . ltrim($link, '/');
                            $target   = '';
                        } elseif ($item->external_link) {
                            $link     = $item->external_link;
                            $active   = $item->external_link;
                            $fullLink = $link;
                            $target   = 'target="_blank"';
                        } else {
                            $link     = 'menu/' . $item->alias;
                            $active   = $item->alias;
                            $fullLink = url_p() . '/' . $link;
                            $target   = '';
                        }

                        $hasChildren = isset($item->children) && count($item->children) > 0;

                        // Additional logic for active state (kept from your code)
                        $cat_active = false;
                        if ($item->id == 15) {
                            foreach (getPostsNew(['group' => 'news_category', 'status' => 'active', 'status_lang_' . LANG => 'active']) as $cats) {
                                if ($sel == $cats->alias) {
                                    $cat_active = true;
                                }
                            }
                        }

                        $isActive = ($active == $sel)
                            || ($active == ($sel_news ?? null))
                            || (_t($title) == _t($item->title))
                            || $cat_active;
                    @endphp

                    @if ($hasChildren)
                        {{-- PARENT WITH SUBMENU --}}
                        <li class="{{ $isActive ? 'active' : 'no-active' }}">
                            <a href="#item-{{ $item->id }}"
                               data-toggle="collapse"
                               aria-expanded="{{ $isActive ? 'true' : 'false' }}"
                               class="side_toggle">
                                {{ _t($item->title) }}
                                <i class="fa fa-chevron-down"></i>
                            </a>

                            <ul class="collapse sub-menu-sidebar list-unstyled {{ $isActive ? 'show' : '' }}"
                                id="item-{{ $item->id }}">
                                @foreach ($item->children as $child)
                                    @php
                                        if ($child->inner_link) {
                                            $childLink     = $child->inner_link;
                                            $childActive   = $child->inner_link;
                                            $childFullLink = url_p() . '/' . ltrim($childLink, '/');
                                            $childTarget   = '';
                                        } elseif ($child->external_link) {
                                            $childLink     = $child->external_link;
                                            $childActive   = $child->external_link;
                                            $childFullLink = $childLink;
                                            $childTarget   = 'target="_blank"';
                                        } else {
                                            $childLink     = 'menu/' . $child->alias;
                                            $childActive   = $child->alias;
                                            $childFullLink = url_p() . '/' . $childLink;
                                            $childTarget   = '';
                                        }
                                    @endphp
                                    <li>
                                        <a href="{{ $childFullLink }}" {{ $childTarget ?? '' }}>
                                            {{ _t($child->title) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        {{-- SIMPLE ITEM WITHOUT SUBMENU --}}
                        <li class="{{ $isActive ? 'active' : 'no-active' }}">
                            <a href="{{ $fullLink }}" {{ $target ?? '' }}>
                                {{ _t($item->title) }}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
@endif
