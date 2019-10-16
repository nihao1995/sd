<?php

/* 返回代码 */
function _return_code($code, $status, $message)
{
    $return = array(
        'code' => $code,
        'status' => $status,
        'message' => $message
    );
    exit(json_encode($return, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}

/* 返回数据 */
function _return_data($code, $status, $message, $data)
{
    $return = array(
        'code' => $code,
        'status' => $status,
        'message' => $message,
        'data' => $data
    );
    exit(json_encode($return, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}