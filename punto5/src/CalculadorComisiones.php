<?php
namespace Punto5;

require_once __DIR__ . '/CalculadorComisionesInterface.php';

class CalculadorComisiones implements CalculadorComisionesInterface {

    public function calcular(float $ventas, float $meta, float $comisionBase): array {
        if ($meta <= 0) return [
            'porcentaje' => 0,
            'porcentaje_pago' => 0,
            'comision_final' => 0,
        ];

        $porcentaje = ($ventas / $meta) * 100;
        $porcentajePago = $this->determinarPorcentajePago($porcentaje);
        $comisionFinal = ($comisionBase * $porcentajePago) / 100;

        return [
            'porcentaje' => round($porcentaje, 2),
            'porcentaje_pago' => $porcentajePago,
            'comision_final' => round($comisionFinal, 2)
        ];
    }

    private function determinarPorcentajePago(float $porcentaje): float {
        if ($porcentaje >= 149) return 104;
        if ($porcentaje >= 130) return 103;
        if ($porcentaje >= 125) return 102;
        if ($porcentaje >= 120) return 102;
        return min($porcentaje, 100);
    }
}
