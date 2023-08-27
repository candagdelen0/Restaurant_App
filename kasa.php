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
                <div class="col-md-6 bg-light">
                    <div class="row border-bottom">
                        <a href="anasayfa.php" style="text-decoration: none;"><img src="../Dosyalar/ikon/arrow-left.png"></a>
                    </div>
                    <div class="row ms-3">
                    iskonto ve parça hesap alanı 
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                           Ödeme butonları alanı
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="pad" class="mt-5" style="width: 25%;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row bg-light border-bottom border-dark">
                                <div class="fs-2 text-center p-2 text-info" style="font-weight: bold;"></div>
                            </div>
                            <div class="row"><?php
                                //koşul koyulacak
                                    echo '<table class="table table-bordered table-striped text-center mt-1">
                                        <thead>
                                            <tr>
                                                <th class="bg-dark text-white">Ürün Adı</th>
                                                <th class="bg-dark text-white">Adet</th>
                                                <th class="bg-dark text-white">Tutar</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                                         //döngüyle veri çekilecek
                                                echo '<tr>
                                                    <td class="mx-auto text-center p-4"></td>
                                                    <td class="mx-auto text-center p-5"><span data-id="" data-value=""></span></td>
                                                    <td class="mx-auto text-center p-5"></td>
                                                </tr>';
                                                //sonuç işlemleri
                                            echo '<tr>
                                                <td class="bg-dark text-white text-center"><b>Toplam</b></td>
                                                <td class="bg-dark text-white text-center"><b>'.$adet.'</b></td>
                                                <td class="bg-dark" colspan="2">
                                                    <p class="m-0 p-0"><del class="text-danger" id="toplamTutar"> '.number_format($sontutar,2,'.',','). " </del> |
                                                        <font class='text-success'>" . number_format($odenenTutar,2,'.',',')."</font>
                                                        <font class='text-info'><br>Ödenecek : ". number_format($kalanTutar,2,'.',',')."</font></p>

                                               </td>
                                            </tr>
                                        </tbody>
                                    </table>";
                            ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
