<?php
include "conexion-BD.php";
$conn = conectarBD();

// Verificar si se recibió el ID de la oferta
if (isset($_GET['id'])) {
    $IdOferta = intval($_GET['id']); // Asegurar que el ID sea un número entero

    // Obtener la información de la oferta y el producto relacionado
    $sql = "SELECT o.IdOfertas, o.Descuento, o.FechaInicio, o.FechaFin, o.Status, 
                   p.IdProducto, p.Nombre AS NombreProducto, p.Precio AS PrecioProducto
            FROM ofertas o
            INNER JOIN producto p ON o.IdProducto = p.IdProducto
            WHERE o.IdOfertas = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $IdOferta);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $oferta = $resultado->fetch_assoc();
    } else {
        die("No se encontró la oferta con el ID proporcionado.");
    }
} else {
    die("No se ha recibido el ID de la oferta.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Oferta</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <h1>Modificar Oferta</h1>

    <form action="guardar-modificacion-ofertas.php" method="post">
        <input type="hidden" name="IdOfertas" value="<?php echo $oferta['IdOfertas']; ?>">

        <label for="Nombre">Nombre del Producto</label>
        <input type="text" id="Nombre" value="<?php echo htmlspecialchars($oferta['NombreProducto'], ENT_QUOTES, 'UTF-8'); ?>" readonly>

        <label for="Precio">Precio Original</label>
        <input type="text" id="Precio" value="$<?php echo number_format($oferta['PrecioProducto'], 2); ?>" readonly>

        <label for="Descuento">Descuento (%)</label>
        <input type="number" id="Descuento" name="Descuento" value="<?php echo $oferta['Descuento']; ?>" min="0" max="100" required>

        <label for="FechaInicio">Fecha de Inicio</label>
        <input type="date" id="FechaInicio" name="FechaInicio" value="<?php echo $oferta['FechaInicio']; ?>" required>

        <label for="FechaFin">Fecha de Fin</label>
        <input type="date" id="FechaFin" name="FechaFin" value="<?php echo $oferta['FechaFin']; ?>" required>

        <label for="Status">Estado</label>
        <select id="Status" name="Status" required>
            <option value="1" <?php echo ($oferta['Status'] == '1') ? 'selected' : ''; ?>>Activo</option>
            <option value="0" <?php echo ($oferta['Status'] == '0') ? 'selected' : ''; ?>>Inactivo</option>
        </select>

        <input type="submit" value="Guardar Cambios">
    </form>

    <div class="button-container">
        <a href="ofertas.php" class="button">Cancelar</a>
    </div>
</body>
</html>
