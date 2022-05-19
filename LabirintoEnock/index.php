<?php

$linhas = 20;
$colunas = 20;



$config = array(
    'inicio' => array(1, 1), // Ponto de partida
    $rato = 'rato' => array(mt_rand(1, 20), (mt_rand(1, 20) == 0) ? mt_rand(2, 20) : mt_rand(1, 20)), // Posição do rato
    'x' => $linhas, // Números de linhas do labirinto
    'y' => $colunas, // Número de colunas do labirinto
    'num_obstaculos' => ($linhas*$colunas)*20/100, // Número de obstáculos
);

$ArrayRato = array(
            $rato);
//class AguardaRand extends Thread {
      
    
//    // Metodo principal da thread, que sera acionado quando chamarmos "start"
//    public function run() {
//        for($i = 0; $i < 5; $i++){
//            $ArrayRato = array(
//            $rato);

//            $thread->start();
//        }    
//    }

//    }  
    
    // Criar um vetor com 10 threads do mesmo tipo
    //$vetor = array();
    //for ($i = 0; $i < 10; $i++) {
    //  'rato' => array(mt_rand(1, 20), (mt_rand(1, 20) == 0) ? mt_rand(2, 20) : mt_rand(1, 20)));
    //}
    
    //// Iniciar a execucao das threads
    //foreach ($vetor as $thread) {
    //$thread->start();
    //}


$a = new aStar($config['inicio'], $config['rato'], $config['x'], $config['y'], $config['num_obstaculos']);
$a->exibirLabirinto();




/**
 * astar寻路算法
 */
class aStar
{

    private $_inicio; // Ponto inicial
    private $_rato; // Endponto
    private $_x; // Eixo x máximo
    private $_y; // Eixo y máximo
    private $_num; // número de pontos de obstáculos

    private $_emvolta; // matriz de nós ao redor
    private $_g; // array de valores de g

    public $aberto; // Array de nós abertos
    public $fechado; // Array de nós fechados
    public $obstaculos = array(); // Matriz de pontos de obstáculos gerada aleatoriamente

    public $rota = array(); // Matriz do caminho ao queijo

    /**
     * @param $inicio array
     * @param $rato array
     * @param $x int
     * @param $y int
     * @param $num int
     */
    public function __construct($inicio, $rato, $x, $y, $num)
    {
        $this->_inicio = $inicio;
        $this->_rato = $rato;
        $this->_x = $x;
        $this->_y = $y;
        $this->_num = $num;

        // Inicio do caminho
        $this->_rota();
    }

    private function _rota()
    {
        // Gerando pontos de barreira aleatórios
        $this->_gerarObstaculos();
        // inicio do algoritimo
        $this->_inicio();
    }

    private function _inicio()
    {
        // Definição do valor inicial
        $ponto[0] = $this->_inicio[0]; // x
        $ponto[1] = $this->_inicio[1]; // y
        $ponto['i'] = $this->_pontoInfo($this->_inicio); // Nó atual
        $ponto['f'] = 0; // Valor de f
        $this->_g[$ponto['i']] = 0; // Valor de g
        $ponto['h'] = $this->_getH($this->_inicio); // Valor da heurística
        $ponto['p'] = null; // Nó pai

        $this->aberto[$ponto['i']] = $this->fechado[$ponto['i']] = $ponto;
        while (count($this->aberto) > 0) {
            // Encontrar o menor valor f
            $f = 0;
            foreach ($this->aberto as $info => $no) {
                if ($f === 0 || $f > $no['f']) {
                    $minInfo = $info;
                    $f = $no['f'];
                }
            }

            // Remover o nó atual dos nós abertos
            $atual = $this->aberto[$minInfo];
            unset($this->aberto[$minInfo]);
            // Adicionar o nó atual aos nós fechados
            $this->fechado[$minInfo] = $atual;

            // Ao atingir o ponto final, calcular a rota com base no nó pai de cada nó
            if ($atual[0] == $this->_rato[0] && $atual[1] == $this->_rato[1]) {
                // Caminho inverso
                while ($atual['p'] !== null) {
                    $tmp = $this->fechado[$this->_pontoInfo($atual['p'])];
                    array_unshift($this->rota, array($tmp[0], $tmp[1]));
                    $atual = $this->fechado[$this->_pontoInfo($atual['p'])];
                }
                array_push($this->rota, $this->_rato);
                break;
            }

            // Definir o nó em torno do nó atual
            $this->_setEmVolta($atual);
            // Atualização do status do nó ao redor
            $this->_atualizarEmVolta($atual);
        }

    }

    private function _atualizarEmVolta($atual)
    {
        foreach ($this->_emvolta as $v) {
            if (!isset($this->fechado[$this->_pontoInfo($v)])) { // Aqui significa que não está perto
                if (isset($this->aberto[$this->_pontoInfo($v)])) { // Em aberto, comparar os valores e atualizar
                    if ($this->_getG($atual) < $this->_g[$this->_pontoInfo($v)]) {
                        $this->_atualizarDetalhesdoPonto($atual, $v);
                    }
                } else { // Atualização direta
                    $this->aberto[$this->_pontoInfo($v)][0] = $v[0];
                    $this->aberto[$this->_pontoInfo($v)][1] = $v[1];
                    $this->_atualizarDetalhesdoPonto($atual, $v);
                }
            }
        }
    }

    private function _atualizarDetalhesdoPonto($atual, $emvolta)
    {
        $this->aberto[$this->_pontoInfo($emvolta)]['f'] = $this->_getF($atual, $emvolta);
        $this->_g[$this->_pontoInfo($emvolta)] = $this->_getG($atual);
        $this->aberto[$this->_pontoInfo($emvolta)]['h'] = $this->_getH($emvolta);
        $this->aberto[$this->_pontoInfo($emvolta)]['p'] = $atual; // Redefinindo o nó pai
    }

    /**
     * Retorno dos nós ao redor
     */
    private function _setEmVolta($ponto)
    {
        // x
        $roundX[] = $ponto[0]; // Ponto x atual
        ($ponto[0] - 1 > 0) && $roundX[] = $ponto[0] - 1;
        ($ponto[0] + 1 <= $this->_x) && $roundX[] = $ponto[0] + 1;

        // y
        $roundY[] = $ponto[1];
        ($ponto[1] - 1 > 0) && $roundY[] = $ponto[1] - 1;
        ($ponto[1] + 1 <= $this->_y) && $roundY[] = $ponto[1] + 1;

        $this->_emvolta = array();
        foreach ($roundX as $vX) {
            foreach ($roundY as $vY) {
                $tmp = array(
                    0 => $vX,
                    1 => $vY,
                );

                if (
                    !in_array($tmp, $this->obstaculos) &&
                    !in_array($tmp, $this->fechado) &&
                    !($vX == $ponto[0] && $vY == $ponto[1]) &&
                    ($vX == $ponto[0] || $vY == $ponto[1])
                )
                    $this->_emvolta[] = $tmp;
            }
        }
    }

    /**
     * Retorna a chave do nó atual
     */
    private function _pontoInfo($ponto)
    {
        return $ponto[0] . '_' . $ponto[1];
    }

    /**
     * Cálculo do valor F = G + H
     */
    private function _getF($pai, $ponto)
    {
        return $this->_getG($pai) + $this->_getH($ponto);
    }

    /**
     * Cálculo do valor g
     */
    private function _getG($atual)
    {
        return isset($this->_g[$this->_pontoInfo($atual)]) ? $this->_g[$this->_pontoInfo($atual)] + 1 : 1;
    }

    /**
     * Cálculo do valor h
     */
    private function _getH($ponto)
    {
        return abs($ponto[0] - $this->_rato[0]) + abs($ponto[1] - $this->_rato[1]);
    }

    /**
     * Geração de obstáculos aleatórios
     */
    private function _gerarObstaculos()
    {
        if ($this->_num > $this->_x * $this->_y)
            exit('too many obstaculos ponto');

        for ($i = 0; $i < $this->_num; $i++) {
            $tmp = array(
                rand(1, $this->_x),
                rand(1, $this->_y),
            );
            if ($tmp == $this->_inicio || $tmp == $this->_rato || in_array($tmp, $this->obstaculos)) { // Definição de que os pontos de retorno não podem ser iguais ao pontos inicial e final e também não se repetem
                $i--;
                continue;
            }
            $this->obstaculos[] = $tmp;
        }
    }

    /**
     * Exibição do labirinto
     */
    public function exibirLabirinto()
    {
        header('content-type:text/html;charset=utf-8');
        echo 'De R (Rato) a Q (queijo), o fundo verde indica o caminho mais curto e o fundo preto indica obstáculos. <br /><br />';
        $step = count($this->rota);
        echo ($step > 0) ? '<font color="green">Total ' . $step . ' Passos</font>' : '<font color="red">Não é possível chegar</font>';
        echo '<table border="1">';
        for ($y = 1; $y <= $this->_y; $y++) {
            echo '<tr>';
            for ($x = 1; $x <= $this->_x; $x++) {
                $atual = array($x, $y);

                if (in_array($atual, $this->obstaculos))
                    $bg = 'bgcolor="#000"';
                elseif (in_array($atual, $this->rota)) // caminho mais curto
                    $bg = 'bgcolor="#5cb85c"';
                else
                    $bg = '';

                if ($atual == $this->_inicio)
                    $content = 'Q';
                elseif ($atual == $this->_rato)
                    $content = 'R';
                else
                    $content = '&nbsp;';

                echo '<td style="width:22px; height: 22px;" ' . $bg . '>' . $content . '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
    }

}
