<?php

namespace App\Http\Controllers;

use App\Helper\ExtendHelper;
use EasyWeChat\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WeChatController extends Controller
{
    public $app = null;

    public function __construct()
    {
        $config = [
            'app_id' => config('wechat.appid'),
            'secret' => config('wechat.secret'),
            'token' => config('wechat.token'),

            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',

            //...
        ];

        $this->app = Factory::officialAccount($config);
    }

    public function index(Request $request)
    {
        $param = $request->all();
        // 验证消息
        $message = $this->app->server->forceValidate()->getMessage();
        Log::info('wechat message：' . json_encode($message, JSON_UNESCAPED_UNICODE));

        $this->app->server->push(function ($message) {
            switch ($message['MsgType']) {
                case 'event':
                    if ($message['Event'] == 'CLICK') {
                        return $this->click($message['EventKey']);
                    }
                    return '收到事件消息';
                    break;
                case 'text':
                    return '收到文字消息';
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                case 'file':
                    return '收到文件消息';
                    break;
                // ... 其它消息
                default:
                    return '收到其它消息';
            }

        });

        // 在 laravel 中：
        $response = $this->app->server->serve();
        // $response 为 `Symfony\Component\HttpFoundation\Response` 实例
        // 而 laravel 中直接返回即可：
        return $response;
    }

    private function click($EventKey)
    {
        // 点击事件
        switch ($EventKey) {
            case 'weather_shenzhen':
            case 'weather_dongguan':
            case 'weather_zhanjiang':
            case 'weather_zhuhai':
                $arr = [
                    'weather_shenzhen' => '深圳',
                    'weather_dongguan' => '东莞',
                    'weather_zhanjiang' => '湛江',
                    'weather_zhuhai' => '珠海',
                ];

                $city = $arr[$EventKey] ?? '深圳';

                return ExtendHelper::weather($city);
            default:
                return ExtendHelper::weather('深圳');
        }
    }

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'WeChat';

    public function menu()
    {
        $buttons = [
//            [
//                "type" => "click",
//                "name" => "今日歌曲",
//                "key"  => "V1001_TODAY_MUSIC"
//            ],
            [
                "name"       => "今日天气",
                "sub_button" => [
                    [
                        "type" => "click",
                        "name" => "深圳",
                        "key" => "weather_shenzhen"
                    ],
                    [
                        "type" => "click",
                        "name" => "东莞",
                        "key" => "weather_dongguan"
                    ],
                    [
                        "type" => "click",
                        "name" => "湛江",
                        "key" => "weather_zhanjiang"
                    ],
                    [
                        "type" => "click",
                        "name" => "珠海",
                        "key" => "weather_zhuhai"
                    ],
                ],
            ],
        ];
        $this->app->menu->create($buttons);
        dump($this->app->menu->current());die;
    }
}
