<?php

namespace App\Http\Controllers;

use App\Http\Controllers\helpers\TelegramCurl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;

class WebhookController extends Controller
{
    use TelegramCurl;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        App::setLocale('en');

        print_r($this->bot('sendMessage', [
         'text' => trans('messages.language')." ".trans('messages.language successfully set'),
         'chat_id' => '1993158340'
        ]));
    }
}
