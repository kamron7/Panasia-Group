@php($sel = session('sel') ?? '')
<x-app-layout>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">
                        @if($sel == 'users')
                            Управление пользователями
                        @else
                            {{ a_lang($sel) }}
                        @endif
                    </h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url_a() }}">{{ a_lang('main') }}</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        @if(!in_array($sel, ['resumes', 'appeal', 'virtual']))
        <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
            <div class="form-group breadcrum-right">
                <a href="{{ url_a() . "$sel/create" }}" class="btn btn-primary pull-right" type="button">
                    <i class="icon-plus-sign icon-white"></i>
                    <span>{{ a_lang('add') }}</span>
                </a>
            </div>
        </div>
        @endif
    </div>

    @if(isset($posts) and $posts)
        @if($sel != 'users')
            @include('admin/partials/filter_posts')
        @endif
        <div class="clearfix"></div>

        <div id="ajax">
            @switch($sel)
                @case('ip') @include ('admin/total/ip') @break
                @case('users') @include ('admin/total/users') @break
                @default @include ('admin/total/list') @break
            @endswitch
        </div>
    @endif
    @if($sel == 'menu')
        @include ('admin/total/menu')
    @endif
</x-app-layout>

