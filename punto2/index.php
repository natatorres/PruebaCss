<?php
// punto2/index.php
require_once __DIR__ . '/src/CalculadoraMatriz.php';

$matriz = [];
$resultado = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = $_POST['matriz'] ?? [];
    $matriz = [];

    // Validar y construir la matriz
    foreach ($datos as $fila) {
        $filaNumeros = array_map('intval', $fila);
        if (count($filaNumeros) !== 3) {
            $error = "Cada fila debe tener 3 valores.";
            break;
        }
        $matriz[] = $filaNumeros;
    }

    if (count($matriz) === 4) {
        $calculadora = new CalculadoraMatriz();
        $min = $calculadora->obtenerMinimo($matriz);
        $max = $calculadora->obtenerMaximo($matriz);
        $suma = $calculadora->sumar($min, $max);
        $resultado = [
            'min' => $min,
            'max' => $max,
            'suma' => $suma
        ];
    } else {
        $error = "Se requieren 4 filas de 3 números cada una.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Punto 2 - Matriz 3x4</title>
    <style>
        :root {
            --rojo-principal: #DC3545;
            --rojo-oscuro: #a22531;
            --rojo-claro: #f8d7da;
            --rojo-vibrante: #e63946;
            --blanco: #ffffff;
            --gris-claro: #f9f9f9;
            --gris-medio: #cccccc;
            --negro: #1a1a1a;
            --verde-exito: #28a745;
            --verde-claro: #d4edda;
            
            --sombra-suave: 0 4px 12px rgba(0, 0, 0, 0.08);
            --sombra-media: 0 8px 20px rgba(0, 0, 0, 0.12);
            --sombra-fuerte: 0 15px 30px rgba(0, 0, 0, 0.15);
            --sombra-roja: 0 8px 20px rgba(220, 53, 69, 0.25);
            
            --radio-medio: 12px;
            --espacio-md: 1rem;
            --espacio-lg: 1.5rem;
            --espacio-xl: 2rem;
            --espacio-xxl: 3rem;
            --espacio-sm: 0.5rem;
            --espacio-xs: 0.25rem;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--blanco), var(--gris-claro));
            color: var(--negro);
            padding: var(--espacio-md);
            min-height: 100vh;
            line-height: 1.6;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: var(--blanco);
            border-radius: var(--radio-medio);
            box-shadow: var(--sombra-fuerte);
            overflow: hidden;
            border: 1px solid var(--gris-medio);
        }

        .header {
            background: linear-gradient(135deg, var(--rojo-principal), var(--rojo-oscuro));
            color: var(--blanco);
            padding: var(--espacio-xl) var(--espacio-lg);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(circle at 70% 30%, rgba(255, 255, 255, 0.1), transparent 50%);
        }

        .header h1 {
            font-size: clamp(1.5rem, 4vw, 2.5rem);
            font-weight: 700;
            margin-bottom: var(--espacio-sm);
            position: relative;
            z-index: 1;
        }

        .header .icon {
            font-size: 3rem;
            margin-bottom: var(--espacio-sm);
            position: relative;
            z-index: 1;
        }

        .nav-link {
            position: absolute;
            top: var(--espacio-md);
            left: var(--espacio-md);
            background: rgba(255, 255, 255, 0.2);
            color: var(--blanco);
            text-decoration: none;
            padding: var(--espacio-sm) var(--espacio-md);
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            z-index: 2;
        }

        .nav-link:hover {
            background: var(--blanco);
            color: var(--rojo-principal);
            transform: translateY(-2px);
        }

        .content {
            padding: var(--espacio-xxl) var(--espacio-lg);
            background: var(--gris-claro);
        }

        .form-container {
            background: var(--blanco);
            border-radius: var(--radio-medio);
            padding: var(--espacio-xl);
            box-shadow: var(--sombra-suave);
            border: 2px solid var(--rojo-claro);
            margin-bottom: var(--espacio-lg);
        }

        .matriz-titulo {
            text-align: center;
            margin-bottom: var(--espacio-lg);
            color: var(--negro);
            font-weight: 600;
        }

        .matriz-container {
            display: flex;
            justify-content: center;
            margin-bottom: var(--espacio-xl);
        }

        .matriz-table {
            border-collapse: separate;
            border-spacing: var(--espacio-sm);
            background: var(--gris-claro);
            padding: var(--espacio-lg);
            border-radius: var(--radio-medio);
            box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .matriz-input {
            width: 80px;
            height: 60px;
            text-align: center;
            border: 2px solid var(--gris-medio);
            border-radius: var(--radio-medio);
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            background: var(--blanco);
            color: var(--negro);
        }

        .matriz-input:focus {
            outline: none;
            border-color: var(--rojo-principal);
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
            transform: scale(1.05);
        }

        .matriz-input:valid {
            border-color: var(--verde-exito);
        }

        .btn {
            background: linear-gradient(135deg, var(--rojo-principal), var(--rojo-oscuro));
            color: var(--blanco);
            border: none;
            padding: var(--espacio-md) var(--espacio-xl);
            border-radius: var(--radio-medio);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: var(--sombra-suave);
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
            display: block;
            margin: 0 auto;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s ease;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--sombra-roja);
        }

        .resultado-container {
            background: var(--blanco);
            border-radius: var(--radio-medio);
            padding: var(--espacio-xl);
            box-shadow: var(--sombra-media);
            animation: fadeInUp 0.5s ease;
        }

        .resultado-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--espacio-lg);
            margin-bottom: var(--espacio-lg);
        }

        .resultado-card {
            background: linear-gradient(135deg, var(--rojo-claro), var(--blanco));
            border: 2px solid var(--rojo-principal);
            border-radius: var(--radio-medio);
            padding: var(--espacio-lg);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .resultado-card:hover {
            transform: translateY(-4px);
        }

        .resultado-label {
            font-size: 0.9rem;
            color: var(--rojo-oscuro);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: var(--espacio-xs);
        }

        .resultado-valor {
            font-size: 2rem;
            font-weight: 700;
            color: var(--rojo-principal);
        }

        .suma-final {
            background: linear-gradient(135deg, var(--rojo-principal), var(--rojo-oscuro));
            color: var(--blanco);
            padding: var(--espacio-lg);
            border-radius: var(--radio-medio);
            text-align: center;
            margin-top: var(--espacio-lg);
        }

        .suma-final .resultado-valor {
            color: var(--blanco);
            font-size: 2.5rem;
        }

        .error {
            background: var(--rojo-claro);
            border: 2px solid var(--rojo-principal);
            color: var(--rojo-oscuro);
            padding: var(--espacio-md);
            border-radius: var(--radio-medio);
            text-align: center;
            font-weight: 600;
            animation: shake 0.5s ease;
        }

        .instrucciones {
            background: var(--gris-claro);
            border-left: 4px solid var(--rojo-principal);
            padding: var(--espacio-md);
            margin-bottom: var(--espacio-lg);
            border-radius: 0 var(--radio-medio) var(--radio-medio) 0;
        }

        .instrucciones-titulo {
            font-weight: 600;
            color: var(--rojo-principal);
            margin-bottom: var(--espacio-xs);
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        @media (max-width: 768px) {
            .content {
                padding: var(--espacio-lg) var(--espacio-md);
            }
            
            .form-container, .resultado-container {
                padding: var(--espacio-lg);
            }
            
            .matriz-input {
                width: 60px;
                height: 50px;
                font-size: 1rem;
            }
            
            .matriz-table {
                padding: var(--espacio-md);
            }
            
            .nav-link {
                position: relative;
                top: auto;
                left: auto;
                display: inline-block;
                margin-bottom: var(--espacio-md);
            }
            
            .header {
                text-align: left;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="../index.php" class="nav-link">← Volver al menú</a>
            <div class="icon">🧮</div>
            <h1>Punto 2: Matriz 3×4</h1>
        </div>

        <div class="content">
            <div class="form-container">
                <div class="instrucciones">
                    <div class="instrucciones-titulo">Instrucciones:</div>
                    <div>Ingresa 12 números enteros para formar una matriz de 4 filas por 3 columnas. El sistema calculará el mínimo, máximo y su suma.</div>
                </div>

                <form method="POST">
                    <div class="matriz-titulo">
                        <h3>Ingresa los valores de la matriz (4 filas × 3 columnas):</h3>
                    </div>
                    
                    <div class="matriz-container">
                        <table class="matriz-table">
                            <tbody>
                            <?php for ($i = 0; $i < 4; $i++): ?>
                                <tr>
                                    <?php for ($j = 0; $j < 3; $j++): ?>
                                        <td>
                                            <input type="number" 
                                                   name="matriz[<?= $i ?>][<?= $j ?>]"
                                                   class="matriz-input"
                                                   value="<?= htmlspecialchars($matriz[$i][$j] ?? '') ?>" 
                                                   required
                                                   placeholder="0">
                                        </td>
                                    <?php endfor; ?>
                                </tr>
                            <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <button type="submit" class="btn">Calcular Matriz</button>
                </form>
            </div>

            <?php if ($error): ?>
                <div class="error">❌ <?= $error ?></div>
            <?php endif; ?>

            <?php if ($resultado): ?>
                <div class="resultado-container">
                    <div class="resultado-grid">
                        <div class="resultado-card">
                            <div class="resultado-label">Valor Mínimo</div>
                            <div class="resultado-valor"><?= $resultado['min'] ?></div>
                        </div>
                        <div class="resultado-card">
                            <div class="resultado-label">Valor Máximo</div>
                            <div class="resultado-valor"><?= $resultado['max'] ?></div>
                        </div>
                    </div>
                    
                    <div class="suma-final">
                        <div class="resultado-label" style="color: var(--rojo-claro);">Suma Total</div>
                        <div class="resultado-valor"><?= $resultado['suma'] ?></div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>