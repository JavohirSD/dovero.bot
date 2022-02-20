<?php

namespace App\Http\Controllers\helpers;

trait Keyboards
{
    public function keyboardLanguages()
    {
        $inline_button1    = array('text'=> "🇬🇧 English 🇬🇧",   'callback_data'=>'lang_english');
        $inline_button2    = array('text'=> "🇷🇺 Русский 🇷🇺",   'callback_data'=>'lang_russian');
        $inline_button3    = array('text'=> "🇺🇿 O'zbekcha 🇺🇿", 'callback_data'=>'lang_uzbek');
        $inline_keyboard01 = [[$inline_button1],[$inline_button2],[$inline_button3]];
        $keyboard01 = array("inline_keyboard" => $inline_keyboard01);
        return json_encode($keyboard01);
    }


    public function keyboardPolicyContact()
    {
        return json_encode([
            'resize_keyboard'=>true,
            'keyboard'=>[
                [['text'=>"☎️ Send my number ☎️",'request_contact'=>true],],
                [['text'=>"💎 Lisence 💎"],],
            ]
        ]);
    }


    public function keyboardNewMessage()
    {
        return json_encode([
            'resize_keyboard'=>true,
            'keyboard'=>[
                [['text'=>"♻️ Send new message ♻️"],],
            ]
        ]);
    }


}
