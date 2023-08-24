<?php
    require "functions/function-restaurant.php";
    include "partial/_header.php";
    $sistem = new System;
    if(!$_SESSION['Kullanici']):
        header("Location:index.php");
    endif;
?>
<title>MeyCan Restaurant</title>

<body>
    <div class="container-fluid">
        <div class="row bg-dark text-white">
            <div class="col-md-3 m-2"><img src="../Dosyalar/ikon/logo.png" class="me-3">MeyCan</div>
            <div class="col-md-6"></div>
            <div class="col-md-2 m-2"><img src="../Dosyalar/ikon/calendar.png" class="pe-3"><?php echo date("d.m.Y");  ?></div>
        </div>
        <div class="row justify-content-around mt-3"><?php $sistem->masacek($db); ?> </div>

        <?php 
            $kasiyer = $sistem->genelsorgu($db, "SELECT * FROM kasiyer",1);
            while($ksyr = $kasiyer->FETCH_ASSOC()) {
                $kasiyerad = $ksyr["ad"];
                
            }
            if ($_SESSION['Kullanici'] == $kasiyerad):
        ?>
        
        <div class="row fixed-bottom" id="bottombar">
            <div class="col-md-2 mt-3 mb-3 ps-4 border-end" id="divbottom"><img src="../Dosyalar/ikon/restaurant.png" class="ps-2"> Toplam Masa: <span class="bg-danger border-danger rounded p-1"><?php $sistem->toplamMasa($db); ?></span></div>
            <div class="col-md-2 mt-3 mb-3 border-end" id="divbottom"><img src="../Dosyalar/ikon/order.png" class="ps-2"> Toplam Sipariş: <span class="bg-danger border-danger rounded p-1"><?php $sistem->toplamSiparis($db); ?></span></div>
            <div class="col-md-2 mt-3 mb-3 border-end" id="divbottom"><img src="../Dosyalar/ikon/percent.png" class="ps-2"> Doluluk Oranı: <span class="bg-danger border-danger rounded p-1"><?php $sistem->doluluk($db); ?></span>  </div>
            <div class="col-md-6 mt-3 mb-3 border-end text-center" id="divbottom"><img src="../Dosyalar/ikon/waiter.png" class="ps-2"> Garson: <span class="text-danger"><?php echo $_SESSION['Kullanici'] ?></span> <span><a href="islem.php?islem=cikis" class="ms-4 bg-warning border-warning rounded text-dark ps-3 pe-3 pt-2 pb-2" style="text-decoration: none;">LOG OUT</a></span></div>
        </div>
    </div>
    <?php 
        else:
            echo ' <div class="row bg-white border border-light" id="rezervelistesi"></div>  
            <div class="row bg-light border border-light" id="rezervealan">
                <div class="row mx-auto text-center">
                    <form id="rezerveform">
                        <div class="col-md-12 p-1"><b>Masa Adı</b></div>
                        <div class="col-md-12">
                            <select name="masaid" class="form-control mt-2">
                                <option class="text-center" value="0">SEÇ</option>';
                                    $masa = $sistem->genelsorgu($db, "SELECT * FROM masalar WHERE durum=0 AND rezervedurum=0",1);
                                    while ($masalar = $masa->FETCH_ASSOC()):
                                        echo '<option class="text-center" value="'.$masalar["id"] .'">'.$masalar["ad"] .'</option>';
                                    endwhile;
                                ?>
                            </select>
                        </div>
                        <div class="col-md-12 p-1"><b>İsim</b></div>
                        <div class="col-md-12">
                            <input type="text" name="kisi" class="form-control mt-2">
                        </div>
                        <div class="col-md-12">
                            <input type="submit" id="rezbuton" value="REZERVE ET" class="btn btn-info mt-4 mb-3">
                        </div>
                    </form>
                </div>
            </div>
            <div class="row fixed-bottom" id="bottombar">
                <div class="col-md-9 mt-3 mb-3 border-end" id="divbottom">
                <img src="../Dosyalar/ikon/waiter.png" class="ps-5"> Garson: <span class="text-danger"><?php echo $_SESSION['Kullanici'] ?></span> 
                    <span><a href="islem.php?islem=cikis" class="ms-4 bg-warning border-warning rounded text-dark ps-3 pe-3 pt-2 pb-2" style="text-decoration: none;">LOG OUT</a></span>
                </div>
                <div class="col-md-2 mt-3 mb-3 border-end text-center"><img src="../Dosyalar/ikon/reserved.png" class="pe-3" id="rezformac"><img src="../Dosyalar/ikon/card.png" class="ps-3" id="rezlist"></div>
                <div class="col-md-1 mt-3 mb-3 text-center"> <img src="../Dosyalar/ikon/next.png" id="formkapat"></div>
            </div>
        </div>

        <?php endif; ?>

        <?php include "partial/_footer.php"; ?>