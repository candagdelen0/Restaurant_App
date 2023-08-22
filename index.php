<?php
    include "partial/_header.php";
    require "functions/function-restaurant.php";
    $sistem = new System;
?>
<title>MeyCan</title>



<body>
    <div class="container text-center">
        <div class="row mx-auto">
            <div class="col-md-4 "></div>
            <div class="col-md-4 mx-auto text-center" id="panel"><?php 
                @$buton = $_POST["buton"];
                if (!$buton):
                    ?><form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                        <div class="col-md-12 border-bottom p-2"><h3>Giriş Paneli</h3></div>
                        <div class="col-md-12"><input type="text" name="ad" class="form-control mt-2" placeholder="Kullanıcı Adı" autofocus></div>
                        <div class="col-md-12"><input type="password" name="sifre" class="form-control mt-3" placeholder="Şifre" ></div>

                        <div class="col-md-12 mt-3 text-center">
                            <label class="btn m-1 ps-4 pe-4 pt-2 pb-2 labyon diger"><input name="kullanici" type="radio" value="yon"> Yönetici </label>
                            <label class="btn m-1 ps-4 pe-4 pt-2 pb-2 labkasa diger"><input name="kullanici" type="radio" value="kasa"> Kasa </label>
                            <label class="btn m-1 ps-4 pe-4 pt-2 pb-2 labrest diger"><input name="kullanici" type="radio" value="rest"> Restoran </label>
                        </div>
                        <div class="col-md-12"><input type="submit" name="buton" class="btn btn-info mb-3 mt-3 pt-2 pb-2 ps-5 pe-5" value="Giriş Yap"></div>
                    </form><?php 
                else:
                    @$ad = $sistem->safety($_POST["ad"]);
                    @$sifre = $sistem->safety($_POST["sifre"]);
                    @$kullanici = $_POST["kullanici"];
                    if($ad == "" || $sifre == ""):
                        $sistem->uyari("danger","Bilgiler Boş Bırakılamaz","index.php");
                    else:
                        // yönlendirme
                    endif;
                endif;
            ?></div>
            <div class="col-md-4"></div>
        </div>
    </div>
    <form>



</body>
</html>