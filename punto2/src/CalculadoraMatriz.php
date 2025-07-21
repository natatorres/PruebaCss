<?php
// src/CalculadoraMatriz.php

require_once __DIR__ . '/MatrizOperaciones.php';

/**
 * Clase que implementa la lógica de operaciones sobre una matriz.
 * Aplica la interface para seguir el principio SOLID (D - Inversión de dependencias).
 */
class CalculadoraMatriz implements MatrizOperaciones {

    public function obtenerMinimo(array $matriz): int {
        return min(array_merge(...$matriz));
    }

    public function obtenerMaximo(array $matriz): int {
        return max(array_merge(...$matriz));
    }

    public function sumar(int $a, int $b): int {
        return $a + $b;
    }
}
