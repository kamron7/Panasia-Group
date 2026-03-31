@props(['name' => '', 'value' => '', 'post' => [], 'class' => ''])
<div class="form-group">
    <div class="controls">
        <label class="control-label" for="focusedInput">{{$value}}</label>
        <input id="{{$name}}" name="{{$name}}" class="form-control span3 {{ $class }} " type="text"
               value="{{old($name) ?? ($post->$name ?? '')}}">
    </div>
</div>
