<?php

namespace App\src\Services\MailServices;
use Illuminate\Support\Facades\Mail;

class UserMailService
{
    public function __construct()
    {
    }

    public function send($data)
    {
       Mail::send('mail/templates/contacts', [
           'email' => $data->email,
           'password' => $data->password,
           'text' => $data->message,
           
       ], function($message) {
           $message->to(env('ADMIN_EMAIL', 'info@mcode.su'))
               ->subject('Запрос на регистрацию нового пользователя в Панораме');
       });
    }
}