@php
    $options = [
        'users' => 'User',
        'admin' => 'Admin',
];
        $includes = array('status', 'btns');
@endphp

<x-admin.save :type="$type">

    <x-admin.input :post="$post ?? null" name="username" value="Foydalanuvchi nomi"/>
    <x-admin.input :post="$post ?? null" name="email" value="Elektron manzil"/>

    <x-admin.select :post="$post ?? null" name="role" value="Foydalanuvchi turi" :options="$options" class="w-25"/>

    <div class="form-group">
        <label class="control-label" for="focusedInput">Parol</label>
        <p><a href="#!" class="generate_password">Parol yaratish</a>&nbsp; <b id="generate_pass"></b></p>
        <div class="controls">
            <input name="password" class="form-control input-xlarge focused" type="password" id="password_value"
                   value="{{ old('password', 0) }}" autocomplete="new-password">
        </div>
    </div>
    @include("admin/save_components/includes")
</x-admin.save>

<script>
    jQuery('.generate_password').click(function (e) {
        e.preventDefault();
        jQuery.ajax({
            type: 'post',
            data: {'_token': "{{csrf_token()}}"},
            url: '{{ url_a() . 'users/generate_password' }}',
            success: function (data) {
                jQuery('#generate_pass').html(data.pass);
                jQuery('#password_value').val(data.pass);
            },
            error: function (data) {
            }
        });
        return false;
    });

</script>
