<?php 
// punto4/index.php
require_once __DIR__ . '/src/EquiposVisitantesFrecuentes.php';

$dsn = "pgsql:host=localhost;port=5432;dbname=torneo_futbol";
$user = "postgres";
$password = "Natalia057";

$resultados = [];
$error = null;


try {
    $pdo = new PDO($dsn, $user, $password);
    $consulta = new EquiposVisitantesFrecuentes();
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
    <title>Punto 4 - Equipos Visitantes Frecuentes</title>
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
            background: radial-gradient(circle at 70% 30%, rgba(255, 255, 255, 0.1), transparent 50%);
            animation: floatingPattern 18s ease-in-out infinite;
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

        .stats-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--espacio-lg);
            margin-bottom: var(--espacio-xl);
        }

        .stat-card {
            background: linear-gradient(135deg, var(--blanco), var(--gris-claro));
            padding: var(--espacio-lg);
            border-radius: var(--radio-medio);
            text-align: center;
            box-shadow: var(--sombra-media);
            border: 2px solid var(--rojo-claro);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--sombra-roja);
            border-color: var(--rojo-principal);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--rojo-principal);
            display: block;
            margin-bottom: var(--espacio-xs);
        }

        .stat-label {
            color: var(--negro);
            font-weight: 500;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-container {
            background: var(--blanco);
            border-radius: var(--radio-medio);
            box-shadow: var(--sombra-media);
            overflow: hidden;
            border: 1px solid var(--gris-medio);
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
            transition: all 0.3s ease;
        }

        tbody tr:hover {
            background: var(--rojo-claro);
            transform: scale(1.01);
        }

        tbody tr:nth-child(even) {
            background: var(--gris-claro);
        }

        tbody tr:nth-child(even):hover {
            background: var(--rojo-claro);
        }

        .quantity-badge {
            background: linear-gradient(135deg, var(--rojo-principal), var(--rojo-oscuro));
            color: var(--blanco);
            padding: var(--espacio-xs) var(--espacio-sm);
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.85rem;
            display: inline-block;
            min-width: 40px;
            text-align: center;
            box-shadow: var(--sombra-suave);
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

            .stats-summary {
                grid-template-columns: 1fr;
                gap: var(--espacio-md);
            }

            .table-container {
                overflow-x: auto;
            }

            table {
                min-width: 400px;
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

            .stat-number {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>📝 Punto 4</h1>
            <p>Equipos con más de 5 partidos como visitante</p>
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
                    <p>🏟️ No hay equipos que hayan jugado más de 5 partidos como visitante.</p>
                </div>
            <?php else: ?>
                <div class="stats-summary">
                    <div class="stat-card">
                        <span class="stat-number"><?= count($resultados) ?></span>
                        <span class="stat-label">Equipos Encontrados</span>
                    </div>
                    <div class="stat-card">
                        <span class="stat-number"><?= array_sum(array_column($resultados, 'cantidad_partidos')) ?></span>
                        <span class="stat-label">Total Partidos</span>
                    </div>
                    <div class="stat-card">
                        <span class="stat-number"><?= max(array_column($resultados, 'cantidad_partidos')) ?></span>
                        <span class="stat-label">Máximo por Equipo</span>
                    </div>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>🏆 Equipo</th>
                                <th>📊 Partidos como Visitante</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultados as $fila): ?>
                                <tr>
                                    <td><?= htmlspecialchars($fila['nombre_equipo']) ?></td>
                                    <td>
                                        <span class="quantity-badge">
                                            <?= $fila['cantidad_partidos'] ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <div class="footer">
            <p>💻 Punto 4 - Equipos Visitantes • PHP • 2025</p>
        </div>
    </div>
</body>
</html>