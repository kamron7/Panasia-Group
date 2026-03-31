<div class="form-group">
    <label class="control-label" for="focusedInput">Meta {{ a_lang('keywords') }} (keywords)</label>
    <div class="controls">
        <textarea name="keywords" class="form-control">{{ old('keywords', $post->keywords ?? '') }}</textarea>
    </div>
</div>

<div class="form-group">
    <label class="control-label" for="focusedInput">Meta {{ a_lang('description') }} (description)</label>
    <div class="controls">
        <textarea name="description" class="form-control">{{ old('description', $post->description ?? '') }}</textarea>
    </div>
</div>
