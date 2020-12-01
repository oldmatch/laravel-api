<?php

namespace App\Helper;

class ExtendHelper {

    /**
     * @param string $city
     * 获取今日天气
     * @return string
     * author lkz <oldmatch24@gmail.com>
     */
    public static function weather($city = '深圳')
    {
        $param = [
            'key' => '989f8324a98c9a0ffcc0bf4fc7045333',
            'city' => $city
        ];
        $data = curl_request('http://apis.juhe.cn/simpleWeather/query?' . http_build_query($param));
        if (!empty($data)) {
            $data = json_decode($data, true);
            $weather = current($data['result']['future'] ?? []);
            if (!empty($weather) && !empty($weather['weather'])) {
                $weather = $data['result']['city'] . '： ' . $weather['weather'] . ' ' . $weather['temperature'] . ' ' . $weather['direct'];
            }
        }

        return $weather ?? '查无数据';
    }
}
