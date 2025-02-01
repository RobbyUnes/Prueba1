<?php
// Incluir archivo de conexión a la base de datos
include "conexion-BD.php"; 
$conn = conectarBD(); // Establecer la conexión a la base de datos

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar que todos los campos requeridos estén presentes
    if (isset($_POST['Nombre'], $_POST['Direccion'], $_POST['Telefono'], $_POST['Status'])) {
        // Recibir los datos del formulario
        $nombreCliente = mysqli_real_escape_string($conn, $_POST['Nombre']); // Escapar texto
        $direccionCliente = mysqli_real_escape_string($conn, $_POST['Direccion']); // Escapar texto
        $telefonoCliente = mysqli_real_escape_string($conn, $_POST['Telefono']); // Escapar texto
        $statusCliente = intval($_POST['Status']); // Convertir el estado a un entero (1 o 0)

        // Consulta SQL para insertar el nuevo cliente en la base de datos
        $sql = "INSERT INTO cliente (Nombre, Direccion, Telefono, Status) 
                VALUES ('$nombreCliente', '$direccionCliente', '$telefonoCliente', $statusCliente)";

        // Ejecutar la consulta y verificar si fue exitosa
        if (mysqli_query($conn, $sql)) {
            // Redirigir a la lista de clientes con un mensaje de éxito
            header("Location: Clientes.php?mensaje=Cliente agregado con éxito");
            exit();
        } else {
            // Mostrar error si la consulta falla
            die("Error al agregar el cliente: " . mysqli_error($conn));
        }
    } else {
        // Mostrar mensaje de error si faltan datos
        die("Error: Faltan datos obligatorios para agregar el cliente.");
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Cliente</title>
    <!-- Enlace al archivo CSS externo -->
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<h1>Agregar Cliente</h1>

<!-- Formulario para agregar un nuevo cliente -->
<form action="agregar-clientes.php" method="post">
    <!-- Campo para el nombre del cliente -->
    <label for="Nombre">Nombre del Cliente</label>
    <input type="text" id="Nombre" name="Nombre" placeholder="Ejemplo: Juan Pérez" required>

    <!-- Campo para la dirección del cliente -->
    <label for="Direccion">Dirección</label>
    <input type="text" id="Direccion" name="Direccion" placeholder="Ejemplo: Calle 20 de Noviembre #123" required>

    <!-- Campo para el teléfono del cliente -->
    <label for="Telefono">Teléfono</label>
    <input type="text" id="Telefono" name="Telefono" placeholder="Ejemplo: 618-123-4567" required>

    <!-- Campo para el estado del cliente -->
    <label for="Status">Estado</label>
    <select id="Status" name="Status" required>
        <option value="1">Activo</option>
        <option value="0">Inactivo</option>
    </select>

    <!-- Botón para enviar el formulario -->
    <input type="submit" value="Agregar Cliente">
</form>

</body>
</html>
