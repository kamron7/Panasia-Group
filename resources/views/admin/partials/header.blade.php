<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="navbar-collapse" id="navbar-mobile">
                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu d-xl-none mr-auto">
                            <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                    class="ficon feather icon-menu"></i></a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav bookmark-icons">
                        @if ($sel != 'main')
                            <li class="nav-item d-none d-lg-block">
                                <a class="nav-link" href="{{ url_a() }}" data-toggle="tooltip" data-placement="top"
                                   title="Главная">
                                    <i class="ficon fa fa-home"></i> {{ a_lang('main') }}
                                </a>
                            </li>
                        @endif
                        @if (checkUserGroup())
                            <li class="nav-item d-none d-lg-block">
                                <a class="nav-link" href="{{ url_a() }}site/edit/1"
                                   data-toggle="tooltip" data-placement="top" title="Настройки сайта">
                                    <i class="ficon fa fa-cog"></i> {{ a_lang('site_settings') }}
                                </a>
                            </li>
                        @endif
                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link" href="{{ url_p() }}" data-toggle="tooltip" data-placement="top"
                               title="Перейти на сайт" target="_blank">
                                <i class="ficon fa fa-external-link"></i>
                                {{ a_lang('site_to') }}
                            </a>
                        </li>
                    </ul>
                </div>
                <ul class="nav navbar-nav float-right">
                    <li class="nav-item d-flex align-items-center">
                        <a class="na nav-link-expand"><i class="ficon feather icon-maximize"></i></a>
                    </li>

                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <div class="user-nav d-sm-flex d-none">
                                <span class="user-name text-bold-600"
                                      style="margin: 0;">{{ auth()->user()->username }}</span>
                                <span class="user-status"></span>
                            </div>
                            <span><img class="round" src="{{assets_a() }}app-assets/images/logo/osg_logo-01.svg"
                                       alt="avatar" height="40" width="40"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link style="padding: 10px 15px!important;" class="dropdown-item"
                                                 :href="route('logout')"
                                                 onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ a_lang('logout') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
