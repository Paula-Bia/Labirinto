<?php

    class AguardaRand extends Thread {
    
    // ID da thread (usado para identificar a ordem que as threads terminaram)
    protected $id, $vlr;
    
    // Construtor que apenas atribui um ID para identificar a thread
    public function __construct($id, $vlr) { 
    $this->id = $id;
    $this->vlr = $vlr;
    }
    
    // Metodo principal da thread, que sera acionado quando chamarmos "start"
    public function run() {
        return resolve_labirinto()
    }

    }  
    
    // Criar um vetor com 10 threads do mesmo tipo
    $vetor = array();
    for ($id = 0; $id < 10; $id++) {
    $vetor[] = new AguardaRand($id,$vlr);
    }
    
    // Iniciar a execucao das threads
    foreach ($vetor as $thread) {
    $thread->start();
    }

    function resolve_labirinto($labirinto, $linhas, $colunas, $lInicio, $cInicio, $caminho){
        $lAtual = $lInicio;
        $cAtual = $cInicio;
        $fechado = array();


        while ($labirinto[0][$lAtual][$cAtual] !== "R") {

            $baixo = ($lAtual+1 < $linhas) ? $labirinto[1][$lAtual+1][$cAtual] : 5;
            $direita = ($cAtual+1 < $colunas) ? $labirinto[1][$lAtual][$cAtual+1] : 5;
            $cima = ($lAtual-1 >= 0) ? $labirinto[1][$lAtual-1][$cAtual] : 5;
            $esquerda = ($cAtual-1 >= 0) ? $labirinto[1][$lAtual][$cAtual-1] : 5;

            if ($lAtual+1 < $linhas && $labirinto[0][$lAtual+1][$cAtual] != 1 && !in_array(array($lAtual+1, $cAtual), $caminho) && min($baixo, $direita, $cima, $esquerda) === $baixo) {
                $lAtual++;
            }
            else if ($cAtual+1 < $colunas && $labirinto[0][$lAtual][$cAtual+1] != 1 && !in_array(array($lAtual, $cAtual+1), $caminho) && min($baixo, $direita, $cima, $esquerda) === $direita) {
                $cAtual++;
            }
            else if ($lAtual-1 >= 0 && $labirinto[0][$lAtual-1][$cAtual] != 1 && !in_array(array($lAtual-1, $cAtual), $caminho) && min($baixo, $direita, $cima, $esquerda) === $cima) {
                $lAtual--;
            }
            else if ($cAtual-1 >= 0 && $labirinto[0][$lAtual][$cAtual-1] != 1 && !in_array(array($lAtual, $cAtual-1), $caminho) && min($baixo, $direita, $cima, $esquerda) === $esquerda) {
                $cAtual--;
            }

            $caminho[] = [$lAtual, $cAtual];

        }

        $resolucao = $labirinto[0];
        foreach ($caminho as $c) {
            $resolucao[$c[0]][$c[1]] = 2;
        }
        
        return array($labirinto[0], $resolucao, $caminho);

    }
 
?>
