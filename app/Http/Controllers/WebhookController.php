<?php

namespace App\Http\Controllers;

use App\Http\Controllers\helpers\Keyboards;
use App\Http\Controllers\helpers\TelegramCurl;
use App\Http\Controllers\helpers\Validators;
use App\Models\Messages;
use App\Models\Profiles;
use Illuminate\Support\Facades\App;


class WebhookController extends Controller
{
    use TelegramCurl;
    use Keyboards;
    use Validators;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $user = null;

    public function index()
    {
        $this->user = Profiles::where('tg_id', $this->chat_id)->first();

        if($this->user == null && $this->text != "/start"){
            return false;
        }

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
                'text' => "DoveRobot ga xush kelibsiz.\nKerakli tilni tanlang.\n\n"
                          ."Добро пожаловать в DoveRobot.\nПожалуйста, выберите свой язык.\n\n"
                          ."Welcome to DoveRobot.\nPlease choose your language.",
                'chat_id' => $this->chat_id,
                'reply_markup' => $this->keyboardLanguages(),
                'parse_mode'   => 'HTML'
            ]);
        }

        App::setLocale($this->user ? $this->user->language : 'uz');

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
                    'reply_markup' => $this->keyboardPolicyContact(),
                    'parse_mode'   => 'HTML'
                ]);
            }
            exit;
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
            exit;
        }


        ////////////////////////////////////////////
        ///                                      ///
        ///    4. User contact number shared     ///
        ///                                      ///
        /// ////////////////////////////////////////
        if(isset($this->contact)){
            $this->user->phone_number = str_replace("+","", $this->contact);
            $this->user->state = 'CONTACT_SHARED';
            $this->user->save();
        }

        if($this->text == trans('messages.Send new message')){
            $this->user->state = 'NEW_MESSAGE';
            $this->user->save();
        }

        if($this->user->state == "CONTACT_SHARED" || $this->user->state == "NEW_MESSAGE"){
            $this->user->state = 'NEW_MESSAGE_TEXT';
            $this->user->save();

            $this->bot('sendMessage', [
                'text' => trans('messages.Phone number or username request with examples'),
                'chat_id' => $this->chat_id,
                'parse_mode'   => 'HTML',
                'reply_markup' => $this->keyboardRemoveButtons()
            ]);
            exit;
        }

        ////////////////////////////////////////////////
        ///                                          ///
        ///    5. Receiver username/number received  ///
        ///                                          ///
        /// ////////////////////////////////////////////

        if($this->user->state == "NEW_MESSAGE_TEXT"){

            if($this->validatePhoneNumber($this->text) || $this->validateUsername($this->text)){

                $message = new Messages();
                $message->profile_id = $this->user->id;
                $message->receiver = $this->text;
                $message->status = Messages::WAITING_MESSAGE;

                if($message->save()){
                    $this->user->message_id = $message->id;
                    $this->user->state = 'RECEIVER_ACCEPTED';

                    if ($this->user->save()) {
                        $this->bot('sendMessage', [
                            'text' => trans('messages.Now send me the message text which I have to deliver'),
                            'chat_id' => $this->chat_id,
                            'parse_mode'   => 'HTML'
                        ]);
                    }
                }
            } else {
                $this->bot('sendMessage', [
                    'text' => trans('messages.Wrong username or phone number'),
                    'chat_id' => $this->chat_id,
                    'parse_mode'   => 'HTML'
                ]);
            }
            exit;
        }


        ////////////////////////////////////////////////
        ///                                          ///
        ///    6. Delivering message to receiver     ///
        ///                                          ///
        /// ////////////////////////////////////////////
        if($this->user->state == "RECEIVER_ACCEPTED"){
            $message = Messages::where('id', $this->user->message_id)->first();
            $message->message = $this->text;

            $this->user->state = "WRITE_MESSAGE";
            if ($this->user->save()) {
                $loader = $this->bot('sendMessage', [
                    'text' => trans('messages.Sending your message'),
                    'chat_id' => $this->chat_id,
                    'parse_mode'   => 'HTML'
                ]);

                if($loader->ok === true){

                    $filed = "number";
                    $receiver = $message->receiver;

                    if(is_numeric($message->receiver)){

                        $contact = Messages::where('receiver', $receiver)
                            ->whereNotNull('receiver_telegram_id')
                            ->first();

                        if($contact){
                            $receiver = $contact->receiver_telegram_id;
                            $filed = "username";
                        }
                    } else {
                        $filed = "username";
                    }

                    $robotResponse = RobotsController::sendMessage($receiver, $message->message, $this->user->phone_number,  $filed, $message);

                    if($robotResponse['response']->status){
                        $message->receiver_telegram_id = $robotResponse['response']->user_id;
                        $message->status = Messages::DELIVERED_MESSAGE;
                        $status_text = trans('messages.Your message delivered');
                    } else {
                        $message->status = Messages::FAILED_MESSAGE;
                        $status_text = trans('messages.This user has restricted unknown contacts');
                    }

                    $message->robot_id = $robotResponse['robot_id'];
                    $message->save();

                    $this->bot('deleteMessage', [
                        'chat_id' => $this->chat_id,
                        'message_id'   => $loader->result->message_id
                    ]);

                    $this->bot('sendMessage', [
                        'text' => $status_text,
                        'chat_id' => $this->chat_id,
                        'parse_mode'   => 'HTML',
                        'reply_markup'   => $this->keyboardNewMessage()
                    ]);
                }
            }
        }





    }


    public function test()
    {
//        print_r($this->bot('sendMessage', [
//            'text' => trans('messages.language')." ".trans('messages.language successfully set'),
//            'chat_id' => '1993158340'
//        ]));
//
//        $message = Messages::where('profile_id', 74)->where('status',1)->first();
//        $message->message = "CCCCC55";
//        $message->save();
//        print_r($message);exit;

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
