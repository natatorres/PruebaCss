<?php
namespace Punto5;

interface CalculadorComisionesInterface {
    /**
     * Calcula la comisión del vendedor en base a ventas, meta y comisión base.
     * @param float $ventas
     * @param float $meta
     * @param float $comisionBase
     * @return array ['porcentaje' => float, 'porcentaje_pago' => float, 'comision_final' => float]
     */
    public function calcular(float $ventas, float $meta, float $comisionBase): array;
}
