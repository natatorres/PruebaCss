<?php
// src/MatrizOperaciones.php

/**
 * Interface que define las operaciones requeridas para trabajar con matrices numéricas.
 */
interface MatrizOperaciones {
    public function obtenerMinimo(array $matriz): int;
    public function obtenerMaximo(array $matriz): int;
    public function sumar(int $a, int $b): int;
}
