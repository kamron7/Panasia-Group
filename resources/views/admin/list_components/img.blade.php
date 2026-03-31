@php
    $media = getImgMainAllLang($post, true); // Get full file object
    $mediaUrl = $media ? url_u() . "$sel/" . $media->url : null;
    $ext = $media ? pathinfo($media->url, PATHINFO_EXTENSION) : null;
@endphp

<td style="text-align: center; position: relative;">
    @if ($media)
        <div style="position: relative; display: inline-block;">
            @if (in_array($ext, ['jpg', 'JPG', 'jpeg', 'png', 'webp', 'gif', 'svg']))
                <a href="{{ $mediaUrl }}" class="fancybox" data-fancybox="gallery">
                    <img src="{{ $mediaUrl }}"
                         style="max-width:50px; max-height:50px; width:auto; height:auto; object-fit:contain; background:#f5f5f5;" />

                </a>

            @elseif (in_array($ext, ['mp4', 'webm', 'mov']))
                <a href="{{ $mediaUrl }}" data-fancybox data-type="video">
                    <video width="50" height="50" muted loop
                           style="object-fit:contain; background:#000;">
                        <source src="{{ $mediaUrl }}" type="video/{{ $ext === 'mov' ? 'quicktime' : $ext }}">
                    </video>
                </a>

            @else
                <a href="{{ $mediaUrl }}" class="fancybox" data-fancybox="gallery" target="_blank">
                    {{ basename($media->url) }}
                </a>
            @endif

            @if (!empty($media->lang))
                <div style="position: absolute; top: 0; right: 0; background-color: rgba(0,0,0,0.6); color: #fff; font-size: 7px; padding: 2px 4px; border-bottom-left-radius: 4px;">
                    {{ strtoupper($media->lang) }}
                </div>
            @endif
        </div>
    @else
        Нет фото
    @endif
</td>
