<?php
    require "functions/function-restaurant.php";
    include "partial/_header.php";
    @$masaid = $_GET["masaid"];


    /* ***************************     FONKSİYONLAR     *********************** */
    function benimsorgum($vt,$sorgu,$tercih) {
        $b=$vt->prepare($sorgu);
        $b->execute();
        if ($tercih==1):
            return $c=$b->get_result();  
        endif;
    }



?>