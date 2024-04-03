<?php
/* General purpose functions */
function redirectWithError($url, $errMsg){
    header("Location: $url/?error=$errMsg");
}

function formatDate($stringDate){
    $d = new DateTime($stringDate);
    return date_format($d, 'd-m-Y');
}

function formatTime($stringTime){
    $t = new DateTime($stringTime);
    return date_format($t,'H:i');
}
