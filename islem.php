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

    function formgetir($masaid, $vt, $baslik, $durum, $btnvalue, $btnid, $formvalue) {
        echo '<div class="card border-primary m-3 text-center" style="max-width:18rem;">
            <div class="card-header">'.$baslik.'</div>
            <div class="card-body text-info">
                <form id ="'.$formvalue.'">
                    <input type="hidden" name="mevcutmasaid" value="'.$masaid.'">
                    <select name="hedefmasa" class="form-control">';
                        $masadgstr = benimsorgum($vt, "SELECT * FROM masalar WHERE durum=$durum AND rezervedurum=0",1);
                        while ($sonuc = $masadgstr->FETCH_ASSOC()):
                            if ($masaid != $sonuc["id"]):
                                echo '<option value="'.$sonuc["id"].'">'.$sonuc["ad"].'</option>';
                            endif;
                        endwhile;
                    echo '</select>
                    <input type="button" id="'.$btnid.'" value="'.$btnvalue.'" class="btn btn-primary mt-2" style="width: 80%;">
                </form>
            </div>
        </div>';
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
                    $adet = 0;
                    $sontutar = 0;
                    while($urundiz = $var->FETCH_ASSOC()):
                        $tutar = $urundiz["adet"] * $urundiz["urunfiyat"];
                        $adet += $urundiz["adet"];
                        @$sontutar += $tutar;
                        $masaid = $urundiz["masaid"];
                            echo '<tr>
                                <td class="mx-auto text-center p-4">'.$urundiz["urunad"].'</td>
                                <td class="mx-auto text-center p-5" id="adetler"><span data-id="'.$urundiz["id"].'" data-value="'.$urundiz["adet"].'">'.$urundiz["adet"].'</span></td>
                                <td class="mx-auto text-center p-5">'.number_format($tutar,2,'.',',').'</td>
                            </tr>';
                        endwhile;
                        echo '<tr>
                            <td class="bg-dark text-white text-center"><b>Toplam</b></td>
                            <td class="bg-dark" colspan="2">';
                                if ($bak->num_rows != 0):
                                    $masabakiyesi = $bak->FETCH_ASSOC();
                                    @$odenenTutar = $masabakiyesi["tutar"];
                                    @$kalanTutar = $sontutar - $odenenTutar;
                                    echo '<p class="m-0 p-0"><del class="text-danger" id="toplamTutar"> '.number_format($sontutar,2,'.',','). " </del> |
                                    <font class='text-success'>" . number_format($odenenTutar,2,'.',',')."</font>
                                    <font class='text-info'><br>Ödenecek : ". number_format($kalanTutar,2,'.',',')."</font></p>" ;
                                else:
                                    echo "<span class='text-info'><b id='toplamTutar'>".number_format($sontutar,2,'.',',')."</b> TL</span>";
                                endif;	
                            echo '</td>
                        </tr>
                    </tbody>
                </table>';
            endif;
        break;

        case "butonlar":
            $id=htmlspecialchars($_GET["id"]);
            echo '<div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <p class="text-center"><a href="adisyon.php?masaid='.$id.'" onclick="ortasayfa(this.href,\'mywindow\',\'450\',\'450\',\'yes\');return false" style="font-weight: bold; height: 40px; width: 85%;" class="btn btn-primary mt-3">ADİSYON</a></p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12 text-center" id="birlestir"><a class="btn btn-info mt-2" style="height:40px; width: 85%;" >BİRLEŞTİR</a></div>
                        <div class="col-md-12" id="birlestirform">'; formgetir($id, $db, "Masa Birleştir<span id='kapa1' class='text-danger float-end'>X</span>", 1, "BİRLEŞTİR", "birlestirbtn", "birlestirformveri"); echo'</div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center" id="degistir"><a class="btn btn-info mt-2" style="height:40px; width: 85%;" >DEĞİŞTİR</a></div>
                        <div class="col-md-12" id="degistirform">'; formgetir($id, $db, "Masa Değiştir<span id='kapa2' class='text-danger float-end'>X</span>", 0, "DEĞİŞTİR", "degistirbtn", "degistirformveri");  echo '</div>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="row">
                        <p class="text-center" id="tumsil"><a sectionId3=" '.$id.'" class="btn btn-danger" style="height:40px; width: 85%;">Masayı Boşalt</a></p>
                    </div>
                </div>
            </div>';
        break;

        case "ekle":
            if ($_POST):
                @$masaid = htmlspecialchars($_POST["masaid"]);
                @$urunid = htmlspecialchars($_POST["urunid"]);
                @$adet = htmlspecialchars($_POST["adet"]);
                if ($masaid !="" || $urunid !="" || $adet !=""):
                    $var = benimsorgum($db, "SELECT * FROM siparisler WHERE masaid = $masaid AND urunid = $urunid",1);
                    if ($var->num_rows != 0):
                        $urundiz = $var->FETCH_ASSOC();
                        $sonadet = $adet + $urundiz["adet"];
                        $islemid = $urundiz["id"];
                        $guncelle = benimsorgum($db, "UPDATE siparisler SET adet = $sonadet WHERE id = $islemid", 0); 
                    else:
                        $gelen = benimsorgum($db, "SELECT * FROM urunler WHERE id = $urunid",1);
                        $gelenurun = $gelen->FETCH_ASSOC();
                        $urunad = $gelenurun["ad"];
                        $katid = $gelenurun["katid"];
                        $urunfiyat = $gelenurun["fiyat"];
                        $gad = $_SESSION['Kullanici'];
                        $garson = benimsorgum($db, "SELECT * FROM garson WHERE ad = '$gad'",1);
                        $gid = $garson->FETCH_ASSOC();
                        $garsonid = $gid["id"];
                        $masaguncelle = benimsorgum($db, "UPDATE masalar SET durum=1 WHERE id = $masaid",0);
                        $siparis = "INSERT INTO siparisler (masaid,garsonid,urunid,urunad,urunfiyat,adet) VALUES ($masaid, $garsonid, $urunid, '$urunad', $urunfiyat, $adet)";
                        $siparisekle = benimsorgum($db, $siparis,0);
                    endif;
                endif;
            endif;
        break;

        case "sil":
            if (!$_POST):
                uyari("danger","ERİŞİM ENGELLENDİ");
            else:
                $urunid = htmlspecialchars($_POST["urunid"]);
                $masaid = htmlspecialchars($_POST["masaid"]);
                $urunsil = $db->prepare("DELETE FROM siparisler WHERE urunid = $urunid AND masaid = $masaid");
                $urunsil->execute();
                $kontrol = benimsorgum($db, "SELECT * FROM siparisler WHERE masaid = $masaid",1);
                if ($kontrol->num_rows == 0):
                    $masaguncelle = benimsorgum($db, "UPDATE masalar SET durum=0 WHERE id = $masaid",0);
                endif;
            endif;
        break;

        
        endswitch;


?>