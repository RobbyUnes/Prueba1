<?php
// Incluir archivo de conexión a la base de datos
include "conexion-BD.php"; 
$conn = conectarBD(); // Establecer la conexión a la base de datos

// Verificar si la conexión es válida
if (!$conn) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Inicializar la variable $filtroProducto
$filtroProducto = isset($_GET['producto']) ? mysqli_real_escape_string($conn, $_GET['producto']) : '';

// Consulta SQL para obtener las ventas
$sql = "SELECT ventas.IdVentas, producto.Nombre AS Producto, ventas.NombreMetodo, ventas.Precio, ventas.Cantidad, ventas.Fecha, ventas.Status
        FROM ventas
        INNER JOIN producto ON ventas.IdProducto = producto.IdProducto
        WHERE ventas.Status = 1"; // Filtrar solo las ventas activas

// Aplicar el filtro por producto si se ha especificado
if (!empty($filtroProducto)) {
    $sql .= " AND producto.Nombre LIKE '%$filtroProducto%'";
}

$resultado = mysqli_query($conn, $sql); // Ejecutar la consulta

// Verificar si la consulta fue exitosa
if (!$resultado) {
    die("Error en la consulta SQL: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Ventas</title>
    <link rel="stylesheet" href="css/estilos.css"> <!-- Enlace al archivo CSS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
</head>
<body>
    <?php include "menu.php"; ?>

    <h1>Lista de Ventas</h1>

    <!-- Formulario para filtrar por producto -->
    <form method="GET" action="">
        <label for="producto">Filtrar por Producto:</label>
        <input type="text" id="producto" name="producto" class="autocomplete" value="<?php echo htmlspecialchars($filtroProducto); ?>" placeholder="Escribe el nombre del producto">
        <input type="submit" value="Filtrar">
    </form>

    <!-- Tabla para mostrar las ventas -->
    <table>
        <tr>
            <th>ID Venta</th>
            <th>Producto</th>
            <th>Método de Pago</th>
            <th>Precio Unitario</th>
            <th>Cantidad</th>
            <th>Fecha</th>
            <th>Estado</th>
        </tr>
        <?php 
        // Iterar sobre los resultados de la consulta
        while ($fila = mysqli_fetch_assoc($resultado)) { ?>
            <tr>
                <td><?php echo $fila['IdVentas']; ?></td> <!-- Mostrar ID de la venta -->
                <td><?php echo $fila['Producto']; ?></td> <!-- Mostrar nombre del producto -->
                <td><?php echo $fila['NombreMetodo']; ?></td> <!-- Mostrar método de pago -->
                <td>$<?php echo number_format($fila['Precio'], 2); ?></td> <!-- Mostrar precio -->
                <td><?php echo $fila['Cantidad']; ?></td> <!-- Mostrar cantidad -->
                <td><?php echo $fila['Fecha']; ?></td> <!-- Mostrar fecha -->
                <td><?php echo $fila['Status'] == 1 ? "Activo" : "Inactivo"; ?></td> <!-- Mostrar estado -->
            </tr>
        <?php } ?>
    </table>

    <!-- Botones de acciones adicionales -->
    <a href="nueva-venta.php" class="add-button">Registrar Nueva Venta</a>
    <a href="ventas-diaria.php" class="add-button">Ver Ventas Diarias</a>
    <a href="index.php" class="add-button">Inicio</a>

    <!-- Script para el autocompletar -->
    <script>
        $(document).ready(function () {
            $("#producto").autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "buscar-productos.php",
                        method: "GET",
                        data: { term: request.term },
                        success: function (data) {
                            response(JSON.parse(data).map(item => item.Nombre));
                        }
                    });
                },
                minLength: 2
            });
        });
    </script>
</body>
</html>
