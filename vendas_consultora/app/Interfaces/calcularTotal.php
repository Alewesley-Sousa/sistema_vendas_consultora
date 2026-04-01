<?php

namespace App\Interfaces;

class calcularTotal implements calcularInterface
{
    private $valores;
    
    public function __construct($arrayComValores) {
        $this->valores = $arrayComValores;
    }
    
    public function calcular()
    {
        // Importante: use $this->valores, pois $arrayComValores só existe no construtor
        return array_sum($this->valores);
    }

    public static function calcularSoma($array) {
        return array_sum($array);
    }
}
