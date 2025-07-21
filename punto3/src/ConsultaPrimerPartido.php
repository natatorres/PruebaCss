<?php
// punto3/src/ConsultaPrimerPartido.php

require_once __DIR__ . '/ConsultaPrimerPartidoInterface.php';

/**
 * Ejecuta la consulta para obtener nombre del jugador, equipo y fecha del primer partido.
 */
class ConsultaPrimerPartido implements ConsultaPrimerPartidoInterface {

    public function obtenerResultados(PDO $conexion): array {
        $sql = "
            SELECT 
              j.nombre AS nombre_jugador,
              e.nombre AS nombre_equipo,
              p.fecha_partido AS fecha_primer_partido
            FROM jugadores j
            JOIN equipos e ON j.fk_equipos = e.id_equipos
            JOIN partidos p ON (
                p.fk_equipo_local = e.id_equipos
                OR p.fk_equipo_visitante = e.id_equipos
            )
            WHERE p.fecha_partido = (
                SELECT MIN(fecha_partido) FROM partidos
            );
        ";

        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
