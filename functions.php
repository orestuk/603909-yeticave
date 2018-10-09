<?php


function format_price($amount)
{

    $amount = ceil($amount);
    $result = strval($amount);
    $string_length = mb_strlen($result);
    if ($amount > 1000) {
        $result = mb_substr($result, 0, $string_length - 3 ).' '.mb_substr($result, $string_length - 4, 3);
    }
    return $result.' '.'₽';
}

function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';

    if (!file_exists($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require($name);

    $result = ob_get_clean();

    return $result;
}

function esc($str) {
    $text = htmlspecialchars($str);
    return $text;
}

function get_lot_time(){
    date_default_timezone_set("Europe/Moscow");
    $ts_midnight = strtotime('tomorrow');
    $secs_to_midnight = $ts_midnight - time();

    $houres = floor($secs_to_midnight / 3600);
    $minutes = floor( ($secs_to_midnight % 3600) / 60);
    return sprintf("%02d:%02d", $houres, $minutes);
}
