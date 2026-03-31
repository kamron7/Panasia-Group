<x-admin.save type="edit">
    <div class="form-group">
        <div class="control-label">
            <?= a_lang('name'); ?>
        </div>
        <div class="controls">
            <input disabled type="text" class="form-control" value="<?= $post->fio ?>" name="pism" size="60"/>
        </div>
    </div>
    <div class="form-group">
        <div class="control-label">
            <?= a_lang('Event_location'); ?>
        </div>
        <div class="controls">
            <input disabled type="text" class="form-control" value="<?= $post->address ?>" name="location"
                   size="60"/>
        </div>
    </div>
       <div class="form-group">
        <div class="control-label">
            <?= a_lang('email'); ?>
        </div>
        <div class="controls">
            <input disabled type="text" class="form-control" value="<?= $post->email ?>" name="location"
                   size="60"/>
        </div>
    </div>
    
{{--    <div class="form-group">--}}
{{--        <div class="control-label">--}}
{{--            <?= a_lang('birth'); ?>--}}
{{--        </div>--}}
{{--        <div class="controls">--}}
{{--            <input disabled type="text" class="form-control" value="<?= to_date('d-m-Y', $post->birthday) ?>"--}}
{{--                   name="birthday" size="60"/>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="form-group">
        <div class="control-label">
            Телефон
        </div>
        <div class="controls">
            <input disabled type="text" class="form-control" value="<?= $post->phone ?>" name="ptelefon"
                   size="60"/>
        </div>
    </div>
{{--    <div class="form-group">--}}
{{--        <div class="control-label">--}}
{{--            <?= a_lang('adres'); ?>--}}
{{--        </div>--}}
{{--        <div class="controls">--}}
{{--            <textarea disabled class="form-control"><?= $post->address ?></textarea>--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="form-group">
        <div class="control-label">
            <?= a_lang('message'); ?>
        </div>
        <div class="controls">
            <textarea disabled style="min-height: 400px" class="form-control"><?= $post->message ?></textarea>
        </div>
    </div>

{{--    <div class="form-group">--}}
{{--        <div class="controls">--}}
{{--            <div class="form-group">--}}
{{--                <label class="control-label">{{ a_lang('file') }} :</label>--}}
{{--                <a style="font-weight: 500; text-decoration: underline" href="{{ url_u() . str_replace('uploads/', '', $post->file) }}">--}}
{{--                    {{ basename($post->file) }}--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group w-25">--}}
{{--        <label class="control-label"><?= a_lang('status') ?></label>--}}
{{--        <div class="controls">--}}
{{--            <?php $status_id = 'W';--}}
{{--            if (isset($post->status))--}}
{{--                $status_id = $post->status;--}}
{{--            ?>--}}
{{--            <select name="status" class="form-control ">--}}
{{--                <option value="0" <?= ($status_id == '0') ? 'selected' : ''; ?>><?= a_lang('a') ?></option>--}}
{{--                <option value="1" <?= ($status_id == '1') ? 'selected' : ''; ?>><?= a_lang('s') ?></option>--}}
{{--                <option value="3" <?= ($status_id == '3') ? 'selected' : ''; ?>><?= a_lang('rejected') ?></option>--}}
{{--            </select>--}}
{{--        </div>--}}
{{--    </div>--}}
</x-admin.save>
