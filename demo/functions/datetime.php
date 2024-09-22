<?php
date_default_timezone_set("Europe/Istanbul");

function diffDate($start, $end, $format = "d.m.Y"){
    $start = date_create($start);
    $end = date_create($end);

    $diff = date_diff($start, $end);

    $str = "";
    if($diff->y)
    {
        $str .=  "{$diff->y} yıl ";
    }

    if($diff->m)
    {
        $str .= "{$diff->m} ay ";
    }

    if($diff->d)
    {
        $str .= "{$diff->d} gün ";
    }

    if($diff->h)
    {
        $str .= "{$diff->h} saat ";
    }

    if($diff->i)
    {
        $str .= "{$diff->i} dakika ";
    }

    return $str;
}
