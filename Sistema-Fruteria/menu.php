<header>
    <h1>Nueva Venta</h1>
    <nav>
        <a href="index.php">Inicio</a>
        <a href="nueva-venta.php">Ventas</a>
        <a href="mostrar-productos.php">Productos</a>
        <a href="ofertas.php">Ofertas del Mes</a>
        <a href="ventas.php">Reportes</a>
    </nav>
</header>
<style>
    header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background-color: #003366;
        color: white;
        padding: 15px 20px;
        text-align: center;
        z-index: 1000; /* Asegura que esté encima de otros elementos */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra para destacar */
    }

    header h1 {
        margin: 0;
        font-size: 32px;
    }

    header nav {
        margin-top: 10px;
    }

    header nav a {
        color: white;
        text-decoration: none;
        margin: 0 15px;
        font-size: 18px;
    }

    header nav a:hover {
        text-decoration: underline;
    }

    /* Espaciado para que el contenido no quede debajo del header */
    body {
        margin-top: 100px; /* Ajusta este valor al alto del header */
    }
</style>
