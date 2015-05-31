<?php

function secondsConverter($seconds) {
    $hours = floor($seconds / 60);
    $minutes = ($seconds % 60);

    return "$hours:$minutes";
}
?>

