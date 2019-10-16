<?php

/* 文件上传 */
function upload($file, $path)
{
    $filename = getPath($path) . getName($file, 5);
    if (is_uploaded_file($file['tmp_name'])) {
        move_uploaded_file($file['tmp_name'], $filename);
        return $filename;
    }
}

/* 文件路径 */
function getPath($path)
{
    if (! is_dir($path)) {
        mkdir($path, 0777, true);
    }
    return $path . '/';
}

/* 文件名称 */
function getName($file, $count)
{
    $name = date("Ymdhis");
    for ($i = 0; $i < $count; $i ++) {
        $name .= chr(rand(65, 90));
    }
    return $name . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
}