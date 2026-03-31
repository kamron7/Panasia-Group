@php($sel = session('sel') ?? '')
<x-app-layout>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">
                        @if(isset($cat) and $cat)
                            {{ _t($cat->title) }}
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
        <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
            <div class="form-group breadcrum-right">
                <a href="{{ url_a() . "main/create/$sel" }}" class="btn btn-primary pull-right" type="button">
                    <i class="icon-plus-sign icon-white"></i>
                    <span>{{ a_lang('add') }}</span>
                </a>
            </div>
        </div>
    </div>
    @include('admin/partials/filter_posts')

    <div class="clearfix"></div>

    @if($posts)
        <div id="ajax">
            @include ('admin/main/list')
        </div>
    @endif
</x-app-layout>

