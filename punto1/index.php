<?php 
// punto1/index.php
require_once __DIR__ . '/src/Verificador.php';

$verificador = new Verificador();
$resultado = null;
$entrada = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entrada = trim($_POST['cadena'] ?? '');
    $resultado = $verificador->verificar($entrada);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Punto 1 - Verificador</title>
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
            max-width: 800px;
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
            background: radial-gradient(circle at 30% 40%, rgba(255, 255, 255, 0.1), transparent 50%);
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

        .form-group {
            margin-bottom: var(--espacio-lg);
        }

        .form-label {
            display: block;
            margin-bottom: var(--espacio-sm);
            font-weight: 600;
            color: var(--negro);
            font-size: 1rem;
        }

        .form-input {
            width: 100%;
            padding: var(--espacio-md);
            border: 2px solid var(--gris-medio);
            border-radius: var(--radio-medio);
            font-size: 1rem;
            font-family: 'Courier New', monospace;
            transition: all 0.3s ease;
            background: var(--gris-claro);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--rojo-principal);
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
            background: var(--blanco);
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

        .btn:active {
            transform: translateY(0);
        }

        .resultado-container {
            background: var(--blanco);
            border-radius: var(--radio-medio);
            padding: var(--espacio-xl);
            box-shadow: var(--sombra-media);
            text-align: center;
            animation: fadeInUp 0.5s ease;
        }

        .resultado {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: var(--espacio-md);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: var(--espacio-sm);
        }

        .resultado.true {
            color: var(--verde-exito);
            border: 3px solid var(--verde-claro);
            background: var(--verde-claro);
            border-radius: var(--radio-medio);
            padding: var(--espacio-md);
        }

        .resultado.false {
            color: var(--rojo-principal);
            border: 3px solid var(--rojo-claro);
            background: var(--rojo-claro);
            border-radius: var(--radio-medio);
            padding: var(--espacio-md);
        }

        .ejemplo {
            background: var(--gris-claro);
            border-left: 4px solid var(--rojo-principal);
            padding: var(--espacio-md);
            margin-top: var(--espacio-md);
            border-radius: 0 var(--radio-medio) var(--radio-medio) 0;
        }

        .ejemplo-titulo {
            font-weight: 600;
            color: var(--rojo-principal);
            margin-bottom: var(--espacio-xs);
        }

        .ejemplo-texto {
            font-family: 'Courier New', monospace;
            color: var(--negro);
            font-size: 0.9rem;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .content {
                padding: var(--espacio-lg) var(--espacio-md);
            }
            
            .form-container, .resultado-container {
                padding: var(--espacio-lg);
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
            <div class="icon">🔍</div>
            <h1>Punto 1: Verificador de Cadenas</h1>
        </div>

        <div class="content">
            <div class="form-container">
                <form method="POST">
                    <div class="form-group">
                        <label for="cadena" class="form-label">
                            Ingresa la cadena a verificar:
                        </label>
                        <input type="text" 
                               id="cadena"
                               name="cadena" 
                               class="form-input"
                               placeholder="Ej: acc?7??sss?3rr1??????5" 
                               required
                               value="<?= htmlspecialchars($entrada) ?>">
                    </div>
                    <button type="submit" class="btn">Verificar Cadena</button>
                </form>
                
                <div class="ejemplo">
                    <div class="ejemplo-titulo">Criterio de verificación:</div>
                    <div class="ejemplo-texto">
                        Busca 3 signos de interrogación consecutivos (???) entre dos números que sumen exactamente 10.
                    </div>
                </div>
            </div>

            <?php if ($resultado !== null): ?>
                <div class="resultado-container">
                    <div class="resultado <?= $resultado === 'true' ? 'true' : 'false' ?>">
                        <?php if ($resultado === 'true'): ?>
                            ✅ TRUE - ¡Patrón encontrado!
                        <?php else: ?>
                            ❌ FALSE - Patrón no encontrado
                        <?php endif; ?>
                    </div>
                    <p style="color: var(--gris-medio); font-size: 0.9rem;">
                        Cadena analizada: <code style="background: var(--gris-claro); padding: 0.2rem 0.5rem; border-radius: 4px;"><?= htmlspecialchars($entrada) ?></code>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>