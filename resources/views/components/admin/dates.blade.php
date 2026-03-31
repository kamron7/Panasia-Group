@props(['name' => '', 'value' => '', 'post' => [], 'class' => 'w-25'])

@php
    use Carbon\Carbon;

    $set = null;

    if (old($name)) {
        $set = old($name);
    } elseif (is_array($post) && !empty($post[$name])) {
        $set = Carbon::parse($post[$name])->format('d-m-Y H:i');
    } elseif (is_object($post) && !empty($post->$name)) {
        $set = Carbon::parse($post->$name)->format('d-m-Y H:i');
    } else {
        $set = Carbon::now()->format('d-m-Y H:i');
    }
@endphp


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="form-group">
    <div class="controls">
        <label class="control-label" for="focusedInput">{{ $value }}</label>
        <input id="{{ $name }}" name="{{ $name }}"
               class="form-control span3 {{ $class }}"
               type="text"
               value="{{ old($name) ?? $set }}">
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function () {
        flatpickr("#{{ $name }}", {
            enableTime: true,
            time_24hr: true,
            dateFormat: "d-m-Y H:i",
        });
    });
</script>
