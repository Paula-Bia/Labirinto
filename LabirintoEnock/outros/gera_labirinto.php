<?php
    function gera_labirinto($linhas, $colunas){
        for ($i=0; $i < $linhas; $i++) {
            for ($j=0; $j < $colunas; $j++) {
                $labirinto[$i][$j] = 0;
            }
        }

        for ($i=0; $i < $linhas; $i++) {
            for ($j=0; $j < $colunas; $j++) {
                $lab[$i][$j] = mt_rand(1, 4);
            }
        }

        $labirinto[0][0] = "S";

        $i = 0;
        do {
            $laleatorio = mt_rand(0, $linhas-1);
            $caleatorio = ($laleatorio == 0) ? mt_rand(1, $colunas-1) : mt_rand(0, $colunas-1);
            $labirinto[$laleatorio][$caleatorio] = 1;
            $i++;
        } while ($i <= ($linhas*$colunas)*10/100);

        $poslinha = mt_rand(0, $linhas-1);
        $poscoluna = (mt_rand(0, $linhas-1) == 0) ? mt_rand(1, $colunas-1) : mt_rand(0, $colunas-1);

        $labirinto[$poslinha][$poscoluna] = "Q";





        // echo '<br />';
        // echo '<pre>';
        // print_r($distancias);
        // $fechado = array();
        // for ($i=1; $i <= (($linhas-1)*2); $i++) {
        //     $d = $distancias[$i-1][0];
        //     // echo '<br />';
        //     // echo '<pre>';
        //     // print_r($d);
        //
        //
        //     $distancias[$i] = array();
        //     // echo (in_array(array($d[0]-1,$d[1]), $fechado)) ? 'sim' : 'não';
        //     (in_array(array($d[0]+1,$d[1]), $fechado)) ? '' : array_push($distancias[$i],array($d[0]+1,$d[1]));
        //     (in_array(array($d[0]-1,$d[1]), $fechado)) ? '' : array_push($distancias[$i],array($d[0]-1,$d[1]));
        //     (in_array(array($d[0],$d[1]+1), $fechado)) ? '' : array_push($distancias[$i],array($d[0],$d[1]+1));
        //     (in_array(array($d[0],$d[1]-1), $fechado)) ? '' : array_push($distancias[$i],array($d[0],$d[1]-1));
        //
        //     array_push($fechado, array($d[0]+1,$d[1]), array($d[0]-1,$d[1]), array($d[0],$d[1]+1), array($d[0],$d[1]-1));
        //     // echo '<br />';
        //     // echo '<pre>';
        //     // print_r($fechado);
        //
        // }
        // $distancias = array(0 => array($poslinha,$poscoluna));
        // echo '<br />';
        // echo '<pre>';
        // print_r($distancias);


        // foreach ($distancias as $dis) {
        //     $lab[$dis[0]][$dis[1]] = $dis[2];
        // }

        // for ($i=0; $i < $linhas; $i++) {
        //     for ($j=0; $j < $colunas; $j++) {
        //         echo $lab[$i][$j];
        //     }
        //     echo "<br>";
        // }
        // echo "<br>";



        return array($labirinto, $lab);
    }
?>
