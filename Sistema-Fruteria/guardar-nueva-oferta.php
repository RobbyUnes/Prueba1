<?php
include "conexion-BD.php";
$conn = conectarBD();

// Verificar si la conexión a la base de datos es válida
if (!$conn) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

// Verificar si se enviaron los datos requeridos
if (isset($_POST['IdProducto'], $_POST['Descuento'], $_POST['FechaInicio'], $_POST['FechaFin'], $_POST['Status'])) {
    $IdProducto = intval($_POST['IdProducto']);
    $descuento = floatval($_POST['Descuento']);
    $fechaInicio = $_POST['FechaInicio'];
    $fechaFin = $_POST['FechaFin'];
    $status = $_POST['Status'];

    // Insertar la nueva oferta en la base de datos
    $sql = "INSERT INTO ofertas (IdProducto, Descuento, FechaInicio, FechaFin, Status)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("idsss", $IdProducto, $descuento, $fechaInicio, $fechaFin, $status);

    if ($stmt->execute()) {
        $mensaje = "Oferta agregada correctamente.";
    } else {
        $mensaje = "Error al agregar la oferta: " . $conn->error;
    }
} else {
    $mensaje = "Faltan datos necesarios para agregar la oferta.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar Oferta</title>
    <link rel="stylesheet" href="css/estilos.css"> <!-- Enlace al CSS -->
</head>
<body>
    <h1>Resultado de la Operación</h1>
    <p><?php echo $mensaje; ?></p>

    <div class="button-container">
        <a href="ofertas.php" class="button">Volver a Lista de Ofertas</a>
        <a href="agregar-ofertas.php" class="button">Agregar Nueva Oferta</a>
    </div>
</body>
</html>
