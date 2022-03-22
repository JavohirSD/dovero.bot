<?php

namespace App\Http\Controllers;

use App\Models\Robots;

class RobotsController extends Controller
{
    public static function sendMessage($receiver, $message, $sender, $field)
    {
        $robot = Robots::where('status', 1)->first()->id;

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://doverobot.mylib.uz/users/user0'.$robot.'/index.php',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => [
                'message' => $message,
                'owner'   => $sender,
                $field    => $receiver
            ],
        ]);

        $response = json_decode(curl_exec($curl));
        curl_close($curl);

        return [
               'response' => $response,
               'robot_id' => $robot
            ];
    }


}
