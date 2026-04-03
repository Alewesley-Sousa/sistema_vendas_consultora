<?php

namespace App\Interfaces;

class calcularSubtotal implements calcularInterface
{
    private $quantidade;
    private $precoUnitario;
    
    public function __construct($quantidade, $precoUnitario) {
        $this->quantidade = $quantidade;
        $this->precoUnitario = $precoUnitario;
    }
    
    public function calcular()
    {
        return $this->quantidade * $this->precoUnitario;
    }

    // Método estático para facilitar a chamada que você fez no Service
    public static function calcularValor($qnt, $preco) {
        return $qnt * $preco;
    }
}