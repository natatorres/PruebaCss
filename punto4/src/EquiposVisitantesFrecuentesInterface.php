<?php
// Interface para cumplir con principio SOLID (ISP)
interface EquiposVisitantesFrecuentesInterface {
    public function obtenerResultados(PDO $conexion): array;
}
