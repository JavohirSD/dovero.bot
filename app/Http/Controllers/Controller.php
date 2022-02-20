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

            $this->text = $update['message']['text'];
            $this->chat_id = $update['message']['from']['id'];
            $this->message_id = $update['message']['message_id'];

            $this->username = $update['message']['from']['username'];
            $this->first_name = $update['message']['from']['first_name'];
            $this->last_name = $update['message']['from']['last_name'];

            $this->cb_query = $update['callback_query'];
            $this->cb_data = $update['callback_query']['data'];
            $this->cb_qid = $update['callback_query']['id'];
            $this->cb_from_id = $update['callback_query']['from']['id'];
            $this->cb_mc_id = $update['callback_query']['message']['chat']['id'];
            $this->cb_mm_id = $update['callback_query']['message']['message_id'];
            $this->cb_im_id = $update['callback_query']['inline_message_id'];
            $this->cb_uname = $update['callback_query']['from']['username'];
            $this->contact = $update['message']['contact']['phone_number'];
            $this->cb_firstname = $update['callback_query']['from']['first_name'];
            $this->cb_lastname = $update['callback_query']['from']['last_name'];
        }
        return parent::callAction($method, $parameters);
    }


}
