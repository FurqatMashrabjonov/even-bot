<?php

$replyMarkups = include "reply_markups.php";
$inlineKeyboards = include "inline_keyboards.php";

$actions = [
    "📒Каталог" => 'catalog',
    "🖼Примеры" => 'examples',
    "ℹ️О Компании" => 'about',
    "📞Связаться" => 'contact',
    "📪Наш адрес" => 'address'
];

function ech()
{
    return "asddd";
}

function getActionByMessage($msg)
{
    global $actions;
    if (isset($actions[$msg])) {
        return $actions[$msg];
    }
    return null;
}

function catalog()
{
    global $inlineKeyboards;

    return $inlineKeyboards['catalog'];
}

function about()
{

}

function contact()
{

}

function address()
{

}

function examples()
{

}