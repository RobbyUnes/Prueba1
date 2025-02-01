<?php
include "conexion-BD.php";  
$conn = conectarBD();

// Verificar si se han recibido los datos correctamente
if (isset($_POST['IdProducto'], $_POST['Nombre'], $_POST['Precio'], $_POST['CategoriaPdt'])) {
    $IdProducto = $_POST['IdProducto'];  // Recuperamos el ID del producto
    $Nombre = mysqli_real_escape_string($conn, $_POST['Nombre']);  // Evitar inyección de SQL
    $Precio = $_POST['Precio'];
    $CategoriaPdt = $_POST['CategoriaPdt'];

    // Verificar si los datos no están vacíos
    if (empty($Nombre) || empty($Precio) || empty($CategoriaPdt)) {
        $mensajeError = "Por favor, complete todos los campos.";
        echo "<script>alert('$mensajeError'); window.history.back();</script>";
        exit();
    }

    // Realizar la consulta para actualizar el producto en la base de datos
    $sqlUpdate = "UPDATE producto 
                  SET Nombre = '$Nombre', 
                      Precio = '$Precio', 
                      IdCategoriaPdt = '$CategoriaPdt'
                  WHERE IdProducto = '$IdProducto'";

    // Ejecutar la consulta y verificar si fue exitosa
    if (mysqli_query($conn, $sqlUpdate)) {
        // Redirigir a la página de productos con un mensaje de éxito
        header("Location: mostrar-productos.php?mensaje=Producto actualizado correctamente");
        exit();
    } else {
        $mensajeError = "Error al actualizar el producto: " . mysqli_error($conn);
        echo "<script>alert('$mensajeError'); window.history.back();</script>";
        exit();
    }
} else {
    $mensajeError = "No se han recibido todos los datos del formulario.";
    echo "<script>alert('$mensajeError'); window.history.back();</script>";
    exit();
}
?>

