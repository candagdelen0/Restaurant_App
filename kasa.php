<?php
    require "functions/function-restaurant.php";
    include "partial/_header.php";
    $sistem = new System;
    if(!$_SESSION['Kullanici']):
        header("Location:index.php");
    endif;
    @$masaid = $_GET["masaid"];
?>

<title>MeyCan Kasa İşlemleri</title>
