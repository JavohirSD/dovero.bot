<?php

namespace App\Http\Controllers;

use App\Http\Controllers\helpers\Keyboards;
use App\Http\Controllers\helpers\TelegramCurl;
use App\Models\Messages;
use App\Models\Profiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;

class WebhookController extends Controller
{
    use TelegramCurl;
    use Keyboards;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $user;

    public function index()
    {
        $this->user = Profiles::where('tg_id', $this->chat_id)->first();
        App::setLocale($this->user ? $this->user->language : 'uz');

        ////////////////////////////////////////////
        ///                                      ///
        ///    1. /start command received        ///
        ///                                      ///
        /// ////////////////////////////////////////
        if ($this->text == "/start") {
            if ($this->user === null) {
                $this->user = new Profiles();
                $this->user->tg_id = $this->chat_id;
                $this->user->username = $this->username;
                $this->user->first_name = $this->first_name;
                $this->user->last_name = $this->last_name;
                $this->user->language = 'uz';
                $this->user->state = 'JUST_CREATED';
                $this->user->status = 1;
                $this->user->save();
            }

            $this->bot('sendMessage', [
                'text' => "Welcome to DoveRobot. Please choose your language.\n\n
                           Добро пожаловать в DoveRobot. Пожалуйста, выберите свой язык.\n\n
                           DoveRobot ga xush kelibsiz.Kerakli tilni tanlang:",
                'chat_id' => $this->chat_id,
                'reply_markup' => $this->keyboardLanguages(),
            ]);
        }



        ////////////////////////////////////////////
        ///                                      ///
        ///    2. Language buttons clicked       ///
        ///                                      ///
        /// ////////////////////////////////////////
        if (isset($this->cb_query) && strpos($this->cb_data, "language") !== FALSE) {
            $new_language = substr($this->cb_data, 9, 2);
            $this->user->language = $new_language;
            $this->user->state = 'LANGUAGE_SET';
            App::setLocale($new_language);

            if ($this->user->save()) {
                $this->bot('sendMessage', [
                    'text' => trans('messages.language') . " " . trans('messages.language successfully set'),
                    'chat_id' => $this->chat_id,
                    'reply_markup' => $this->keyboardPolicyContact()
                ]);
            }
        }


        ////////////////////////////////////////////
        ///                                      ///
        ///    3. Licence button clicked         ///
        ///                                      ///
        /// ////////////////////////////////////////
        if ($this->text == trans('messages.Licence')) {
            $this->user->state = 'LICENCE_ACCEPTED';
            if ($this->user->save()) {
                $this->bot('sendMessage', [
                    'text' => trans('messages.Privacy policy text'),
                    'chat_id' => $this->chat_id,
                    'reply_markup' => $this->keyboardContact()
                ]);
            }
        }


        ////////////////////////////////////////////
        ///                                      ///
        ///    4. User contact number shared     ///
        ///                                      ///
        /// ////////////////////////////////////////
        if(isset($contact)){
            $this->user->phone_number = str_replace("+","", $contact);
            $this->user->state = 'CONTACT_SHARED';

            if($this->user->save()){
               $this->bot('sendMessage', [
                   'text' => trans('messages.Phone number or username request with examples'),
                   'chat_id' => $this->chat_id
               ]);
           }
            exit;
        }


        ////////////////////////////////////////////////
        ///                                          ///
        ///    5. Receiver username/number received  ///
        ///                                          ///
        /// ////////////////////////////////////////////
        if($this->user->state == "CONTACT_SHARED" || $this->user->state == "WRITE_MESSAGE"){
            if( (preg_match("/^[0-9]+$/", $this->text) === 1 && strlen($this->text) === 12) ||
                (strpos($this->text,"@") === 0 && strlen($this->text) > 4)
            ) {
                $message = new Messages();
                $message->profile_id = $this->user->id;
                $message->receiver = $this->text;
                $message->status = 0;
                $message->save();

                $this->user->state = 'RECEIVER_ACCEPTED';

                if ($this->user->save()) {
                    $this->bot('sendMessage', [
                        'text' => trans('messages.Now send me the message text which I have to deliver'),
                        'chat_id' => $this->chat_id
                    ]);
                }
            } exit;
        }

        ////////////////////////////////////////////////
        ///                                          ///
        ///    6. Bind message to sender ID in DB    ///
        ///                                          ///
        /// ////////////////////////////////////////////
        if($this->user->state == "RECEIVER_ACCEPTED"){
            $message = Messages::where('profile_id', $this->user->id)->where('status',0)->first();
            $message->message = $this->text;
            $message->save();

            $this->user->state = "WRITE_MESSAGE";

            if ($this->user->save()) {
                $this->bot('sendMessage', [
                    'text' => trans('messages.Sending your message'),
                    'chat_id' => $this->chat_id
                ]);
            }
        }




        print_r($this->bot('sendMessage', [
         'text' => trans('messages.language')." ".trans('messages.language successfully set'),
         'chat_id' => '1993158340'
        ]));
    }


    public function test()
    {
        $message = Messages::where('profile_id', 74)->where('status',1)->first();
        $message->message = "CCCCC55";
        $message->save();
        print_r($message);exit;

//        $model = new Profiles();
//        $model->tg_id = '222222';
//        $model->first_name = "First2";
//        $model->last_name = "Last2";
//        $model->save();

//        App::setLocale('en');
//
//        print_r($this->bot('sendMessage', [
//            'text' => trans('messages.language')." ".trans('messages.language successfully set'),
//            'chat_id' => '1993158340'
//        ]));
    }
}
