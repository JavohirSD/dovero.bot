<?php

namespace App\Http\Controllers;

use App\Models\Robots;


class StatusController extends Controller
{
    public function check()
    {
        $robots = Robots::where('status', 1)->orWhere('status',2)->get();
        foreach ($robots as $robot){
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://doverobot.mylib.uz/users/user0'.$robot->id.'/status.php',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ]);

            $response = json_decode(curl_exec($curl));
            curl_close($curl);

            if($response->status){
                $robot->status = Robots::ACTIVE_ROBOT;
            }

            if($response->status == false && $robot->status == 1){
                $robot->status = Robots::FAILED_ROBOT;
            }

            if($response->status == false && $robot->status == 2){
                $robot->status = Robots::SPAMMED_ROBOT;
            }
        }
    }


}
