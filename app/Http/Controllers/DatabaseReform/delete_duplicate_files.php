<?php

use App\Models\Main;

$pages = Main::gets([['files', '!=', null], 'group' => 'interactive']);
$model = new Main();
foreach ($pages as $item) {
    $files = $item->files;
    $newArr = [];
    $foundLastZeroId = false;

    foreach ($files as $key => $value) {
        if ($value->id == 0) {
            // Если найден элемент с id = 0, обновляем массив $newArr
            $newArr = [];
            $foundLastZeroId = true;
        }

        if ($foundLastZeroId) {
            // Если уже найден последний элемент с id = 0, добавляем все последующие элементы
            $newArr[] = $value;
        }
    }
    $model->my_save(['files' => $newArr], $item->id);
}

