<?php

namespace App\Http\Controllers\helpers;

trait Keyboards
{
    public function keyboardLanguages()
    {
        $inline_button1    = array('text'=> "๐บ๐ฟ O'zbekcha ๐บ๐ฟ", 'callback_data'=>'language_uzbek');
        $inline_button2    = array('text'=> "๐ท๐บ ะ ัััะบะธะน ๐ท๐บ",   'callback_data'=>'language_russian');
        $inline_button3    = array('text'=> "๐ฌ๐ง English ๐ฌ๐ง",   'callback_data'=>'language_english');
        $inline_keyboard01 = [[$inline_button1],[$inline_button2],[$inline_button3]];
        $keyboard01 = array("inline_keyboard" => $inline_keyboard01);
        return json_encode($keyboard01);
    }


    public function keyboardPolicyContact()
    {
        return json_encode([
            'resize_keyboard'=>true,
            'keyboard'=>[
                [['text'=> trans('messages.Send my number'),'request_contact'=>true],],
                [['text'=> trans('messages.Licence')],],
            ]
        ]);
    }

    public function keyboardContact()
    {
        return json_encode([
            'resize_keyboard'=>true,
            'keyboard'=>[
                [['text'=> trans('messages.Send my number'),'request_contact'=>true],],
            ]
        ]);
    }


    public function keyboardNewMessage()
    {
        return json_encode([
            'resize_keyboard'=>true,
            'keyboard'=>[
                [['text' => trans('messages.Send new message')],],
            ]
        ]);
    }

    public function keyboardRemoveButtons()
    {
        return json_encode([
            'remove_keyboard'=>true,
        ]);
    }


}
