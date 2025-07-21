<?php
// punto3/src/ConsultaPrimerPartidoInterface.php

interface ConsultaPrimerPartidoInterface {
    public function obtenerResultados(PDO $conexion): array;
}
