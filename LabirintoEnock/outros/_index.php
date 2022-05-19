<?php
    require_once('gera_labirinto.php');
    require_once('resolve_labirinto.php');

    $linhas_labirinto = 4;
    $colunas_labirinto = 4;
    $caminho[] = array(0,0);

    $labirinto = gera_labirinto($linhas_labirinto, $colunas_labirinto);

    var_dump($labirinto); die;
    $resolucao = resolve_labirinto($labirinto, $linhas_labirinto, $colunas_labirinto, 0, 0, $caminho);

    for ($i=0; $i < $linhas_labirinto; $i++) {
        for ($j=0; $j < $colunas_labirinto; $j++) {
            echo $labirinto[1][$i][$j];
        }
        echo "<br>";
    }

    echo "<br>";
    echo "<br>";

    for ($i=0; $i < $linhas_labirinto; $i++) {
        for ($j=0; $j < $colunas_labirinto; $j++) {
            echo $resolucao[0][$i][$j];
        }
        echo "<br>";
    }

    echo "<br>";
    echo "<br>";

    for ($i=0; $i < $linhas_labirinto; $i++) {
        for ($j=0; $j < $colunas_labirinto; $j++) {
            echo $resolucao[1][$i][$j];
        }
        echo "<br>";
    }
   

?>
