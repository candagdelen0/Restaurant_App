<?php
    include "functions/function-manage.php";
    $yonetim = new Yonetim;

    function excelal ($filename = 'ExportExcel', $columns=array(),$columns2=array(),$data=array(),$data2=array(),$virgulnerede=array(),$veri1,$veri2) {
        header('Content-Encoding: UTF-8');
        header('Content-Type: text/plain; charset=utf-8');
        header('Content-disposition: attachment; filename='.$filename.'.xls');
        echo "\xEF\xBB\xBF"; 
        @$tarih1 = $_GET["tar1"];
        @$tarih2 = $_GET["tar2"];
        $sayim = count($columns);
        echo '<table border = "1">
            <th style="background-color:#000000" colspan="3">
                <font color="#FDFDFD">'.$tarih1.' - '.$tarih2.'</font>
            </th>
            <tr>';
                foreach ($columns as $v):
                    echo '<th style="background-color:#FFA500">'.trim($v).'</th>';
                endforeach;
            echo '</tr>';
            foreach ($data as $val):
                echo '<tr>';
                    for ($i=0; $i<$sayim; $i++):
                        if(in_array($i, $virgulnerede)):
                            echo '<td>'.str_replace('.',',',$val[$i]).'</td>';
                        else:
                            echo '<td>'.$val[$i].'</td>';
                        endif;
                    endfor;
                echo '</tr>';
            endforeach;
            echo '<tr>
                <td style="background-color:#56d2ec">TOPLAM</td>
                <td style="background-color:#56d2ec">'.$veri1.'</td>
                <td style="background-color:#56d2ec">'.$veri2.'</td>
            </tr>';
        
            $sayim2 = count($columns2);
            echo '<tr>';
                foreach ($columns2 as $v):
                    echo '<th style="background-color:#FFA500">'.trim($v).'</th>';
                endforeach;
            echo '</tr>';
            foreach ($data2 as $val2):
                echo '<tr>';
                    for ($i=0; $i<$sayim2; $i++):
                        if(in_array($i, $virgulnerede)):
                            echo '<td>'. str_replace('.',',',$val2[$i]).'</td>';
                        else:
                            echo '<td>'.$val2[$i].'</td>';
                        endif;
                    endfor;
                echo '</tr>';
            endforeach;  
        echo '</table>';
    }


?>





