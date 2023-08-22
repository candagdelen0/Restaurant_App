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

    }