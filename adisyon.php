<?php
    require "functions/function-restaurant.php";
    include "partial/_header.php";
    $sistem = new System;
    if(!$_SESSION['Kullanici']):
        header("Location:index.php");
    endif;
    @$masaid = $_GET["masaid"];
?>
<title>ADİSYON</title>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 mx-auto"><?php
                if($masaid != ""):
                    $masa = $sistem->masagetir($db, $masaid);
                    $masam = $masa->FETCH_ASSOC();
                    $id = htmlspecialchars($_GET["masaid"]);
                    $sip = $sistem->genelsorgu($db, "SELECT * FROM siparisler WHERE masaid=$id",1);
                    if ($sip->num_rows==0):
                        echo '<div class="text-center mt-1 alert alert-danger">Henüz Sipariş Yok</div>';
                    else:
                        echo '<table class="table mt-2">
                            <tr>
                                <td colspan="3" class="bg-info border-bottom border-primary text-center p-2 fs-3"><strong>Masa : </strong>'.$masam["ad"] .'</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-start"><strong>Tarih : </strong>'.date("d-m-Y").'</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-start"><strong>Saat : </strong>'.date("h:i:s").'</td>
                            </tr>';

                            $sontutar = 0;
                            while($gelen = $sip->FETCH_ASSOC()):
                                $tutar = $gelen["adet"] * $gelen["urunfiyat"];
                                $sontutar += $tutar;
                                $masaid = $gelen["masaid"];

                                echo '<tbody>
                                    <tr>
                                        <td colspan="2" class="text-center pb-2">'.$gelen["urunad"].' - '.$gelen["adet"].'</td>
                                        <td colspan="1" class="text-center pb-2">'.number_format($tutar,2,'.',',').'</td>
                                    </tr>';
                            endwhile;
                                echo '<tr>
                                    <td colspan="2" class="bg-secondary "><strong>GENEL TOPLAM :</strong></td>
                                    <td colspan="2" class=" bg-secondary text-white text-center">'.number_format($sontutar,2,'.',',').' TL</td>
                                </tr>
                            </tbody>
                        </table>';
                    endif; 
                endif; 
            ?></div>
        </div>
    </div>
    
</body>
</html>