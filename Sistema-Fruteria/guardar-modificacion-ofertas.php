<?php
include "conexion-BD.php";
$conn = conectarBD();

// Verificar si se enviaron los datos requeridos
if (isset($_POST['IdOfertas'], $_POST['Descuento'], $_POST['FechaInicio'], $_POST['FechaFin'], $_POST['Status'])) {
    $IdOfertas = intval($_POST['IdOfertas']);
    $descuento = floatval($_POST['Descuento']);
    $fechaInicio = $_POST['FechaInicio'];
    $fechaFin = $_POST['FechaFin'];
    $status = $_POST['Status'];

    // Actualizar la oferta en la base de datos
    $sql = "UPDATE ofertas 
            SET Descuento = ?, FechaInicio = ?, FechaFin = ?, Status = ? 
            WHERE IdOfertas = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("dsssi", $descuento, $fechaInicio, $fechaFin, $status, $IdOfertas);

    if ($stmt->execute()) {
        echo "<p>Oferta modificada correctamente.</p>";
    } else {
        echo "<p>Error al modificar la oferta: " . $conn->error . "</p>";
    }
} else {
    die("<p>Faltan datos necesarios para modificar la oferta.</p>");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar Modificación</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="button-container">
        <a href="ofertas.php" class="button">Volver a Lista de Ofertas</a>
    </div>
</body>
</html>

