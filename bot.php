<?php

require_once 'vendor/autoload.php';
require_once "functions.php";

$replyMarkups = include "reply_markups.php";
$inlineKeyboards = include "inline_keyboards.php";

const CHANNEL_ID = '-1001278172439';

try {
    $bot = new \TelegramBot\Api\Client('2087735209:AAFgPsYkLpeeo3J7rA1a9Ubr4fbdS6yPtdQ');

    $bot->command('start', function ($message) use ($bot, $replyMarkups) {
        try {
            $res = $bot->getChatMember(CHANNEL_ID, $message->getFrom()->getId());
            $keyboard = new \TelegramBot\Api\Types\ReplyKeyboardMarkup($replyMarkups['main'], false, true); // true for one-time keyboard

            $bot->sendMessage($message->getChat()->getId(), 'Добро пожаловать в бот even.uz', null, false, null, $keyboard);
        }catch (\TelegramBot\Api\Exception $e){
            $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup([
                [
                    ['text' => 'Перейти в канал', 'url' => 'https://t.me/evenuz']
                ]
            ]);

            $bot->sendMessage($message->getChat()->getId(), 'Подпишитесь на наш канал, прежде чем использовать бота и нажмите /start', null, false, null, $keyboard);
        }
    });


    $bot->on(function (\TelegramBot\Api\Types\Update $update) use ($bot, $inlineKeyboards, $replyMarkups) {
        $message = $update->getMessage();
        $id = $message->getChat()->getId();

        $function = getActionByMessage($message->getText());
        if ($function == 'catalog') {
            $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inlineKeyboards['catalog']);
            $bot->sendMessage($id, $message->getText(), null, false, null, $keyboard);

        } elseif ($function == 'about') {
            $keyboard = new \TelegramBot\Api\Types\ReplyKeyboardMarkup($replyMarkups['main'], false, true);
            $bot->sendMessage($id, 'https://telegra.ph/O-Kompanii-10-08-2', null, false, null, $keyboard);
        } elseif ($function == 'address') {
            $keyboard = new \TelegramBot\Api\Types\ReplyKeyboardMarkup($replyMarkups['main'], false, true);
            $bot->sendLocation($id, 41.382128, 69.294766, null, $keyboard);
        } elseif ($function == 'examples') {
            $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inlineKeyboards['examples']);
            $bot->sendMessage($id, $message->getText(), null, false, null, $keyboard);
        } elseif ($function == 'contact') {
            $keyboard = new \TelegramBot\Api\Types\ReplyKeyboardMarkup($replyMarkups['main'], false, true);

            $bot->sendMessage($id, "Контактные данные 📲

+998712001505

+998331001505

Наш сайт 🌐
www.even.uz

Instagram 📷
Instagram.com/even.uz

Почта 📩
info@even.uz", null, false, null, $keyboard);
        }

    }, function () {
        return true;
    });


    $bot->run();

} catch (\TelegramBot\Api\Exception $e) {
    $e->getMessage();
}