<?php
// punto5/index.php
require_once __DIR__ . '/src/CalculadorComisiones.php';
require_once __DIR__ . '/src/CalculadorComisionesInterface.php';

use Punto5\CalculadorComisiones;

$ventas = $_POST['ventas'] ?? '';
$meta = $_POST['meta'] ?? '';
$comisionBase = $_POST['comision_base'] ?? '';
$resultado = null;
$error = null;

// Comentado para evitar ejecución real
/*
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (is_numeric($ventas) && is_numeric($meta) && is_numeric($comisionBase)) {
        $calculadora = new CalculadorComisiones();
        $resultado = $calculadora->calcular($ventas, $meta, $comisionBase);
    } else {
        $error = "Por favor ingrese valores numéricos válidos.";
    }
}
*/

// Datos de ejemplo para demostración
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (is_numeric($ventas) && is_numeric($meta) && is_numeric($comisionBase)) {
        // Simulación del cálculo
        $porcentaje = ($ventas / $meta) * 100;
        
        if ($porcentaje >= 100) {
            $porcentaje_pago = 100;
        } elseif ($porcentaje >= 80) {
            $porcentaje_pago = 80;
        } elseif ($porcentaje >= 60) {
            $porcentaje_pago = 60;
        } else {
            $porcentaje_pago = 0;
        }
        
        $resultado = [
            'porcentaje' => round($porcentaje, 2),
            'porcentaje_pago' => $porcentaje_pago,
            'comision_final' => ($comisionBase * $porcentaje_pago) / 100
        ];
    } else {
        $error = "Por favor ingrese valores numéricos válidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Punto 5 - Cálculo de Comisiones</title>
    <style>
        :root {
            --sombra-suave: 0 4px 12px rgba(0, 0, 0, 0.08);
            --sombra-media: 0 8px 20px rgba(0, 0, 0, 0.12);
            --sombra-fuerte: 0 15px 30px rgba(0, 0, 0, 0.15);
            --sombra-roja: 0 8px 20px rgba(220, 53, 69, 0.25);
            --sombra-hover: 0 12px 25px rgba(220, 53, 69, 0.3);

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
        }

        .container {
            max-width: 1000px;
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
            padding: var(--espacio-xl);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(circle at 40% 60%, rgba(255, 255, 255, 0.1), transparent 50%);
            animation: floatingPattern 20s ease-in-out infinite;
        }

        .header h1 {
            font-size: clamp(1.8rem, 4vw, 2.5rem);
            font-weight: 700;
            background: linear-gradient(45deg, var(--blanco), var(--rojo-claro));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
            z-index: 1;
            margin-bottom: var(--espacio-sm);
        }

        .header p {
            font-size: 1.1rem;
            color: var(--rojo-claro);
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .content {
            padding: var(--espacio-xxl) var(--espacio-xl);
            background: var(--gris-claro);
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: var(--espacio-xs);
            color: var(--rojo-principal);
            text-decoration: none;
            font-weight: 600;
            padding: var(--espacio-sm) var(--espacio-md);
            border: 2px solid var(--rojo-claro);
            border-radius: var(--radio-medio);
            background: var(--blanco);
            transition: all 0.3s ease;
            margin-bottom: var(--espacio-xl);
            box-shadow: var(--sombra-suave);
        }

        .back-link:hover {
            background: var(--rojo-principal);
            color: var(--blanco);
            border-color: var(--rojo-principal);
            transform: translateY(-2px);
            box-shadow: var(--sombra-media);
        }

        .form-container {
            background: var(--blanco);
            border-radius: var(--radio-medio);
            box-shadow: var(--sombra-media);
            padding: var(--espacio-xxl);
            border: 1px solid var(--gris-medio);
            margin-bottom: var(--espacio-xl);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: var(--espacio-lg);
            margin-bottom: var(--espacio-xl);
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: 600;
            color: var(--negro);
            margin-bottom: var(--espacio-sm);
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: var(--espacio-xs);
        }

        .form-group input {
            padding: var(--espacio-md);
            border: 2px solid var(--gris-medio);
            border-radius: var(--radio-medio);
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.3s ease;
            background: var(--gris-claro);
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--rojo-principal);
            background: var(--blanco);
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
            transform: translateY(-2px);
        }

        .submit-btn {
            background: linear-gradient(135deg, var(--rojo-principal), var(--rojo-oscuro));
            color: var(--blanco);
            border: none;
            padding: var(--espacio-md) var(--espacio-xl);
            border-radius: var(--radio-medio);
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.4s ease;
            box-shadow: var(--sombra-media);
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.6s ease;
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: var(--sombra-hover);
            background: linear-gradient(135deg, var(--rojo-vibrante), var(--rojo-principal));
        }

        .submit-btn:active {
            transform: translateY(-1px);
        }

        .results-container {
            background: linear-gradient(135deg, var(--blanco), var(--gris-claro));
            border-radius: var(--radio-medio);
            box-shadow: var(--sombra-media);
            padding: var(--espacio-xxl);
            border: 2px solid var(--rojo-claro);
            margin-top: var(--espacio-xl);
        }

        .results-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--rojo-principal);
            margin-bottom: var(--espacio-lg);
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: var(--espacio-sm);
        }

        .results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--espacio-lg);
        }

        .result-card {
            background: var(--blanco);
            padding: var(--espacio-lg);
            border-radius: var(--radio-medio);
            text-align: center;
            box-shadow: var(--sombra-suave);
            border: 1px solid var(--gris-medio);
            transition: all 0.3s ease;
        }

        .result-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--sombra-roja);
        }

        .result-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--rojo-principal);
            display: block;
            margin-bottom: var(--espacio-xs);
        }

        .result-label {
            color: var(--negro);
            font-weight: 500;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .error {
            background: linear-gradient(135deg, #ff6b6b, #ee5a5a);
            color: var(--blanco);
            padding: var(--espacio-md) var(--espacio-lg);
            border-radius: var(--radio-medio);
            margin: var(--espacio-lg) 0;
            box-shadow: var(--sombra-media);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: var(--espacio-sm);
        }

        .commission-info {
            background: linear-gradient(135deg, var(--rojo-claro), rgba(220, 53, 69, 0.1));
            padding: var(--espacio-lg);
            border-radius: var(--radio-medio);
            margin-bottom: var(--espacio-lg);
            border-left: 4px solid var(--rojo-principal);
        }

        .commission-info h3 {
            color: var(--rojo-oscuro);
            margin-bottom: var(--espacio-sm);
            font-size: 1.1rem;
        }

        .commission-info ul {
            list-style: none;
            padding-left: 0;
        }

        .commission-info li {
            padding: var(--espacio-xs) 0;
            color: var(--negro);
            font-size: 0.9rem;
        }

        .commission-info li::before {
            content: '💰';
            margin-right: var(--espacio-xs);
        }

        .footer {
            text-align: center;
            padding: var(--espacio-xl);
            background: linear-gradient(135deg, var(--rojo-principal), var(--rojo-oscuro));
            color: var(--blanco);
            font-size: 0.9rem;
            border-top: 2px solid var(--rojo-claro);
            position: relative;
            overflow: hidden;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.05), transparent 70%);
        }

        .footer p {
            position: relative;
            z-index: 1;
        }

        @keyframes floatingPattern {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(1deg); }
        }

        @media (max-width: 768px) {
            .content {
                padding: var(--espacio-lg) var(--espacio-md);
            }

            .form-container {
                padding: var(--espacio-lg);
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: var(--espacio-md);
            }

            .results-grid {
                grid-template-columns: 1fr;
                gap: var(--espacio-md);
            }

            .result-value {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: var(--espacio-sm);
            }

            .header {
                padding: var(--espacio-lg) var(--espacio-md);
            }

            .content {
                padding: var(--espacio-md);
            }

            .form-container,
            .results-container {
                padding: var(--espacio-lg);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🎯 Punto 5</h1>
            <p>Cálculo de Comisiones del Vendedor</p>
        </div>

        <div class="content">
            <a href="../index.php" class="back-link">
                ← Volver al menú principal
            </a>

            <div class="commission-info">
                <h3>📋 Reglas de Comisión</h3>
                <ul>
                    <li>100% o más de la meta: 100% de la comisión base</li>
                    <li>80% a 99% de la meta: 80% de la comisión base</li>
                    <li>60% a 79% de la meta: 60% de la comisión base</li>
                    <li>Menos del 60%: Sin comisión</li>
                </ul>
            </div>

            <div class="form-container">
                <form method="POST">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="ventas">
                                💼 Ventas Realizadas
                            </label>
                            <input 
                                type="number" 
                                id="ventas" 
                                name="ventas" 
                                value="<?= htmlspecialchars($ventas) ?>"
                                step="0.01"
                                min="0"
                                placeholder="0.00"
                                required
                            >
                        </div>
                        
                        <div class="form-group">
                            <label for="meta">
                                🎯 Meta Mensual
                            </label>
                            <input 
                                type="number" 
                                id="meta" 
                                name="meta" 
                                value="<?= htmlspecialchars($meta) ?>"
                                step="0.01"
                                min="0.01"
                                placeholder="0.00"
                                required
                            >
                        </div>
                        
                        <div class="form-group">
                            <label for="comision_base">
                                💰 Comisión Base ($)
                            </label>
                            <input 
                                type="number" 
                                id="comision_base" 
                                name="comision_base" 
                                value="<?= htmlspecialchars($comisionBase) ?>"
                                step="0.01"
                                min="0"
                                placeholder="0.00"
                                required
                            >
                        </div>
                    </div>
                    
                    <div style="text-align: center;">
                        <button type="submit" class="submit-btn">
                            🧮 Calcular Comisión
                        </button>
                    </div>
                </form>
            </div>

            <?php if ($error): ?>
                <div class="error">
                    ⚠️ <strong>Error:</strong> <?= htmlspecialchars($error) ?>
                </div>
            <?php elseif ($resultado !== null): ?>
                <div class="results-container">
                    <h3 class="results-title">
                        📊 Resultados del Cálculo
                    </h3>
                    
                    <div class="results-grid">
                        <div class="result-card">
                            <span class="result-value"><?= $resultado['porcentaje'] ?>%</span>
                            <span class="result-label">Cumplimiento de Meta</span>
                        </div>
                        
                        <div class="result-card">
                            <span class="result-value"><?= $resultado['porcentaje_pago'] ?>%</span>
                            <span class="result-label">% Aplicado a Comisión</span>
                        </div>
                        
                        <div class="result-card">
                            <span class="result-value">$<?= number_format($resultado['comision_final'], 2) ?></span>
                            <span class="result-label">Comisión Final</span>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="footer">
            <p>💻 Punto 5 - Cálculo de Comisiones • PHP • 2025</p>
        </div>
    </div>
</body>
</html>rojo-principal: #DC3545;
            --rojo-oscuro: #a22531;
            --rojo-claro: #f8d7da;
            --rojo-vibrante: #e63946;

            --blanco: #ffffff;
            --gris-claro: #f9f9f9;
            --gris-medio: #cccccc;
            --negro: #1a1a1a;

            --