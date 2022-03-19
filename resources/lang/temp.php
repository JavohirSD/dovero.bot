<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('API_KEY','1966900043:AAHsP42pky6Rwv6FMmMAdS17IvAoxDU0f8M');
$bot_admin_id     = "929987374";        //admin id raqami      XXXCCCYYY
$bot_username     = "@grandportalbot";  //bot useri            @botname
$chanel_username  = "@grandportal";     //asosiy kanal useri   @channeluser
$group_username   = "";


function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}

function sendPost($msg,$peer,$owner,$id){
    if(strpos($peer,"+")===0) $field = "number";
    if(strpos($peer,"@")===0) $field = "username";

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://doverobot.mylib.uz/users/user0".$id."/index.php",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => array($field => $peer,'message' => base64_encode($msg),'owner' => $owner),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}


$data       = file_get_contents("php://input");
$update     = json_decode($data, true);
file_put_contents('filename.txt', print_r($update, true)."-----------------",FILE_APPEND);

$text       = $update['message']['text'];
$chat_id    = $update['message']['from']['id'];
$message_id = $update['message']['message_id'];

$username   = $update['message']['from']['username'];
$fname      = $update['message']['from']['first_name'];
$lname      = $update['message']['from']['last_name'];

$cb_query   = $update['callback_query'];
$cb_data    = $update['callback_query']['data'];
$cb_qid     = $update['callback_query']['id'];
$cb_from_id = $update['callback_query']['from']['id'];
$cb_mc_id   = $update['callback_query']['message']['chat']['id'];
$cb_mm_id   = $update['callback_query']['message']['message_id'];
$cb_im_id   = $update['callback_query']['inline_message_id'];
$cb_fname   = $update['callback_query']['from']['first_name'];
$cb_lname   = $update['callback_query']['from']['last_name'];
$cb_uname   = $update['callback_query']['from']['username'];
$contact    = $update['message']['contact']['phone_number'];

$db_con   = 'mysql:dbname=u0904844_sosbot;host=localhost;charset=utf8mb4';
$password = '439@kgXzDh@36ft8';
$user     = 'u0904_sosuser';
$pdo      = new PDO($db_con, $user, $password);
$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );



$inline_button1    = array('text'=> "🇬🇧 English 🇬🇧",   'callback_data'=>'lang_english');
$inline_button2    = array('text'=> "🇷🇺 Русский 🇷🇺",   'callback_data'=>'lang_russian');
$inline_button3    = array('text'=> "🇺🇿 O'zbekcha 🇺🇿", 'callback_data'=>'lang_uzbek');
$inline_keyboard01 = [[$inline_button1],[$inline_button2],[$inline_button3]];
$keyboard01 = array("inline_keyboard" => $inline_keyboard01);
$menu_001   = json_encode($keyboard01);


$menu_002 = json_encode([
    'resize_keyboard'=>true,
    'keyboard'=>[
        [['text'=>"☎️ Send my number ☎️",'request_contact'=>true],],
        [['text'=>"💎 Lisence 💎"],],
    ]
]);


$menu_003 = json_encode([
    'resize_keyboard'=>true,
    'keyboard'=>[
        [['text'=>"☎️ Отправить мой номер ☎️",'request_contact'=>true],],
        [['text'=>"💎 Лицензия 💎"],],
    ]
]);


$menu_004 = json_encode([
    'resize_keyboard'=>true,
    'keyboard'=>[
        [['text'=>"☎️ Telefon raqamni yuborish ☎️",'request_contact'=>true],],
        [['text'=>"💎 Litsenziya shartlari 💎"],],
    ]
]);

$menu_005 = json_encode([
    'resize_keyboard'=>true,
    'keyboard'=>[
        [['text'=>"♻️ Send new message ♻️"],],
    ]
]);

$menu_006 = json_encode([
    'resize_keyboard'=>true,
    'keyboard'=>[
        [['text'=>"♻️ Отправить новое сообщение ♻️"],],
    ]
]);

$menu_007 = json_encode([
    'resize_keyboard'=>true,
    'keyboard'=>[
        [['text'=>"♻️ Yangi xabar yuborish ♻️"],],
    ]
]);




if($text == "test"){
    bot('sendMessage',[
        'chat_id'=> $chat_id,
        'text'   => "TEST OK: ".$chat_id,
    ]);
}


if($text == "/start"){
    $st = $pdo->prepare("SELECT COUNT(id) AS row_count FROM users WHERE tg_id=:chat_id");
    $st->bindParam(":chat_id", $chat_id);
    $st->execute();
    $new = $st->fetch()['row_count'];
    //  bot('sendMessage',[
    //      'chat_id'=> $chat_id,
    //      'text'   => "FETCH: ".$new
    //  ]);

    if($new == 0 ) {
        $st = $pdo->prepare("INSERT INTO users (`tg_id`,`language`,`username`,`first_name`,`last_name`) VALUES (:chat_id,'eng',:uname,:fname,:lname)");
        $st->bindParam(":chat_id", $chat_id);
        $st->bindParam(":uname",   $username);
        $st->bindParam(":fname",   $fname);
        $st->bindParam(":lname",   $lname);
        $exec = $st->execute();
    }

    bot('sendMessage',[
        'chat_id'=> $chat_id,
        'text'   => "Welcome to DoveRobot. Please choose your language.\n\nДобро пожаловать в DoveRobot. Пожалуйста, выберите свой язык.\n\nDoveRobot ga xush kelibsiz.Kerakli tilni tanlang:",
        'reply_markup'       => $menu_001,
    ]);
}


if(isset($contact)){

    ///

    $st0 = $pdo->prepare("UPDATE users SET phone_number=:contact WHERE tg_id=:chat_id");
    $st0->bindParam(":chat_id", $chat_id);
    $st0->bindParam(":contact", $contact);
    $st0->execute();

    $st = $pdo->prepare("SELECT * FROM users WHERE tg_id=:chat_id");
    $st->bindParam(":chat_id", $chat_id);
    $st->execute();
    sendNumber($st->fetch()['language'],$chat_id);
}

if((strpos($text,"+") === 0 && strlen($text)==13) || (strpos($text,"@") === 0 && strlen($text) > 4)) {

    $st = $pdo->prepare("SELECT * FROM users WHERE tg_id=:chat_id");
    $st->bindParam(":chat_id", $chat_id);
    $st->execute();
    $user = $st->fetch(PDO::FETCH_ASSOC);
    $language = $user['language'];
    $phone    = $user['phone_number'];
    $user_id  = $user['id'];

    if(strlen($phone)>10) {
        $st1 = $pdo->prepare("INSERT INTO chats (`user_id`,`reciever`,`status`) VALUES (:user_id,:reciever,0)");
        $st1->bindParam(":user_id",  $user_id);
        $st1->bindParam(":reciever", $text);
        $st1->execute();

        if($language == 'eng') {
            bot('sendMessage',[
                'chat_id'=> $chat_id,
                'text'   => "Now send me the message text which I have to deliver.",
            ]);
        }

        if($language == 'rus') {
            bot('sendMessage',[
                'chat_id'=> $chat_id,
                'text'   => "Теперь пришлите мне текст сообщения, которое я должен доставить.",
            ]);
        }

        if($language == 'uzb') {
            bot('sendMessage',[
                'chat_id'=> $chat_id,
                'text'   => "Endi menga etkazishim kerak bo'lgan xabar matnini yuboring.",
            ]);
        }
    } else {
        if($language == 'eng') {
            bot('sendMessage',[
                'chat_id'=> $chat_id,
                'text'   => "First of all you have to send me your contact !",
                'reply_markup' => $menu_002
            ]);
        }

        if($language == 'rus') {
            bot('sendMessage',[
                'chat_id'=> $chat_id,
                'text'   => "Прежде всего, вы должны отправить мне свой контакт!",
                'reply_markup' => $menu_003
            ]);
        }

        if($language == 'uzb') {
            bot('sendMessage',[
                'chat_id'=> $chat_id,
                'text'   => "Avval o'z kontaktingizni yuborishingiz shart!",
                'reply_markup' => $menu_004
            ]);
        }
    }
}


if(
    strpos($text,"+") !== 0
    && strpos($text,"@") !== 0
    && strpos($text,"💎 ") === false
    && $text != "/start"
    && strpos($text,"♻️") === false
    && strpos($text,"99800") === false
    && !isset($cb_query)
    && !isset($contact)
) {
    $st = $pdo->prepare("SELECT * FROM users WHERE tg_id=:chat_id");
    $st->bindParam(":chat_id", $chat_id);
    $st->execute();
    $user = $st->fetch(PDO::FETCH_ASSOC);
    $language = $user['language'];
    $user_id  = $user['id'];
    $owner    = $user['phone_number'];

    $st0 = $pdo->prepare("SELECT * FROM chats WHERE user_id=:user_id AND `status`=0 ORDER BY created_date DESC LIMIT 1");
    $st0->bindParam(":user_id", $user_id);
    $st0->execute();
    $user = $st0->fetch(PDO::FETCH_ASSOC);
    $reciever  = $user['reciever'];

    $st1 = $pdo->prepare("UPDATE chats SET `message`=:message,`status`=1 WHERE user_id=:user_id AND `status`=0 ORDER BY created_date DESC LIMIT 1");
    $st1->bindParam(":message", base64_encode($text));
    $st1->bindParam(":user_id", $user_id);
    $st1->execute();

    if($st1->rowCount() == 0){
        bot('sendMessage',[
            'chat_id'=> $chat_id,
            'text'   => "❌ User not found ❌\n❌ Foydalanuvchi topilmadi ❌",
            'reply_markup' => $menu_005
        ]);
        exit();
    }


    // loadingMessage($language,$chat_id);
    // check before sendMessage, if user blocked or not
    if(isBlocked($chat_id)){
        $res = sendPost($text, $reciever,$owner,1);
        if($res == "DELIVERED!")	{
            sendDelivered($language,$chat_id);
            exit();
        }
        if($res == "SPAMMED!"){
            $res = sendPost($text, $reciever,$owner,2);
            if($res == "DELIVERED!"){
                sendDelivered($language,$chat_id);
                exit();
            }
        }
        if($res == "SPAMMED!"){
            $res = sendPost($text, $reciever,$owner,3);
            if(sendPost($text, $reciever,$owner,3) == "DELIVERED!"){
                sendDelivered($language,$chat_id);
                exit();
            }
        }
        sendRestricted($language, $chat_id);
    }
}


if(strpos($text,"♻️") !== false){
    $st = $pdo->prepare("SELECT * FROM users WHERE tg_id=:chat_id");
    $st->bindParam(":chat_id", $chat_id);
    $st->execute();
    $user = $st->fetch(PDO::FETCH_ASSOC);

    sendNumber($user['language'],$chat_id);
}

if(strpos($text,"💎 ") !== false) {
    $st = $pdo->prepare("SELECT * FROM users WHERE tg_id=:chat_id");
    $st->bindParam(":chat_id", $chat_id);
    $st->execute();
    $user = $st->fetch(PDO::FETCH_ASSOC);
    sendLisence($user['language'],$chat_id);
}






















if(isset($cb_query) && $cb_data=="lang_english"){
    $st = $pdo->prepare("UPDATE users SET `language`='eng' WHERE tg_id=:chat_id");
    $st->bindParam(":chat_id",   $cb_from_id);
    $st->execute();

    bot('sendMessage',[
        'chat_id'      => $cb_from_id,
        'text'         => "ENGLISH LANGUAGE SUCCESSFULLY SET!",
    ]);
    bot('sendMessage',[
        'chat_id'      => $cb_from_id,
        'text'         => "NOW YOU HAVE TO SEND ME YOUR CONTACT",
        'reply_markup' => $menu_002,
    ]);
}


if(isset($cb_query) && $cb_data=="lang_russian"){
    $st = $pdo->prepare("UPDATE users SET `language`='rus' WHERE tg_id=:chat_id");
    $st->bindParam(":chat_id",   $cb_from_id);
    $st->execute();

    bot('sendMessage',[
        'chat_id'      => $cb_from_id,
        'text'         => "РУССКИЙ ЯЗЫК УСПЕШНО УСТАНОВЛЕН!"
    ]);
    bot('sendMessage',[
        'chat_id'      => $cb_from_id,
        'text'         => "ТЕПЕРЬ ВЫ ДОЛЖНЫ ОТПРАВИТЬ МНЕ СВОЙ КОНТАКТ",
        'reply_markup' => $menu_003
    ]);
}



if(isset($cb_query) && $cb_data=="lang_uzbek"){
    $st = $pdo->prepare("UPDATE users SET `language`='uzb' WHERE tg_id=:chat_id");
    $st->bindParam(":chat_id",   $cb_from_id);
    $st->execute();

    bot('sendMessage',[
        'chat_id'      => $cb_from_id,
        'text'         => "SIZDA O'ZBEK TILI O'RNATILDI!",
    ]);
    bot('sendMessage',[
        'chat_id'      => $cb_from_id,
        'text'         => "ENDI MENGA O'Z RAQAMINGIZNI YUBORING",
        'reply_markup' => $menu_004,
        'one_time_keyboard' => false,
        'resize_keyboard'   => true
    ]);
}

function sendNumber($language,$chat_id){
    if($language == 'eng') {
        bot('sendMessage',[
            'chat_id'=> $chat_id,
            'text'   => "Now enter the telegram phone number or telegram username of the recipient.\n example: +998001234567\nor @username",
        ]);
    }

    if($language == 'rus') {
        bot('sendMessage',[
            'chat_id'=> $chat_id,
            'text'   => "Теперь введите телеграм номер или телеграм юзернейм получателя.\n пример: +998001234567\nили @username",
        ]);
    }

    if($language == 'uzb') {
        bot('sendMessage',[
            'chat_id'=> $chat_id,
            'text'   => "Endi qabul qiluvchining telegram raqamini yoki telegram userini kiriting.\n masalan: +998001234567\nyoki @username",
            'reply_markup' => json_encode(array(
                'remove_keyboard' => true
            ))
        ]);
    }
}


function sendDelivered($language,$chat_id){
    // bot('deleteMessage',[
    //           'chat_id'    => $chat_id,
    //           'message_id' =>  $GLOBALS['message_id'],
    //       ]);

    if($language == 'eng') {
        bot('sendMessage',[
            'chat_id'=> $chat_id,
            'text'   => "✅ Your message delivered !",
            'reply_markup' => $GLOBALS['menu_005'],
        ]);
    }

    if($language == 'rus') {
        bot('sendMessage',[
            'chat_id'=> $chat_id,
            'text'   => "✅ Ваше сообщение доставлено !",
            'reply_markup' =>$GLOBALS['menu_006'],
        ]);
    }

    if($language == 'uzb') {
        bot('sendMessage',[
            'chat_id'=> $chat_id,
            'text'   => "✅ Xabaringiz yetkazildi !",
            'reply_markup' => $GLOBALS['menu_007'],
        ]);
    }
}


function loadingMessage($language,$chat_id){
    if($language == 'eng') {
        bot('sendMessage',[
            'chat_id'=> $chat_id,
            'text'   => "☢️ Sending your message...",
        ]);
    }

    if($language == 'rus') {
        bot('sendMessage',[
            'chat_id'=> $chat_id,
            'text'   => "☢️ Отправка сообщения...",
        ]);
    }

    if($language == 'uzb') {
        bot('sendMessage',[
            'chat_id'=> $chat_id,
            'text'   => "☢️ Xabaringiz yuborilmoqda...",
        ]);
    }
}


function sendRestricted($language, $chat_id){
    if($language == 'eng') {
        bot('sendMessage',[
            'chat_id'=> $chat_id,
            'text'   => "THIS USER HAS RESTRICTED UNKNOWN CONTACTS",
            'reply_markup' => $GLOBALS['menu_007'],
        ]);
    }

    if($language == 'uzb') {
        bot('sendMessage',[
            'chat_id'=> $chat_id,
            'text'   => "ЭТОТ ПОЛЬЗОВАТЕЛЬ ОГРАНИЧИЛ НЕИЗВЕСТНЫЕ КОНТАКТЫ",
            'reply_markup' => $GLOBALS['menu_007'],
        ]);
    }

    if($language == 'uzb') {
        bot('sendMessage',[
            'chat_id'=> $chat_id,
            'text'   => "USHBU FOYDALANUVCHI XABAR YOZISHGA RUXSAT BERMAGAN!",
            'reply_markup' => $GLOBALS['menu_007'],
        ]);
    }
}

function sendLisence($language, $chat_id){
    if($language == 'eng') {
        bot('sendMessage',[
            'chat_id'      => $chat_id,
            'text'         => "Firstly you have to send us your own phone number in order to send message to other users.We will send them your message by including your phone number for Telegram users privacy agreement.\nDo not share sensitive information with unknown contacts through bot. Bot administration is not responsible for information you sent. We do not collect and sell your information to third persons. All rights of @DoveRobot and its users are reserved.\n©️ @DoveRobot 2020",
            'reply_markup' => $menu_002,
        ]);
    }

    if($language == 'rus') {
        bot('sendMessage',[
            'chat_id'      => $chat_id,
            'text'         => "Во-первых, вы должны отправить нам свой номер телефона, чтобы отправлять сообщения другим пользователям. Мы отправим им ваше сообщение, указав ваш номер телефона по соглашения о конфиденциальности пользователей Telegram.\nНе делитесь конфиденциальной информацией с неизвестными контактами через бота. Администрация бота не несет ответственности за отправленную вами информацию. Мы не собираем и не продаем вашу информацию третьим лицам. Все права @DoveRobot и его пользователей защищены.\n©️ @DoveRobot 2020",
            'reply_markup' => $menu_003,
        ]);
    }

    if($language == 'uzb') {
        bot('sendMessage',[
            'chat_id'=> $chat_id,
            'text'   => "Botdan foydalanish uchun siz avval o'z telefon raqamingizni bizga yuborishingiz kerak bo'ladi.Telegram foydalanuvchilarining shaxsiylik siyosatiga ko'ra biz sizning telefon raqamingizni yuborgan xabaringiz ostida ko'rsatib o'tamiz.\nBot orqali noma'lum kontaktlar bilan maxfiy ma'lumotlaringizni almashmang. Bot ma'muriyati siz yuborgan ma'lumot uchun javobgar emas. Biz sizning ma'lumotlaringizni to'plamaymiz va uchinchi shaxslarga sotmaymiz. @DoveRobot va uning foydalanuvchilarining barcha huquqlari himoyalangan.\n©️ @DoveRobot 2020",
            'reply_markup' => $menu_004,
        ]);
    }
}


function isBlocked($chat_id){
    $block = ['1404001793','962173165','376048970'];
    if (in_array($chat_id, $block)) {

        bot('sendMessage',[
            'chat_id'      => $chat_id,
            'text'         => "Yuborgan xabarlaringizdan shikoyat qilingani sababli hozirсha botdan foydalana olmaysiz!\n\nМы получили жалобы на ваши сообщения, поэтому вы пока не можете использовать бот!\n\nWe have received complaints from your messages so you can not use the bot currently!",
        ]);
        return false;
    }
    return true;
}
