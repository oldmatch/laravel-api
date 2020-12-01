<?php

function curl_request($url, $post = 'get', $data = [], $header = [], $time_limit = 60)
{
    //初始化curl
    $ch = curl_init();
    //设置基本参数
    //设置返回值不直接输出
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);

    //设置超时时长
    curl_setopt($ch, CURLOPT_TIMEOUT, $time_limit);

    if ($post == 'post') {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }

    if (!empty($header)) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    }

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    $content = curl_exec($ch);
    curl_close($ch);
    return $content;
}
