<?php
    require "functions/function-restaurant.php";
    include "partial/_header.php";
    $sistem = new System;
    if(!$_SESSION['Kullanici']):
        header("Location:index.php");
    endif;
    @$masaid = $_GET["masaid"];
?>
    <title>MeyCan Masa Yönetimi</title>

    <script>
        $(document).ready(function() {
            var id= "<?php echo $masaid; ?>";
            $("#butonlar").load("islem.php?islem=butonlar&id="+id);
            $("#veri").load("islem.php?islem=goster&id="+id);
            $('#btn').click(function() {
                $.ajax({
                    type: "POST",
                    url: 'islem.php?islem=ekle',
                    data: $('#ekleform').serialize(),
                    success: function(donen_veri) {
                        $('#ekleform').trigger("reset");
                        $("#cevap").html(donen_veri).fadeOut(1400);
                        window.location.reload();
                    },		
                });
            });

            $('#urunler a').click(function() {
                var sectionId = $(this).attr('sectionId');
                $("#katurun").load("islem.php?islem=urun&katid=" + sectionId);
            });
        });
    </script>


    <div class="container-fluid"><?php
        if($masaid != 0):
            $diz = $sistem->masagetir($db, $masaid);
            $dizi = $diz->FETCH_ASSOC();
            ?><div class="row">
                <div class="col-md-4">
                    <div class="row bg-light border-bottom border-dark">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4 m-2"><a href="anasayfa.php" style="text-decoration: none;"><img src="../Dosyalar/ikon/arrow-left.png"></a></div>
                                <div class="col-md-7 fs-2 mt-3 text-info"><?php echo $dizi["ad"]; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="veri"></div>
                </div>
                <div class="col-md-2">
                    <div class="row">
                        <div class="col-md-12" id="butonlar"></div>
                        <div class="col-md-12" id="cevap"></div>
                    </div>
                </div>

                <div class="col-md-6 bg-light" id="urunler">
                    <form id="ekleform">
                        <div class="row justify-content-evenly border-bottom pb-2" style="min-height:120px;"></div>
                        <div class="row"><div class="col-md-12" style="min-height:410px; background-color:#F0F8FF;" id="katurun"><?php $sistem->urungrup($db); ?></div><hr>
                        <div class="row">
                            <div class="col-md-12 text-center"><?php
                                for($i=1; $i<=10; $i++):
                                    echo '<label class="m-2 p-2 border rounded" style="background-color: #4169E1; color: #FFFFF0;"><input name="adet" type="radio" class="me-1" value="'.$i.'">'.$i.'</label>';
                                endfor;
                                ?><div class="col-md-12 mb-3">
                                    <input type="hidden" name="masaid" value="<?php echo $dizi["id"]; ?>">
                                    <input type="button" id="btn" class="buton mt-2" style="width: 80%" value="Ekle">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div><?php
        endif;
    ?></div>
    
</body>
</html>
