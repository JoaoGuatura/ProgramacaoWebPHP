<?php

require_once __DIR__ . '/Usuario.php';

class CalculadoraImcMasculino extends CalculadoraImc {
    public function __construct(Usuario $usuario) {
        parent::__construct($usuario);
    }

    public function calcular(): float {

        return ($this->usuario->getPeso() * 0.9) / ($this->usuario->getAltura() * $this->usuario->getAltura());
    }
}