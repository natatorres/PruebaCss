<?php
// punto1/src/Verificador.php

require_once __DIR__ . '/VerificadorInterface.php';

/**
 * Clase que implementa la lógica de verificación de signos de interrogación entre números que suman 10.
 */
class Verificador implements VerificadorInterface {

    public function verificar(string $cadena): string {
        $length = strlen($cadena);
        $paresValidos = [];

        for ($i = 0; $i < $length; $i++) {
            if (ctype_digit($cadena[$i])) {
                $num1 = intval($cadena[$i]);

                for ($j = $i + 1; $j < $length; $j++) {
                    if (ctype_digit($cadena[$j])) {
                        $num2 = intval($cadena[$j]);

                        if ($num1 + $num2 === 10) {
                            $hayOtroNumero = false;
                            for ($k = $i + 1; $k < $j; $k++) {
                                if (ctype_digit($cadena[$k])) {
                                    $hayOtroNumero = true;
                                    break;
                                }
                            }

                            if (!$hayOtroNumero) {
                                $subcadena = substr($cadena, $i + 1, $j - $i - 1);
                                $signos = substr_count($subcadena, '?');

                                if ($signos === 3) {
                                    $paresValidos[] = true;
                                }
                            }
                        }

                        break;
                    }
                }
            }
        }

        return count($paresValidos) > 0 ? "true" : "false";
    }
}
