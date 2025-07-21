<?php
require_once __DIR__ . '/EquiposVisitantesFrecuentesInterface.php';

/**
 * Consulta los nombres de los equipos que han jugado más de 5 partidos como visitantes.
 */
class EquiposVisitantesFrecuentes implements EquiposVisitantesFrecuentesInterface {

    public function obtenerResultados(PDO $conexion): array {
        $sql = "
            SELECT 
                e.nombre AS nombre_equipo,
                COUNT(p.id_partidos) AS cantidad_partidos
            FROM partidos p
            JOIN equipos e ON p.fk_equipo_visitante = e.id_equipos
            GROUP BY e.id_equipos, e.nombre
            HAVING COUNT(p.id_partidos) > 5;
        ";

        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
