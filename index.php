<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Prueba Técnica</title>
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
      padding: var(--espacio-xxl) var(--espacio-xl);
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .header::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background:
        radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1), transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.05), transparent 50%);
      animation: floatingPattern 20s ease-in-out infinite;
    }

    .header h1 {
      font-size: clamp(2rem, 5vw, 3rem);
      font-weight: 700;
      background: linear-gradient(45deg, var(--blanco), var(--rojo-claro));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
      position: relative;
      z-index: 1;
    }

    .header p {
      font-size: clamp(1rem, 2.5vw, 1.2rem);
      color: var(--rojo-claro);
      opacity: 0.9;
      font-weight: 500;
      position: relative;
      z-index: 1;
    }

    .content {
      padding: var(--espacio-xxl) var(--espacio-xl);
      background: var(--gris-claro);
    }

    .menu-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: var(--espacio-lg);
      margin-top: var(--espacio-xl);
    }

    .menu-item {
      background: linear-gradient(135deg, var(--blanco), var(--gris-claro));
      border-radius: var(--radio-medio);
      padding: var(--espacio-lg);
      text-decoration: none;
      color: var(--negro);
      border: 2px solid var(--rojo-claro);
      box-shadow: var(--sombra-suave);
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      position: relative;
      overflow: hidden;
      animation: fadeInUp 0.8s ease forwards;
      transform: translateZ(0);
    }

    .menu-item::before {
      content: '';
      position: absolute;
      top: 0; left: -100%;
      width: 100%; height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
      transition: left 0.6s ease;
      z-index: 1;
    }

    .menu-item::after {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: linear-gradient(135deg, var(--rojo-principal), var(--rojo-oscuro));
      opacity: 0;
      transition: opacity 0.4s ease;
      z-index: 2;
    }

    .menu-item:hover::before {
      left: 100%;
    }

    .menu-item:hover::after {
      opacity: 0.95;
    }

    .menu-item:hover {
      transform: translateY(-8px) scale(1.02);
      box-shadow: var(--sombra-hover);
      border-color: var(--rojo-principal);
      color: var(--blanco);
    }

    .menu-item:hover .status-badge {
      background: var(--blanco);
      color: var(--rojo-principal);
      border-color: var(--blanco);
      transform: scale(1.1);
    }

    .menu-item:hover .item-icon,
    .menu-item:hover .item-title,
    .menu-item:hover .item-description {
      color: var(--blanco);
      z-index: 3;
      position: relative;
    }

    .menu-item:active {
      transform: translateY(-4px) scale(0.98);
    }

    .status-badge {
      position: absolute;
      top: var(--espacio-sm);
      right: var(--espacio-sm);
      background: var(--rojo-principal);
      color: var(--blanco);
      padding: var(--espacio-xs) var(--espacio-sm);
      border-radius: 20px;
      font-size: 0.7rem;
      font-weight: 700;
      text-transform: uppercase;
      border: 2px solid var(--rojo-principal);
      transition: all 0.3s ease;
      z-index: 3;
      position: relative;
      box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
    }

    .item-icon,
    .item-title,
    .item-description {
      text-align: center;
      display: block;
      transition: color 0.3s ease;
      position: relative;
      z-index: 3;
    }

    .item-icon {
      font-size: 2.5rem;
      margin-bottom: var(--espacio-sm);
      filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.1));
    }

    .item-title {
      font-weight: 700;
      font-size: 1.2rem;
      margin-bottom: var(--espacio-xs);
      text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
    }

    .item-description {
      font-size: 0.95rem;
      opacity: 0.85;
      line-height: 1.4;
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

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(40px) scale(0.9); }
      to { opacity: 1; transform: translateY(0) scale(1); }
    }

    @media (max-width: 768px) {
      .menu-grid {
        grid-template-columns: 1fr;
        gap: var(--espacio-md);
      }
      
      .menu-item {
        padding: var(--espacio-md);
      }
      
      .item-icon {
        font-size: 2rem;
      }
    }

    @media (prefers-reduced-motion: reduce) {
      .menu-item,
      .header::before {
        animation: none;
      }
      
      .menu-item {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>🚀 Prueba Técnica</h1>
      <p>Desarrollador Full Stack</p>
    </div>

    <div class="content">
      <div class="menu-grid">
        <a href="punto1/index.php" class="menu-item" tabindex="0">
          <span class="status-badge">Completado</span>
          <span class="item-icon">🔍</span>
          <span class="item-title">Punto 1</span>
          <span class="item-description">Verificar cadena con patrones específicos</span>
        </a>

        <a href="punto2/index.php" class="menu-item" tabindex="0">
          <span class="status-badge">Completado</span>
          <span class="item-icon">🧮</span>
          <span class="item-title">Punto 2 - Matriz 3x4</span>
          <span class="item-description">Calcular suma del mínimo y máximo</span>
        </a>

        <a href="punto3/index.php" class="menu-item" tabindex="0">
          <span class="status-badge">Completado</span>
          <span class="item-icon">⚽</span>
          <span class="item-title">Punto 3 - Consulta</span>
          <span class="item-description">Obtener información del primer partido</span>
        </a>

        <a href="punto4/index.php" class="menu-item" tabindex="0">
          <span class="status-badge">Completado</span>
          <span class="item-icon">📝</span>
          <span class="item-title">Punto 4 - Consulta</span>
          <span class="item-description">Equipos con más de 5 partidos visitantes</span>
        </a>

        <a href="punto5/index.php" class="menu-item" tabindex="0">
          <span class="status-badge">Completado</span>
          <span class="item-icon">🎯</span>
          <span class="item-title">Punto 5 - Comisiones</span>
          <span class="item-description">Calcular comisiones según meta/venta</span>
        </a>
      </div>
    </div>

    <div class="footer">
      <p>💻 Desarrollado con PHP • Evaluación Técnica • 2025</p>
    </div>
  </div>
</body>
</html>