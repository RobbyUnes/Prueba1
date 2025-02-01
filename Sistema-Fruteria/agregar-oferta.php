<?php
include "conexion-BD.php";
$conn = conectarBD();

// Verificar si la conexión a la base de datos es válida
if (!$conn) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

// Obtener la lista de productos activos
$sqlProductos = "SELECT IdProducto, Nombre FROM producto WHERE Status = '1'";
$resultadoProductos = mysqli_query($conn, $sqlProductos);

if (!$resultadoProductos) {
    die("Error al obtener los productos: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Oferta</title>
    <link rel="stylesheet" href="css/estilos.css"> <!-- Llama al archivo CSS -->
</head>
<body>
     <?php include "menu.php"; ?>
    <h1>Agregar Nueva Oferta</h1>

    <form action="guardar-nueva-oferta.php" method="post">
        <label for="IdProducto">Producto</label>
        <select id="IdProducto" name="IdProducto" required>
            <option value="">Seleccione un producto</option>
            <?php while ($producto = mysqli_fetch_assoc($resultadoProductos)): ?>
                <option value="<?php echo $producto['IdProducto']; ?>">
                    <?php echo htmlspecialchars($producto['Nombre'], ENT_QUOTES, 'UTF-8'); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="Descuento">Descuento (%)</label>
        <input type="number" id="Descuento" name="Descuento" min="0" max="100" required>

        <label for="FechaInicio">Fecha de Inicio</label>
        <input type="date" id="FechaInicio" name="FechaInicio" required>

        <label for="FechaFin">Fecha de Fin</label>
        <input type="date" id="FechaFin" name="FechaFin" required>

        <label for="Status">Estado</label>
        <select id="Status" name="Status" required>
            <option value="1">Activo</option>
            <option value="0">Inactivo</option>
        </select>

        <input type="submit" value="Agregar Oferta">
    </form>

    <div class="button-container">
        <a href="ofertas.php" class="button">Volver a Lista de Ofertas</a>
        <a href="index.php" class="button">Inicio</a>
    </div>
</body>
</html>
