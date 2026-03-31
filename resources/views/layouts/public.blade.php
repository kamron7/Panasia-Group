@php
    $sel = $sel ?? session('sel', '');
@endphp

<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#" class="boxed {{ app()->getLocale() }}" lang="{{ app()->getLocale() }}" {{ app()->getLocale() === 'ar' ? 'dir=rtl' : '' }}>
@include('includes.page_header')

<body class="{{ $sel !== 'home' ? 'border-menu' : 'border-menu-home' }}">

    <style>
    #pt {
        position: fixed; inset: 0;
        z-index: 99998; pointer-events: none;
        overflow: hidden;
    }
    .pt-s {
        position: absolute;
        top: -5%; height: 110%;
        backface-visibility: hidden;
    }
    .pt-s:nth-child(1) { left: -22%; width: 46%; background: #2277BB; }
        .pt-s:nth-child(2) { left:  16%; width: 36%; background: #1563A8; }
        .pt-s:nth-child(3) { left:  44%; width: 36%; background: #FF7C10; }
        .pt-s:nth-child(4) { left:  72%; width: 48%; background: #D96500; }

    @media (max-width: 768px) {
        #pt { display: none; }
    }
</style>

<div id="pt" aria-hidden="true">
    <div class="pt-s"></div>
    <div class="pt-s"></div>
    <div class="pt-s"></div>
    <div class="pt-s"></div>
</div>

<script>
    function isMobile() {
        return window.innerWidth <= 768 || /Mobi|Android|iPhone|iPad|iPod/i.test(navigator.userAgent);
    }
</script>

@if($sel !== 'home')
<script>
    (function(){
        if (isMobile()) return;
        var ss = document.querySelectorAll('.pt-s');
        var W  = window.innerWidth;
        gsap.set(ss, { skewX: -10, x: 0 });
        gsap.to(ss, { x: -W * 1.8, duration: 0.55, ease: 'expo.inOut', stagger: 0.08, delay: 0.06 });
    })();
</script>
@else
<script>
    (function(){
        if (isMobile()) return;
        gsap.set('.pt-s', { skewX: -10, x: -window.innerWidth * 1.8 });
    })();
</script>
@endif
    <div class="wrapper {{ $sel === 'home' ? '' : 'pages' }}">
        @include('includes.header')

        {{ $slot }}

        @include('includes.footer')
    </div>

    @include('includes.footer_scripts')

</body>


</html>
