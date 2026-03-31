<div class="form-group">
    <label class="control-label" for="focusedInput">Видео</label>
    <div class="controls w-25">
        <select id="type" name="type" class="form-control input-xlarge focused" onchange="showDiv(this)">
            <option value="0">Выберите тип</option>
            <option value="1" {{ ($post->type ?? -1) == 1 ? 'selected' : '' }} >Youtube</option>
            <option value="2" {{ ($post->type ?? -1) == 2 ? 'selected' : '' }} >Mover</option>
            <option value="3" {{ ($post->type ?? -1) == 3 ? 'selected' : '' }} >Загрузка на сервер
            </option>
        </select>
    </div>
    <div class="row mt-2">
        <div class="col-4">
            <h5>ru</h5>
            <input id="video" name="code[ru]" class="span3 form-control "
                   placeholder="Вставить код например: 0AtTZPJ5HOL" type="text"
                   value="<?= old("code['ru']", $post->code->ru ?? '') ?>">
        </div>
        <div class="col-4">
            <h5>uz</h5>
            <input id="video_link_uz" name="code[uz]" class="span3 form-control "
                   placeholder="Вставить код например: 0AtTZPJ5HOL" type="text"
                   value="<?= old("code[uz]", $post->code->uz ?? '') ?>">
        </div>
        <div class="col-4">
            <h5>en</h5>
            <input id="video_link_en" name="code[en]" class="span3 form-control "
                   placeholder="Вставить код например: 0AtTZPJ5HOL" type="text"
                   value="<?= old("code[en]", $post->code->en ?? '') ?>">
        </div>
    </div>

</div>
<div class="form-group"
     id="server" style="display: {{ ($post->type ?? false) == 3 ? 'block' : 'none' }};">
    <div class="controls">
        <a href="#myModal" role="button" class="btn btn-info" data-toggle="modal"><i class="icon-file icon-white"></i>
            Выберите видео файл</a>
    </div>
</div>

<script>
    function showDiv(elem) {
        if (elem.value == 3) {
            document.getElementById('server').style.display = "block";
        } else {
            document.getElementById('server').style.display = "none";
        }
    }
</script>
