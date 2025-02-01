<?php
// Conexión a la base de datos
include "conexion-BD.php"; 
$conn = conectarBD();

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar que todos los campos estén presentes
    if (isset($_POST['IdCliente'], $_POST['Nombre'], $_POST['Direccion'], $_POST['Telefono'], $_POST['Status'])) {
        $IdCliente = intval($_POST['IdCliente']);
        $nombreCliente = mysqli_real_escape_string($conn, $_POST['Nombre']);
        $direccionCliente = mysqli_real_escape_string($conn, $_POST['Direccion']);
        $telefonoCliente = mysqli_real_escape_string($conn, $_POST['Telefono']);
        $statusCliente = intval($_POST['Status']);

        // Actualizar los datos del cliente
        $sql = "UPDATE cliente 
                SET Nombre = '$nombreCliente', 
                    Direccion = '$direccionCliente', 
                    Telefono = '$telefonoCliente', 
                    Status = $statusCliente 
                WHERE IdCliente = $IdCliente";

        if (mysqli_query($conn, $sql)) {
            header("Location: Clientes.php?mensaje=Cliente actualizado con éxito");
            exit();
        } else {
            die("Error al actualizar el cliente: " . mysqli_error($conn));
        }
    } else {
        die("Error: Faltan datos obligatorios.");
    }
} else {
    die("Error: El formulario no fue enviado correctamente.");
}
?>
