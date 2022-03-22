<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $text, $chat_id, $message_id;
    public $username, $first_name, $last_name;
    public $cb_query,$cb_data,$cb_qid,$cb_from_id,$cb_mc_id;
    public $cb_mm_id,$cb_im_id,$cb_firstname,$cb_lastname,$cb_uname,$contact;

    public function callAction($method, $parameters)
    {
        $data = file_get_contents("php://input");
        if($data) {
            $update = json_decode($data, true);
            file_put_contents('filename.txt', print_r($update, true) . "-----------------", FILE_APPEND);

            $this->text = $update['message']['text'] ?? null;
            $this->chat_id = $update['message']['from']['id'] ?? null;
            $this->message_id = $update['message']['message_id'] ?? null;

            $this->username = $update['message']['from']['username'] ?? null;
            $this->first_name = $update['message']['from']['first_name'] ?? null;
            $this->last_name = $update['message']['from']['last_name'] ?? null;
            $this->contact = $update['message']['contact']['phone_number'] ?? null;

            if(isset($update['callback_query'])){
                $this->cb_query = $update['callback_query'] ?? null;
                $this->chat_id = $update['callback_query']['message']['chat']['id'] ?? null;
                $this->message_id = $update['callback_query']['message']['message_id'] ?? null;
                $this->username = $update['callback_query']['from']['username'] ?? null;
                $this->first_name = $update['callback_query']['from']['first_name'] ?? null;
                $this->last_name = $update['callback_query']['from']['last_name'] ?? null;
                $this->cb_data = $update['callback_query']['data'] ?? null;
                $this->cb_qid = $update['callback_query']['id'] ?? null;
                $this->cb_from_id = $update['callback_query']['from']['id'] ?? null;
                $this->cb_im_id = $update['callback_query']['inline_message_id'] ?? null;
            }
        }


        return parent::callAction($method, $parameters);
    }


}
