@php
    $sel = session('sel', '');
    $model = $model ?? request()->segment(3) ?? '';
    $post_id = session('post_id', '-1');
    $type = session('type', 'edit');
  $media_files = session('docs_media', session('media_files', []));


    $langs = [
        'all' => 'Все',
        'ru'  => 'Русский',
        'en'  => 'English',
        'oz'  => "O'zbekcha (Lotin)",
//        'uz'  => 'Ўзбекча (Кирилл)',
    ];
@endphp


<script>
    const ADMIN_URL = "{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), '/admin/') }}";
</script>

@if(session('ban_message'))
    <div class="alert alert-warning">{{ session('ban_message') }}</div>
@endif

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    @if(session('upload_error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('upload_error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content shadow-sm">
            <div class="modal-header">
                <h5 class="modal-title">{{ a_lang('media') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                {{-- -------------------- Upload Form -------------------- --}}
                <form action="{{ route('admin.media.save') }}" id="media_form" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="media-header d-flex align-items-center flex-wrap mb-3">
                        <div class="progress flex-grow-1 mr-3">
                            <div class="bar"></div>
                            <div class="percent">0%</div>
                        </div>

                        <span class="btn btn-success fileinput-button mr-2">
              <i class="fa fa-plus"></i> <span>{{ a_lang('add') }}</span>
              <input id="file" type="file" name="userfile[]" multiple
                     accept=".jpg,.jpeg,.png,.gif,.webp,.svg,.pdf,.doc,.docx,.xls,.xlsx,.txt,.mp4,.mov,.avi,.mkv,.webm,video/*">
            </span>

                        <span class="btn btn-danger delete_image">
              <i class="fa fa-trash-o"></i> <span>{{ a_lang('delete_all') }}</span>
            </span>

                        <input type="hidden" name="category" value="{{ $sel }}">
                        <input type="hidden" name="model" value="{{ $model }}">
                        <input type="hidden" name="post_id" value="{{ $post_id }}">
                        <input type="hidden" name="type" value="{{ $type }}">
                    </div>
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                </form>

                {{-- -------------------- Media Grid -------------------- --}}
                <div id="reset" class="media-block">
                    <ul id="media_list" class="media-grid list-unstyled">
                        @if(isset($media_files))
                            @foreach(collect($media_files)->sortBy('sort_order') as $mf)
                                @if(($mf->is_thumnail ?? 0) == 1)
                                    @continue
                                @endif

                                <li class="thumb" data-id="{{ $mf->id }}">
                                    {{-- Thumbnail Preview --}}
                                    <a href="{{ url_u($type) . $sel . '/' . $mf->url }}"
                                       class="thumbnail fancybox" rel="group">
                                        @if(preg_match('/\.(jpg|jpeg|png|gif|webp|svg)$/i', $mf->url))
                                            <div class="thumb-figure">
                                                <span class="lang-badge">{{ strtoupper($mf->lang ?? 'all') }}</span>
                                                <img class="thumb-img" src="{{ url_u($type) . $sel . '/' . $mf->url }}"
                                                     alt="preview">
                                            </div>
                                        @else
                                            <div class="thumb-figure thumb-figure--file">
                                                <span class="lang-badge">{{ strtoupper($mf->lang ?? 'all') }}</span>
                                                <i class="fa fa-file file-icon"></i>
                                            </div>
                                        @endif
                                    </a>

                                    <div class="form-group mb-2">
                                        <label class="small text-muted" for="media_lang_{{ $mf->id }}">Язык</label>
                                        <select id="media_lang_{{ $mf->id }}" name="lang"
                                                class="form-control form-control-sm media-lang-select"
                                                data-id="{{ $mf->id }}" data-model="{{ $model }}"
                                                data-post-id="{{ $post_id }}">
                                            @foreach($langs as $code => $label)
                                                <option
                                                    value="{{ $code }}" {{ ($mf->lang ?? 'all') === $code ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="toolbar text-center">
                                        <div class="btn-group">
                                            <a class="btn btn-light btn-sm move" title="Перемещать"><i
                                                    class="fa fa-arrows"></i></a>
                                            <a class="btn btn-sm ajax_set_main {{ $mf->is_main ? 'btn-info' : 'btn-outline-info' }}"
                                               href="{{ url_a() . "media/set_main/$model/$post_id/$mf->id" }}"
                                               data-model="{{ $model }}"
                                               data-post-id="{{ $post_id }}"
                                               data-id="{{ $mf->id }}"
                                               title="Сделать Главным">
                                                <i class="fa fa-arrow-up"></i>
                                            </a>


                                            {{--                                            @if(preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $mf->url))--}}
                                            {{--                                                <a class="btn btn-sm btn-outline-secondary edit-media"--}}
                                            {{--                                                   href="#" data-id="{{ $mf->id }}" data-url="{{ $mf->url }}"--}}
                                            {{--                                                   title="Редактировать">--}}
                                            {{--                                                    <i class="fa fa-pencil"></i>--}}
                                            {{--                                                </a>--}}
                                            {{--                                            @endif--}}

                                            @if(preg_match('/\.(mp4|mov|avi|mkv|webm)$/i', $mf->url))
                                                <button class="btn btn-sm btn-outline-secondary btn-thumb-upload"
                                                        title="Upload Thumbnail"
                                                        data-id="{{ $mf->id }}"
                                                        data-model="{{ $model }}"
                                                        data-post-id="{{ $post_id }}"
                                                        data-category="{{ $sel }}">
                                                    <i class="fa fa-picture-o"></i>
                                                </button>
                                            @endif

                                            @if (preg_match('/\.svg$/i', $mf->url))
                                                <a class="btn btn-sm btn-outline-secondary svg-color-btn"
                                                   href="#" data-id="{{ $mf->id }}" data-url="{{ $mf->url }}"
                                                   data-model="{{ $model }}" data-post-id="{{ $post_id }}"
                                                   data-category="{{ $sel }}" title="Цвет SVG">
                                                    <span class="svg-color-dot"></span>
                                                </a>
                                            @endif

                                            <a class="btn btn-sm btn-outline-danger ajax_delete"
                                               href="{{ url_a() . "media/delete/$model/$post_id/$mf->id" }}"
                                               title="Удалить"><i class="fa fa-trash-o"></i></a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ========================================================= --}}
{{-- EDIT MEDIA MODAL --}}
{{-- ========================================================= --}}

<div class="modal fade" id="editMediaModal" tabindex="-1" role="dialog" aria-labelledby="editMediaModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fa fa-pencil mr-2"></i>Редактировать изображение</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>

            <div class="modal-body p-4">
                <form id="editMediaForm" method="POST" class="form-horizontal">
                    @csrf
                    <input type="hidden" name="media_id" id="edit_media_id">
                    <input type="hidden" name="model" value="{{ $model }}">
                    <input type="hidden" name="post_id" value="{{ $post_id }}">
                    <input type="hidden" name="rotation" id="rotation_angle" value="0">
                    <input type="hidden" name="zoom" id="zoom_level" value="1">

                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-header bg-light"><strong>Редактор изображения</strong></div>
                                <div class="card-body p-2">
                                    <div id="image-cropper" class="bg-light border rounded text-center">
                                        <img id="editable-image" src="" class="img-fluid mx-auto d-block"
                                             style="max-height:450px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-header bg-light"><strong>Настройки</strong></div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Ширина (px)</label>
                                        <input type="number" class="form-control" id="edit_width" name="width" min="100"
                                               max="1200">
                                    </div>
                                    <div class="form-group">
                                        <label>Высота (px)</label>
                                        <input type="number" class="form-control" id="edit_height" name="height"
                                               min="100" max="1200">
                                    </div>
                                    <div class="form-group">
                                        <label>Качество <span id="quality_value"
                                                              class="badge badge-primary float-right">85%</span></label>
                                        <input type="range" id="edit_quality" name="quality" class="custom-range"
                                               min="1" max="100" value="85">
                                        <small class="form-text text-muted">Размер файла: <span id="file_size_estimate">0 KB</span></small>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="watermark_toggle"
                                                   name="watermark_toggle">
                                            <label class="custom-control-label" for="watermark_toggle">Добавить водяной
                                                знак</label>
                                        </div>
                                        <div id="watermark-position-group" style="display:none;" class="mt-2">
                                            <div class="watermark-position-grid"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Пропорции</label>
                                        <select id="aspect_ratio" class="form-control">
                                            <option value="0">Свободные</option>
                                            <option value="1">1:1 (Квадрат)</option>
                                            <option value="1.777">16:9 (Широкий)</option>
                                            <option value="1.333">4:3 (Стандарт)</option>
                                            <option value="0.666">2:3 (Портрет)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Закрыть</button>
                <button class="btn btn-primary" id="saveMediaChanges"><i class="fa fa-save"></i> Применить</button>
            </div>
        </div>
    </div>
</div>

{{-- ========================================================= --}}
{{-- SVG COLOR MODAL --}}
{{-- ========================================================= --}}

<div class="modal fade" id="svgColorModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fa fa-tint mr-2"></i>Цвет SVG</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="svg_media_id">
                <input type="hidden" id="svg_model" value="{{ $model }}">
                <input type="hidden" id="svg_post_id" value="{{ $post_id }}">
                <input type="hidden" id="svg_category" value="{{ $sel }}">
                <input type="hidden" id="svg_url">

                <div class="form-group">
                    <label>Цвет <span id="svgColorSwatch" class="svg-color-dot ml-1"></span></label>
                    <div class="d-flex align-items-center">
                        <input type="color" id="svgColorInput" class="form-control" style="max-width:70px;">
                        <input type="text" id="svgHexInput" class="form-control ml-2" placeholder="#000000"
                               maxlength="9">
                    </div>
                    <small class="form-text text-muted">Поддерживаются #RGB, #RRGGBB, #RRGGBBAA</small>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Отмена</button>
                <button class="btn btn-primary" id="applySvgColorBtn"><i class="fa fa-check"></i> Применить</button>
            </div>
        </div>
    </div>
</div>

{{-- ========================================================= --}}
{{-- VIDEO THUMBNAIL MODAL --}}
{{-- ========================================================= --}}

<div class="modal fade" id="videoThumbModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fa fa-picture-o mr-2"></i>Загрузить превью видео</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>

            <form id="videoThumbForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="model" id="thumb_model" value="{{ $model }}">
                <input type="hidden" name="post_id" id="thumb_post_id" value="{{ $post_id }}">
                <input type="hidden" name="video_media_id" id="thumb_video_id">
                <input type="hidden" name="category" id="thumb_category" value="{{ $sel }}">

                <div class="modal-body">
                    <div class="form-group">
                        <label>Текущее превью</label>
                        <div id="thumb_current_wrap" class="mb-2" style="display:none;">
                            <img id="thumb_current_img" src="" alt="current" class="img-fluid border rounded">
                        </div>
                        <div id="thumb_none" class="text-muted" style="display:none;">Пока нет превью</div>
                    </div>

                    <div class="form-group">
                        <label>Выберите изображение</label>
                        <input type="file" class="form-control" name="thumbnail" id="thumb_file"
                               accept=".jpg,.jpeg,.png,.webp,.gif,.svg,image/*" required>
                        <small class="form-text text-muted">Поддерживаются JPG, PNG, WEBP, GIF, SVG</small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Отмена</button>
                    <button class="btn btn-primary" id="thumbUploadBtn"><i class="fa fa-upload"></i> Загрузить</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ========================================================= --}}
{{-- VIDEO PREVIEW MODAL --}}
{{-- ========================================================= --}}

<div class="modal fade" id="videoPreviewModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bg-dark border-0">
            <div class="modal-header border-0">
                <h5 class="modal-title text-white">Видео предпросмотр</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body p-0">
                <video id="previewVideo" style="width:100%;height:auto;" controls playsinline>
                    <source id="previewVideoSource" src="" type="video/mp4">
                </video>
            </div>
        </div>
    </div>
</div>

{{-- ========================================================= --}}
{{-- STYLE SECTION – Modern Light Theme, Responsive Media Grid --}}
{{-- ========================================================= --}}

<style>
    /* ---------- Global Reset & Basics ---------- */
    * {
        box-sizing: border-box;
    }

    body, html {
        margin: 0;
        padding: 0;
        background: #fff;
    }

    img {
        max-width: 100%;
        height: auto;
        display: block;
    }

    /* ---------- Media Grid Layout ---------- */
    .media-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, max-content));
        gap: 30px;
        justify-content: start;
        padding: 10px;
    }


    .thumb {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.06);
        transition: all 0.25s ease;
        overflow: hidden;
        text-align: center;
    }

    .thumb:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.10);
    }

    /* ---------- Thumbnail Figure ---------- */
    .thumb-figure {
        width: 160px;
        height: 160px;
        margin: 0 auto 0;
        position: relative;
        border-radius: 3px;
        overflow: hidden;
        background: #fafafa;
        display: flex;
        align-items: center;
        justify-content: center;
    }


    .thumb-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .3s ease;
    }

    .thumb:hover .thumb-img {
        transform: scale(1.05);
    }

    .thumb-figure--file {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
        font-size: 48px;
    }

    .lang-badge {
        position: absolute;
        top: 6px;
        right: 6px;
        background: rgba(0, 0, 0, 0.65);
        color: #fff;
        font-size: 10px;
        padding: 3px 6px;
        border-radius: 4px;
        z-index: 2;
        pointer-events: none;
    }

    /* ---------- Toolbar Below Each Tile ---------- */
    .toolbar {
        border-top: 1px solid #f1f1f1;
        padding: 6px 4px 8px;
        background: #fff;
        z-index: 5;
    }

    .toolbar .btn-group .btn {
        margin: 0 2px;
        padding: 4px 7px;
        font-size: 14px;
        border: 1px solid #d9d9d9;
        background: white;
        color: #424242;
        transition: all 0.25s ease;
    }

    .toolbar .btn-group .btn.btn-info {
        background-color: #007bff !important;
        border-color: #007bff !important;
        color: #fff !important;
    }


    .toolbar .btn:hover {
        transform: translateY(-1px);
    }

    /* ---------- Form Elements ---------- */
    .media-lang-select {
        width: 90%;
        height: auto;
        margin: 0 auto;
        font-size: 13px;
        border-radius: 4px;
    }

    /* ---------- Upload Header ---------- */
    .media-header {
        background: #fff;
        padding: 8px 0;
        border-bottom: 1px solid #eee;
    }

    .progress {
        position: relative;
        height: 10px;
        border-radius: 5px;
        background: #f0f0f0;
        overflow: hidden;
    }

    .bar {
        width: 0;
        height: 100%;
        background: #28a745;
        transition: width .4s ease;
    }

    .percent {
        position: absolute;
        top: -20px;
        right: 0;
        font-size: 12px;
        color: #333;
    }

    /* ---------- Video Preview Styles ---------- */
    .video-preview {
        width: 150px;
        height: 150px;
        background: #000;
        position: relative;
    }

    .video-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        background: rgba(0, 0, 0, 0.3);
        font-size: 30px;
    }

    /* ---------- Modals ---------- */
    .modal-content {
        border-radius: 8px;
        overflow: hidden;
    }

    .modal-header {
        border-bottom: 1px solid #e9ecef;
    }

    .modal-footer {
        border-top: 1px solid #e9ecef;
    }

    .card {
        border: 1px solid #f0f0f0;
        border-radius: 6px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    /* ---------- SVG Color Button ---------- */
    .svg-color-dot {
        display: inline-block;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        border: 1px solid rgba(0, 0, 0, 0.2);
        background: #000;
    }

    .svg-color-btn.active .svg-color-dot {
        box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.35);
    }

    /* ---------- Watermark Grid ---------- */
    .watermark-position-grid {
        display: grid;
        grid-template-columns:repeat(3, 1fr);
        gap: 5px;
    }

    .watermark-position-grid button {
        padding: 5px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background: #f8f9fa;
    }

    .watermark-position-grid button.active {
        background: #007bff;
        color: #fff;
    }

    /* ---------- Responsive Tweaks ---------- */
    @media (max-width: 600px) {
        .thumb-figure {
            width: 130px;
            height: 130px;
        }

        .media-grid {
            grid-gap: 25px;
        }
    }
</style>
{{-- ========================================================= --}}
{{-- PART 3A – Upload, Sort, and Delete Logic --}}
{{-- ========================================================= --}}

<!-- jQuery Form (required for ajaxForm upload progress) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>

<script>
    (function () {

        /* ---------------------- Upload Progress ---------------------- */
        let bar = $('.bar');
        let percent = $('.percent');

        $('#file').change(function () {
            bar.width('0%');
            percent.text('0%');
            $('#media_form').submit();
        });

        $('#media_form').ajaxForm({
            beforeSend: function () {
                $('#file, .fileinput-button, .delete_image').prop('disabled', true).addClass('disabled');
                bar.width('0%');
                percent.text('0%');
            },
            uploadProgress: function (event, position, total, percentComplete) {
                const val = percentComplete + '%';
                bar.width(val);
                percent.text(val);
            },
            success: function () {
                bar.width('100%');
                percent.text('100%');
            },
            complete: function () {
                // Reload full list from server
                $('#media_list').load(window.location.href + ' #media_list > *');
                $('#file, .fileinput-button, .delete_image').prop('disabled', false).removeClass('disabled');
            }

        });

        /* ---------------------- Delete All ---------------------- */
        $(document).on('click', '.delete_image', function (e) {
            e.preventDefault();
            if (!confirm('Вы уверены, что хотите удалить все файлы?')) return;

            const $btn = $(this)
                .html('<span class="spinner-border spinner-border-sm text-primary"></span> Удаление...')
                .prop('disabled', true);

            $.ajax({
                url: '{{ url_a() }}media/delete_all/{{ $model }}/{{ $post_id }}',
                type: 'POST',
                data: {_token: $('meta[name="csrf-token"]').attr('content')}
            }).done(function () {
                $('#media_list').empty();
            }).fail(function () {
                alert('Ошибка при удалении файлов');
            }).always(function () {
                $btn.html('<i class="fa fa-trash-o"></i> {{ a_lang('delete_all') }}').prop('disabled', false);
            });
        });

        /* ---------------------- Set Main Image ---------------------- */
        $(document).on('click', '.ajax_set_main', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            const $btn = $(this);
            if ($btn.hasClass('busy')) return;

            $btn.addClass('busy')
                .html('<span class="spinner-border spinner-border-sm text-primary"></span>')
                .prop('disabled', true);

            const model = $btn.data('model');
            const post_id = $btn.data('post-id');
            const id = $btn.data('id');

            $.ajax({
                url: '{{ url_a() }}media/set_main/' + model + '/' + post_id + '/' + id,
                type: 'POST',
                data: {_token: $('meta[name="csrf-token"]').attr('content')},
                dataType: 'json',
                timeout: 5000 // just to be safe
            })
                .done(function (res) {
                    console.log('Set main response:', res);
                    if (res && res.success) {
                        $('.ajax_set_main').removeClass('btn-info').addClass('btn-outline-info');
                        $('.ajax_set_main[data-id="' + res.main_id + '"]')
                            .removeClass('btn-outline-info').addClass('btn-info');
                    } else {
                        alert('Ошибка: сервер вернул пустой ответ');
                    }
                })
                .fail(function (xhr, status, error) {
                    console.error('Set main failed:', status, error, xhr.responseText);
                    alert('Ошибка при установке главного изображения.');
                })
                .always(function () {
                    $btn.removeClass('busy')
                        .html('<i class="fa fa-arrow-up"></i>')
                        .prop('disabled', false);
                });
        });

        /* ---------------------- Sortable Thumbnails ---------------------- */
        $('#media_list').sortable({
            handle: '.move',
            placeholder: 'thumb-placeholder',
            stop: function () {
                const thumbs = [];
                $('.thumb').each(function (i) {
                    thumbs.push({id: $(this).data('id'), sort_order: i});
                });

                $.ajax({
                    url: '{{ url_a() }}media/sort/{{ $model }}/{{ $post_id }}',
                    type: 'POST',
                    data: JSON.stringify({media_files: thumbs}),
                    contentType: 'application/json',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function () {
                        console.log('Sort order saved');
                    },
                    error: function (xhr) {
                        console.error('Sort failed:', xhr.responseText);
                    }
                });
            }
        });


        /* ---------------------- Language Change ---------------------- */
        $(document).on('change', '.media-lang-select', function () {
            const mediaId = $(this).data('id');
            const model = $(this).data('model');
            const postId = $(this).data('post-id');
            const lang = $(this).val();
            const $select = $(this);

            $select.prop('disabled', true);

            $.ajax({
                url: ADMIN_URL + '/media/update_lang/' + model + '/' + postId + '/' + mediaId,
                type: 'POST',
                data: {lang: lang, _token: $('meta[name="csrf-token"]').attr('content')}
            }).done(function (res) {
                if (res.success) {
                    const badge = $(`li.thumb[data-id="${mediaId}"] .lang-badge`);
                    badge.text(lang.toUpperCase());
                } else alert('Ошибка при обновлении языка');
            }).fail(function () {
                alert('Ошибка при обновлении языка');
            }).always(function () {
                $select.prop('disabled', false);
            });
        });

    })();  // end IIFE
</script>
{{-- ========================================================= --}}
{{-- PART 3B – Image Editor and Cropper Integration --}}
{{-- ========================================================= --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

<script>
    (function () {
        let cropper;
        const $editModal = $('#editMediaModal');
        const $image = $('#editable-image');

        /* ---------------------- Initialize Cropper ---------------------- */
        $editModal.on('shown.bs.modal', function () {
            if (cropper) cropper.destroy();

            cropper = new Cropper($image[0], {
                aspectRatio: NaN,
                viewMode: 1,
                autoCropArea: 1,
                responsive: true,
                rotatable: true,
                zoomable: true,
                ready: () => {
                    const data = cropper.getData();
                    $('#edit_width').val(Math.round(data.width));
                    $('#edit_height').val(Math.round(data.height));
                    updateFileSizeEstimate();
                },
                crop: (event) => {
                    $('#edit_width').val(Math.round(event.detail.width));
                    $('#edit_height').val(Math.round(event.detail.height));
                    updateFileSizeEstimate();
                }
            });
        }).on('hidden.bs.modal', function () {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            $('#editable-image').attr('src', '');
            $('.save-overlay').remove();
        });

        /* ---------------------- Helper: File Size Estimate ---------------------- */
        function updateFileSizeEstimate() {
            if (!cropper) return;
            const w = +$('#edit_width').val() || 0;
            const h = +$('#edit_height').val() || 0;
            const q = +$('#edit_quality').val() || 85;
            if (w && h) {
                const kb = Math.round(w * h * (q / 100) * 0.0003);
                $('#file_size_estimate').text(kb + ' KB');
            }
        }

        /* ---------------------- Rotate / Zoom / Reset ---------------------- */
        $('.rotate-left').click(() => cropper && cropper.rotate(-90));
        $('.rotate-right').click(() => cropper && cropper.rotate(90));
        $('.zoom-in').click(() => cropper && cropper.zoom(0.1));
        $('.zoom-out').click(() => cropper && cropper.zoom(-0.1));
        $('.reset-image').click(() => cropper && cropper.reset());

        /* ---------------------- Aspect Ratio ---------------------- */
        $('#aspect_ratio').change(function () {
            const r = parseFloat($(this).val());
            cropper && cropper.setAspectRatio(r || NaN);
        });

        /* ---------------------- Quality Slider ---------------------- */
        $('#edit_quality').on('input', function () {
            $('#quality_value').text($(this).val() + '%');
            updateFileSizeEstimate();
        });

        /* ---------------------- Width/Height Inputs ---------------------- */
        $('#edit_width,#edit_height').on('change', function () {
            const w = +$('#edit_width').val(), h = +$('#edit_height').val();
            if (cropper && w && h) cropper.setData({width: w, height: h});
        });

        /* ---------------------- Watermark Toggle ---------------------- */
        $('#watermark_toggle').change(function () {
            $('#watermark-position-group').toggle(this.checked);
        });

        $(document).on('click', '.watermark-position-grid button', function () {
            $('.watermark-position-grid button').removeClass('active');
            $(this).addClass('active');
        });

        /* ---------------------- Edit Image Button ---------------------- */
        $(document).on('click', '.edit-media', function (e) {
            e.preventDefault();
            const id = $(this).data('id');
            const url = $(this).data('url');
            const ext = url.split('.').pop().toLowerCase();
            if (/(svg|mp4|mov|avi|mkv|webm)$/i.test(ext))
                return alert('Этот файл нельзя редактировать.');

            $('#edit_media_id').val(id);
            $('#editable-image').attr('src', '{{ url_u($type) }}{{ $sel }}/' + url);
            $('#rotation_angle').val(0);
            $('#zoom_level').val(1);
            $('#edit_quality').val(90);
            $('#quality_value').text('90%');
            $('#watermark_toggle').prop('checked', false);
            $('#watermark-position-group').hide();
            $editModal.modal('show');
        });

        /* ---------------------- Save Image Changes ---------------------- */
        $('#saveMediaChanges').click(function () {
            if (!cropper) return;

            const $btn = $(this);
            const overlay = $('<div class="save-overlay d-flex align-items-center justify-content-center">'
                + '<div class="spinner-border text-primary" style="width:3rem;height:3rem;"></div></div>');
            $('body').append(overlay.hide().fadeIn(150));

            $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm text-primary"></span> Сохранение...');

            const canvas = cropper.getCroppedCanvas({
                width: +$('#edit_width').val() || 800,
                height: +$('#edit_height').val() || 600,
                fillColor: '#fff',
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high'
            });
            const addWatermark = $('#watermark_toggle').is(':checked');
            const quality = (+$('#edit_quality').val() || 90) / 100;

            function sendCanvas(cnv) {
                cnv.toBlob(blob => {
                    const fd = new FormData();
                    fd.append('image', blob, 'edited.webp');
                    fd.append('media_id', $('#edit_media_id').val());
                    fd.append('model', '{{ $model }}');
                    fd.append('post_id', '{{ $post_id }}');
                    fd.append('category', '{{ $sel }}');
                    fd.append('_token', $('meta[name="csrf-token"]').attr('content'));

                    $.ajax({
                        url: '{{ route("admin.media.update_image") }}',
                        type: 'POST',
                        data: fd,
                        processData: false,
                        contentType: false
                    }).done(res => {
                        if (res.success) {
                            const $thumb = $('.thumb[data-id="' + res.media_id + '"]');
                            $thumb.find('img').attr('src', res.new_url);
                            $thumb.find('a.thumbnail').attr('href', res.new_url);
                            $editModal.modal('hide');
                        } else alert(res.message || 'Ошибка при сохранении');
                    }).fail(() => alert('Ошибка сервера')).always(() => {
                        overlay.fadeOut(200, () => overlay.remove());
                        $btn.prop('disabled', false).html('<i class="fa fa-save"></i> Применить изменения');
                    });
                }, 'image/webp', quality);
            }

            if (!addWatermark) return sendCanvas(canvas);

            const ctx = canvas.getContext('2d');
            const wm = new Image();
            wm.src = '/assets/public/images/watermark.png';
            wm.onload = function () {
                const pad = 6, ww = 250, wh = (wm.height / wm.width) * ww;
                const pos = $('.watermark-position-grid button.active').data('position');
                let x = pad, y = pad;
                const cW = canvas.width, cH = canvas.height;
                const map = {
                    'top-center': [(cW - ww) / 2, pad],
                    'top-right': [cW - ww - pad, pad],
                    'middle-left': [pad, (cH - wh) / 2],
                    'center': [(cW - ww) / 2, (cH - wh) / 2],
                    'middle-right': [cW - ww - pad, (cH - wh) / 2],
                    'bottom-left': [pad, cH - wh - pad],
                    'bottom-center': [(cW - ww) / 2, cH - wh - pad],
                    'bottom-right': [cW - ww - pad, cH - wh - pad]
                };
                if (map[pos]) [x, y] = map[pos];
                ctx.save();
                ctx.globalAlpha = 0.9;
                ctx.drawImage(wm, x, y, ww, wh);
                ctx.restore();
                sendCanvas(canvas);
            };
            wm.onerror = () => {
                alert('Не удалось загрузить watermark');
                sendCanvas(canvas);
            };
        });

    })(); // end IIFE
</script>

<style>
    /* Overlay during save */
    .save-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.7);
        z-index: 2050;
        backdrop-filter: blur(2px);
    }

    .save-overlay .spinner-border {
        width: 3rem;
        height: 3rem;
    }
</style>
{{-- ========================================================= --}}
{{-- PART 3C – SVG Color & Video Thumbnail Controls --}}
{{-- ========================================================= --}}
<script>
    (function () {
        const ADMIN_URL = "{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), '/admin/') }}";
        const isHex = v => /^#([0-9a-f]{3}|[0-9a-f]{6}|[0-9a-f]{8})$/i.test(v || '');

        const setSwatch = hex =>
            $('#svgColorSwatch, .svg-color-btn.active .svg-color-dot')
                .css('background', hex || '#000');

        /* ---------- Guess dominant color from SVG text ---------- */
        function guessColor(svg) {
            let m = svg.match(/(?:fill|stroke)\s*:\s*(?!none\b)(?!url\(#)[^;>'"\s)]+/i)
                || svg.match(/\s(?:fill|stroke)="(?!none\b)(?!url\(#)([^"]+)"/i);
            return m && m[1] ? m[1].trim() : '#000';
        }

        /* ---------- Open SVG color modal ---------- */
        $(document).on('click', '.svg-color-btn', function (e) {
            e.preventDefault();
            $('.svg-color-btn').removeClass('active');
            $(this).addClass('active');

            const mId = $(this).data('id'), file = $(this).data('url'),
                model = $(this).data('model'), pid = $(this).data('post-id'),
                cat = $(this).data('category');

            $('#svg_media_id').val(mId);
            $('#svg_model').val(model);
            $('#svg_post_id').val(pid);
            $('#svg_category').val(cat);
            $('#svg_url').val(file);

            const u = '{{ url_u($type) }}' + cat + '/' + file + '?t=' + Date.now();
            $.get(u).done(txt => {
                const c = guessColor(txt);
                const hex = isHex(c) ? c : '#000000';
                $('#svgHexInput').val(hex);
                $('#svgColorInput').val(hex);
                setSwatch(hex);
            }).always(() => $('#svgColorModal').modal('show'));
        });

        /* ---------- Sync inputs ---------- */
        $(document).on('input', '#svgColorInput', function () {
            const v = $(this).val();
            $('#svgHexInput').val(v);
            setSwatch(v);
        });
        $(document).on('input', '#svgHexInput', function () {
            const v = $(this).val().trim();
            if (isHex(v)) {
                $('#svgColorInput').val(v);
                setSwatch(v);
            }
        });

        /* ---------- Apply color ---------- */
        $(document).on('click', '#applySvgColorBtn', function () {
            const color = ($('#svgHexInput').val() || '').trim();
            if (!isHex(color)) return alert('Некорректный HEX цвет');

            const payload = {
                _token: $('meta[name="csrf-token"]').attr('content'),
                model: $('#svg_model').val(),
                post_id: $('#svg_post_id').val(),
                media_id: $('#svg_media_id').val(),
                category: $('#svg_category').val(),
                color: color
            };
            const $btn = $(this).prop('disabled', true)
                .html('<span class="spinner-border spinner-border-sm text-primary"></span> Применение…');

            $.post(ADMIN_URL + '/media/svg-color', payload)
                .done(res => {
                    if (res.success) {
                        const $t = $('.thumb[data-id="' + res.media_id + '"]');
                        $t.find('img').attr('src', res.new_url);
                        $t.find('a.thumbnail').attr('href', res.new_url);
                        $('.svg-color-btn.active .svg-color-dot').css('background', res.color);
                        $('#svgColorModal').modal('hide');
                    } else alert(res.message || 'Ошибка при применении цвета');
                })
                .fail(x => alert('Ошибка сервера: ' + x.statusText))
                .always(() => {
                    $btn.prop('disabled', false)
                        .html('<i class="fa fa-check"></i> Применить');
                    $('.svg-color-btn').removeClass('active');
                });
        });

        /* ========================================================= */
        /* VIDEO THUMBNAIL UPLOAD / PREVIEW / DELETE                 */
        /* ========================================================= */
        $(document).on('click', '.btn-thumb-upload', function (e) {
            e.preventDefault();
            const $b = $(this);
            $('#thumb_video_id').val($b.data('id'));
            $('#thumb_model').val($b.data('model'));
            $('#thumb_post_id').val($b.data('post-id'));
            $('#thumb_category').val($b.data('category'));
            $('#thumb_file').val('');
            $('#thumb_current_wrap,#thumb_none').hide();

            const fd = new FormData();
            fd.append('model', $('#thumb_model').val());
            fd.append('post_id', $('#thumb_post_id').val());
            fd.append('video_media_id', $('#thumb_video_id').val());
            fd.append('category', $('#thumb_category').val());
            fd.append('_token', $('meta[name="csrf-token"]').attr('content'));

            $.ajax({
                url: '{{ route("admin.media.get_video_thumbnail") }}',
                type: 'POST', data: fd, processData: false, contentType: false
            }).done(res => {
                if (res.success && res.thumb && res.thumb.url) {
                    $('#thumb_current_img').attr('src', res.thumb.url);
                    $('#thumb_current_wrap').show();
                } else $('#thumb_none').show();
            }).always(() => $('#videoThumbModal').modal('show'));
        });

        /* ---------- Upload new thumbnail ---------- */
        $('#videoThumbForm').on('submit', function (e) {
            e.preventDefault();
            const fd = new FormData(this);
            const $b = $('#thumbUploadBtn')
                .prop('disabled', true)
                .html('<span class="spinner-border spinner-border-sm text-primary"></span> Загрузка…');
            $.ajax({
                url: '{{ route("admin.media.video_thumbnail") }}',
                type: 'POST', data: fd, processData: false, contentType: false
            }).done(res => {
                if (res.success) {
                    const $li = $('.thumb[data-id="' + res.video_id + '"]');
                    $li.find('video').attr('poster', res.poster_url);
                    $('#videoThumbModal').modal('hide');
                } else alert(res.message || 'Не удалось загрузить превью');
            }).fail(x => alert('Ошибка сервера: ' + x.statusText))
                .always(() => $b.prop('disabled', false)
                    .html('<i class="fa fa-upload"></i> Загрузить'));
        });

    })(); // end IIFE
</script>

