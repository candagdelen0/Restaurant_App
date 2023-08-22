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
    }