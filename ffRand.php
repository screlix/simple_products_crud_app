<?php

function randomString()
{
    $str = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $ss = "";
    for ($i = 0; $i < 8; $i++) {
        $ss .= $str[rand(0, strlen($str))];
    }
    return $ss;
}
