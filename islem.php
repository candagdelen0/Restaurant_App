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

    function uyari($tip, $metin) {
        echo '<div class="mt-3 text-center alert alert-'.$tip .' ">'. $metin .' </div>';
    }

    /* ****************************      İŞLEMLER        ********************** */
    @$islem = htmlspecialchars($_GET["islem"]);
    switch($islem):
        case "cikis":
            session_destroy();
            header("Location:index.php");
        break;
        case "urun":
            $katid = htmlspecialchars($_GET["katid"]);
            $urun = benimsorgum($db, "SELECT * FROM urunler WHERE katid = $katid", 1);
            while ($urunler = $urun->FETCH_ASSOC()):
                echo '<label class="btn btn-info m-2"><input name="urunid" type="radio" value="'.$urunler["id"].'"/>  '.$urunler["ad"].'</label>';
            endwhile;
        break;
        endswitch;


?>