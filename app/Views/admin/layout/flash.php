<?php
if (array_key_exists('success', $_SESSION)){
    $echo = '$(function() {';
    $echo .= "toastr.success('" . $_SESSION['success'] . "')";
    $echo .= '});';

    echo $echo;
}

if (array_key_exists('danger', $_SESSION)){
    $echo = '$(function() {';
    $echo .= "toastr.error('" . $_SESSION['danger'] . "')";
    $echo .= '});';

    echo $echo;
}

if (array_key_exists('warning', $_SESSION)){
    $echo = '$(function() {';
    $echo .= "toastr.warning('" . $_SESSION['warning'] . "')";
    $echo .= "});";

    echo $echo;
}

if (array_key_exists('primary', $_SESSION)){
    $echo = '$(function() {';
    $echo .= "toastr.default('" . $_SESSION['primary'] . "')";
    $echo .= "});";

    echo $echo;
}
?>