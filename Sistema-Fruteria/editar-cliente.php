<?php
// Conexión a la base de datos
include "conexion-BD.php"; 
$conn = conectarBD();

// Validar que se haya recibido el parámetro `cliente`
if (!isset($_GET['cliente']) || !is_numeric($_GET['cliente']) || $_GET['cliente'] <= 0) {
    die("Error: No se ha recibido un ID de cliente válido.");
}

// Obtener el ID del cliente
$IdCliente = intval($_GET['cliente']);

// Consulta SQL para obtener los datos del cliente
$sql = "SELECT IdCliente, Nombre, Direccion, Telefono, Status FROM cliente WHERE IdCliente = $IdCliente";
$resultado = mysqli_query($conn, $sql);

if ($resultado && mysqli_num_rows($resultado) > 0) {
    // Obtener los datos del cliente
    $infoCliente = mysqli_fetch_assoc($resultado);
    $nombreCliente = $infoCliente['Nombre'];
    $direccionCliente = $infoCliente['Direccion'];
    $telefonoCliente = $infoCliente['Telefono'];
    $statusCliente = $infoCliente['Status'];
} else {
    die("Error: No se encontró el cliente con el ID especificado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
</head>
<body>

<h1>Editar Cliente</h1>

<form action="guardar-modificacion-cliente.php" method="post">
    <input type="hidden" name="IdCliente" value="<?php echo $IdCliente; ?>">

    <label for="Nombre">Nombre</label>
    <input type="text" id="Nombre" name="Nombre" value="<?php echo htmlspecialchars($nombreCliente); ?>" required>

    <label for="Direccion">Dirección</label>
    <input type="text" id="Direccion" name="Direccion" value="<?php echo htmlspecialchars($direccionCliente); ?>" required>

    <label for="Telefono">Teléfono</label>
    <input type="text" id="Telefono" name="Telefono" value="<?php echo htmlspecialchars($telefonoCliente); ?>" required>

    <label for="Status">Estado</label>
    <select id="Status" name="Status">
        <option value="1" <?php echo ($statusCliente == 1) ? "selected" : ""; ?>>Activo</option>
        <option value="0" <?php echo ($statusCliente == 0) ? "selected" : ""; ?>>Inactivo</option>
    </select>

    <button type="submit">Guardar Cambios</button>
</form>

</body>
</html>
