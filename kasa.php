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
<div class="comtainer-fluid">
    <?php include "partial/_navbar.php"; ?>
    <div class="row">
        <div class="col-md-10 mx-auto mt-3">
            <div class="row">
                <?php 
                    $diz = $sistem->genelsorgu($db, "SELECT * FROM masalar WHERE id = $masaid",1);
                    $dizi = $diz->FETCH_ASSOC();
                    if ($dizi["durum"] == 1):
                ?>
                <div class="col-md-6 bg-light">
                    <div class="row border-bottom">
                        <a href="anasayfa.php" style="text-decoration: none;"><img src="../Dosyalar/ikon/arrow-left.png"></a>
                    </div>
                    <div class="row ms-3">
                        <?php include "partial/_parcahesap.php"; ?>
                        <?php include "partial/_iskontoform.php"; ?>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php include "partial/_odeme.php"; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="pad" class="mt-5" style="width: 25%;"></div>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                    <div class="col-md-6">
                        <div class="row border-bottom bg-light">
                            <a href="anasayfa.php" style="text-decoration: none;"><img src="../Dosyalar/ikon/arrow-left.png"></a>
                        </div>
                    </div>
                <?php  endif; ?>


                <div class="col-md-6">
                    <?php
                        if($masaid != 0):
                            $diz = $sistem->masagetir($db, $masaid);
                            $dizi = $diz->FETCH_ASSOC();
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row bg-light border-bottom border-dark">
                                <div class="fs-2 text-center p-2 text-info" style="font-weight: bold;"><?php echo $dizi["ad"]; ?></div>
                            </div>
                            <?php  endif; ?>
                            <div class="row"><?php
                                $masaid = htmlspecialchars($_GET["masaid"]);
                                $bakiye = "SELECT * FROM masabakiye WHERE masaid=$masaid";
                                $siparis = "SELECT * FROM siparisler WHERE masaid=$masaid";
                                $var = $sistem->genelsorgu($db,$siparis, 1);
                                $bak = $sistem->genelsorgu($db,$bakiye, 1);
                                if ($var->num_rows == 0):
                                    echo '<div class="mt-3 text-center alert alert-danger">Sipariş Kaydı Yok</div>';
                                else:
                                    echo '<table class="table table-bordered table-striped text-center mt-1">
                                        <thead>
                                            <tr>
                                                <th class="bg-dark text-white">Ürün Adı</th>
                                                <th class="bg-dark text-white">Adet</th>
                                                <th class="bg-dark text-white">Tutar</th>
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
                                                    <td class="mx-auto text-center p-5"><span data-id="'.$urundiz["id"].'" data-value="'.$urundiz["adet"].'">'.$urundiz["adet"].'</span></td>
                                                    <td class="mx-auto text-center p-5">'.number_format($tutar,2,'.',',').'</td>
                                                </tr>';
                                            endwhile;
                                            echo '<tr>
                                                <td class="bg-dark text-white text-center"><b>Toplam</b></td>
                                                <td class="bg-dark text-white text-center"><b>'.$adet.'</b></td>
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
                            ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
