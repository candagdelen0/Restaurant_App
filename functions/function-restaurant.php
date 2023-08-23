<?php
    require "functions/connection.php";

    class System {
        public function genelsorgu($vt, $sorgu, $getres) {
            $sor = $vt->prepare($sorgu);
            $sor->execute();
            if($getres==1):
                return $sonuc = $sor->get_result();
            endif;
        }

        public function safety($data) {
            $data = trim($data);
            $data = stripcslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        public function uyari($tip, $metin, $sayfa) {
            echo '<div class="mt-3 alert alert-'.$tip .' ">'. $metin .' </div>';
            header('refresh:2, url='. $sayfa.' ');
        }
        
        public function giriskont($vt, $isim, $sifre, $tablo) {
            $sifreli = md5(md5(sha1($sifre)));
            $gelen = $this->genelsorgu($vt, "SELECT * FROM $tablo WHERE ad='$isim' AND sifre='$sifreli' ",1);
            $gelenbilgi = $gelen->FETCH_ASSOC();
            if ($gelen->num_rows == 0):
                $this->uyari("danger","Bilgiler Hatalı","index.php");
            else:
                if ($tablo == "yonetim"):
                    $_SESSION['Kullanici'] = $gelenbilgi["ad"];
                    header("Location:yonetim.php");
                else:
                    $_SESSION['Kullanici'] = $gelenbilgi["ad"];
                    header("Location:anasayfa.php");
                endif;
            endif;
        }
    }