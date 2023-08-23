<?php
    session_start();
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

        function masacek($dv) {
            $sonuc = $this->genelsorgu($dv, "SELECT * FROM masalar",1);
            $bos = 0;
            $dolu = 0;
            while ($masason = $sonuc->FETCH_ASSOC()) :
                $siparisler = 'SELECT * FROM siparisler WHERE masaid=' . $masason["id"] . '';
                $satir = $this->genelsorgu($dv, $siparisler, 1)->num_rows;
                if ($satir == 0):
                    $renk = '#3CB371;';
                    $bord = "success";
                else:
                    $renk = '#D3D3D3;';
                    $bord = "secondary";
                endif;
                $this->genelsorgu($dv, $siparisler, 1)->num_rows == 0 ? $bos++ : $dolu++;
                if ($masason["rezervedurum"] == 0) :
                    echo '<div class="col-md-2 m-2">';
                    $sonuc2 = $this->genelsorgu($dv, "SELECT * FROM kasiyer",1);
                    while ($son = $sonuc2->FETCH_ASSOC()):
                        if($_SESSION['Kullanici'] == $son["ad"]):
                            echo '<a href="kasa.php?masaid=' . $masason["id"] . '" style="text-decoration:none;">';
                        else:
                            echo '<a href="masadetay.php?masaid=' . $masason["id"] . '" style="text-decoration:none;">';
                        endif;
                    endwhile;
                    echo '<div class="card border-' . $bord . ' m-1 col-md-12 p-2" > 
                                <div class="card-body text-secondary"> 
                                    <p class="card-text">
                                        <span style="font-size: 48px; color:' . $renk . '" class="fas fa-user me-2"></span>
                                        <span style="font-size: 24px;">' . $masason["ad"] . '</span>';
                                        if ($satir != 0): 
                                            echo '<kbd style="float:right;">' . $satir . '</kbd>';
                                        endif;
                                    echo '</p>
                                </div>
                            </div>
                        </a>
                    </div>';
                else: 
                    echo '<div class="col-md-2 m-2">  
                        <div class="card border-dark m-1 col-md-12 p-2" > 
                            <div class="card-body text-secondary"> 
                                <p class="card-text">
                                    <span style="font-size: 48px;" class="fas fa-user text-dark"></span>
                                    <span style="font-size: 20px;" class="ml-2 mb-4">' . $masason["ad"] . '</span>
                                    <br><kbd class="mb-0 float-right bg-dark text-warning" style="position:absolute;">Kişi: ' . $masason["kisi"] . ' </kbd>
                                </p>
                            </div>
                        </div> 
                    </div>';
                    
                endif;
            endwhile;
            $dolson = $dv->prepare("UPDATE doluluk SET bosMasa=$bos, doluMasa=$dolu WHERE id=1");
            $dolson->execute();
        }

        public function toplamMasa($vt) {
            $masa = $this->genelsorgu($vt, "SELECT * FROM masalar",1);
            $toplam = $masa->num_rows;
            echo $toplam;
        }

        public function toplamSiparis($vt) {
            $sip = $this->genelsorgu($vt, "SELECT * FROM siparisler",1);
            $toplamSip = $sip->num_rows;
            echo $toplamSip;
        }
    }