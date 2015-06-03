<?php

function secondsConverter($seconds) {
    $hours = floor($seconds / 60);
    $minutes = ($seconds % 60);

    if ($hours == 1) {
        return "$hours ώρα και $minutes";
    }else if($hours == 0)
    {
        return "$minutes";
    }else{
         return "$hours ώρες και $minutes";
    }
}
?>

