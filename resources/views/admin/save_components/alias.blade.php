@if($type == 'create')
    <div class="form-group w-25">
        <label class="control-label" for="focusedInput">{{ a_lang('alias') }}</label>
        <div class="controls">
            <input id="alias" name="alias" class="validate[required,ajax[check_alias]] span3 form-control"
                   type="text"
                   value="{{ old('alias') }}">
        </div>
    </div>
@endif
