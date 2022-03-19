<?php

namespace App\Http\Controllers\helpers;

trait TelegramCurl
{
    public $ADMIN_ID = "929987374";
    public $BOT_TOKEN = "1966900043:AAHsP42pky6Rwv6FMmMAdS17IvAoxDU0f8M";
    public $BOT_USERNAME = "@DoveRobot";


    function bot($method, $datas = [])
    {
        $url = "https://api.telegram.org/bot" . $this->BOT_TOKEN . "/" . $method;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
        $res = curl_exec($ch);
        if (curl_error($ch)) {
            file_put_contents("BOT_ERROR.txt", print_r(curl_error($ch), true));
        }
        return json_decode($res);
    }



}
