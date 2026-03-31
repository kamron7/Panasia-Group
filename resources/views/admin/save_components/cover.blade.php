@if ($post->img ?? false)
    <div class="form-group">
        <label class="control-label" for="focusedInput">Текущая обложка</label>
        <div class="controls">
            <img style="width: 300px;" src="{{ url_u() . "$sel/$post->img" }}"/>
        </div>
    </div>
@endif

<div class="form-group">
    <label class="control-label" for="focusedInput">Обложка</label>
    <div class="controls">
        <input type="file" name="img">
    </div>
</div>
