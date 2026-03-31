<?php

$posts = DB::connection('mysql')->table('site')->limit(1000)->first();
$model = new Site();

$model->my_save(['title' => [$posts->meta_title], 'email' => $posts->email]);