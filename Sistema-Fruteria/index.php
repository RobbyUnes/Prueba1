<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frutería</title>
    <style>
        /* Estilos generales */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f9f9; /* Fondo suave, color claro */
            color: #333;
            text-align: center;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px;
        }

        /* Estilo para el logo */
        .logo {
            width: 200px;
            height: auto;
            margin-bottom: 30px;
        }

        /* Título principal */
        h1 {
            color: #27ae60; /* Verde fresco */
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* Estilo para el menú */
        .menu {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        /* Estilo para los botones del menú */
        .menu-button {
            background-color: #2ecc71; /* Verde brillante */
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 1.2rem;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
            width: 250px;
            text-align: center;
        }

        .menu-button:hover {
            background-color: #27ae60; /* Verde más oscuro al pasar el ratón */
            transform: scale(1.05); /* Efecto de aumento en el tamaño */
        }

        /* Estilo para el contenedor de la página */
        .container {
            background-color: #fff; /* Fondo blanco para el contenedor principal */
            border-radius: 12px;
            box-shadow: 0px 6px 16px rgba(0, 0, 0, 0.1); /* Sombra suave para el contenedor */
            padding: 40px;
            text-align: center;
            max-width: 900px;
            margin-top: 50px;
        }

        /* Enlaces */
        a {
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Logo del sistema -->
    <img src="imagenes/Logo.jpg" alt="Logo de la Frutería" class="logo">

    <!-- Título principal -->
    <h1>Bienvenidos a la Frutería</h1>

    <!-- Botones para las diferentes secciones -->
    <div class="menu">
        <a href="Clientes.php" class="menu-button">Lista de Clientes</a>
        <a href="mostrar-productos.php" class="menu-button">Lista de Productos</a>
        <a href="nueva-venta.php" class="menu-button">Nueva Venta</a>
        <a href="ventas.php" class="menu-button">Listado de Ventas</a>
        <a href="ofertas.php" class="menu-button">Lista de Ofertas</a>
    </div>
</div>

</body>
</html>
