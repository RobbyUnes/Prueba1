<?php
// Incluir archivo de conexión a la base de datos
include "conexion-BD.php"; 
$conn = conectarBD(); // Establecer la conexión a la base de datos

// Verificar si se recibió el parámetro 'cliente' en la URL
if (isset($_GET['cliente']) && is_numeric($_GET['cliente']) && $_GET['cliente'] > 0) {
    // Obtener el ID del cliente desde el parámetro GET
    $IdCliente = intval($_GET['cliente']);

    // Consulta SQL para actualizar el estado del cliente a '0' (Inactivo)
    $sql = "UPDATE cliente SET Status = 0 WHERE IdCliente = $IdCliente";

    // Ejecutar la consulta
    if (mysqli_query($conn, $sql)) {
        // Redirigir a la lista de clientes con un mensaje de éxito
        header("Location: Clientes.php?mensaje=Cliente eliminado con éxito");
        exit();
    } else {
        // Mostrar mensaje de error si la consulta falla
        die("Error al eliminar el cliente: " . mysqli_error($conn));
    }
} else {
    // Mostrar mensaje de error si no se recibe un ID válido
    die("Error: No se recibió un ID de cliente válido.");
}
?>
