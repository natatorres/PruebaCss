<?php 
// punto3/index.php
require_once __DIR__ . '/src/ConsultaPrimerPartido.php';

$dsn = "pgsql:host=localhost;port=5432;dbname=torneo_futbol";
$user = "postgres";
$password = "Natalia057";

$resultados = [];
$error = null;



try {
    $pdo = new PDO($dsn, $user, $password);
    $consulta = new ConsultaPrimerPartido();
    $resultados = $consulta->obtenerResultados($pdo);
} catch (PDOException $e) {
    $error = "Error de conexión: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Punto 3 - Consulta Primer Partido</title>
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
        }

        .container {
            max-width: 1200px;
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
            background: radial-gradient(circle at 30% 50%, rgba(255, 255, 255, 0.1), transparent 50%);
            animation: floatingPattern 15s ease-in-out infinite;
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
            margin-bottom: var(--espacio-lg);
            box-shadow: var(--sombra-suave);
        }

        .back-link:hover {
            background: var(--rojo-principal);
            color: var(--blanco);
            border-color: var(--rojo-principal);
            transform: translateY(-2px);
            box-shadow: var(--sombra-media);
        }

        .table-container {
            background: var(--blanco);
            border-radius: var(--radio-medio);
            box-shadow: var(--sombra-media);
            overflow: hidden;
            border: 1px solid var(--gris-medio);
            margin-top: var(--espacio-lg);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95rem;
        }

        th, td {
            padding: var(--espacio-md);
            text-align: left;
            border-bottom: 1px solid var(--gris-medio);
        }

        th {
            background: linear-gradient(135deg, var(--rojo-principal), var(--rojo-oscuro));
            color: var(--blanco);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        tbody tr {
            transition: background-color 0.3s ease;
        }

        tbody tr:hover {
            background: var(--rojo-claro);
        }

        tbody tr:nth-child(even) {
            background: var(--gris-claro);
        }

        tbody tr:nth-child(even):hover {
            background: var(--rojo-claro);
        }

        .error {
            background: linear-gradient(135deg, #ff6b6b, #ee5a5a);
            color: var(--blanco);
            padding: var(--espacio-md);
            border-radius: var(--radio-medio);
            margin: var(--espacio-lg) 0;
            box-shadow: var(--sombra-media);
            font-weight: 500;
        }

        .no-results {
            text-align: center;
            padding: var(--espacio-xxl);
            color: var(--rojo-oscuro);
            font-size: 1.1rem;
            background: var(--blanco);
            border-radius: var(--radio-medio);
            box-shadow: var(--sombra-suave);
            margin-top: var(--espacio-lg);
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

            .table-container {
                overflow-x: auto;
            }

            table {
                min-width: 600px;
            }

            th, td {
                padding: var(--espacio-sm);
                font-size: 0.85rem;
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

            th, td {
                padding: var(--espacio-xs) var(--espacio-sm);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>⚽ Punto 3</h1>
            <p>Jugadores, Equipos y Fecha del Primer Partido</p>
        </div>

        <div class="content">
            <a href="../index.php" class="back-link">
                ← Volver al menú principal
            </a>

            <?php if ($error): ?>
                <div class="error">
                    <strong>Error:</strong> <?= htmlspecialchars($error) ?>
                </div>
            <?php elseif (count($resultados) === 0): ?>
                <div class="no-results">
                    <p>📊 No se encontraron resultados.</p>
                </div>
            <?php else: ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>👤 Jugador</th>
                                <th>🏆 Equipo</th>
                                <th>📅 Fecha del Primer Partido</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultados as $fila): ?>
                                <tr>
                                    <td><?= htmlspecialchars($fila['nombre_jugador']) ?></td>
                                    <td><?= htmlspecialchars($fila['nombre_equipo']) ?></td>
                                    <td><?= htmlspecialchars($fila['fecha_primer_partido']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <div class="footer">
            <p>💻 Punto 3 - Consulta Primer Partido • PHP • 2025</p>
        </div>
    </div>
</body>
</html>