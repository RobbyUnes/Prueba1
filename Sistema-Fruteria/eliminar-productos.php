<?php
include "conexion-BD.php";	
$conn = conectarBD();

// Verificar si se ha recibido el IdProducto
if (isset($_GET['producto'])) {
    $IdProducto = $_GET['producto'];

    // Consulta para cambiar el status del producto a 0 (inactivo)
    $sqlUpdate = "UPDATE producto SET status = 0 WHERE IdProducto = '$IdProducto'";

    if (mysqli_query($conn, $sqlUpdate)) {
        // Redirigir a la lista de productos con un mensaje de éxito
        header("Location: mostrar-productos.php?mensaje=Producto eliminado correctamente");
        exit();
    } else {
        // Si ocurre un error, mostrar mensaje de error
        $mensajeError = "Error al eliminar el producto: " . mysqli_error($conn);
        echo "<script>alert('$mensajeError'); window.history.back();</script>";
        exit();
    }
} else {
    // Si no se recibe el IdProducto
    echo "<script>alert('No se ha recibido el Id del producto'); window.history.back();</script>";
    exit();
}
?>
