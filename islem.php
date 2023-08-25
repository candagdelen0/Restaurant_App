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

        case "goster":
            $masaid = htmlspecialchars($_GET["id"]);
            $siparis = "SELECT * FROM siparisler WHERE masaid=$masaid";
            $bakiye = "SELECT * FROM masabakiye WHERE masaid=$masaid";
            $var = benimsorgum($db,$siparis, 1);
            $bak = benimsorgum($db,$bakiye, 1);
            if ($var->num_rows == 0):
                uyari("danger", "Henüz Sipariş Yok");
                benimsorgum($db, "DELETE FROM masabakiye WHERE masaid=$masaid",1);
            else:
                echo '<table class="table table-bordered table-striped text-center mt-1">
                    <thead>
                        <tr>
                            <th class="bg-dark text-white">Ürün Adı</th>
                            <th class="bg-dark text-white">Adet</th>
                            <th class="bg-dark text-white">Tutar</th>
                            <th class="bg-dark text-white">İşlem</th>
                        </tr>
                    </thead>
                    <tbody>';
                       
                            echo '<tr>
                                <td class="mx-auto text-center p-4"></td>
                                <td class="mx-auto text-center p-5" id="adetler"></td>
                                <td class="mx-auto text-center p-5"></td>
                            </tr>
                       <tr>
                            <td class="bg-dark text-white text-center"><b>Toplam</b></td>
                            <td class="bg-dark" colspan="2">
                               
                                   
                                
                            </td>
                        </tr>
                    </tbody>
                </table>';
            endif;
        break;
        endswitch;


?>