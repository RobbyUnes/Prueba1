<?php 
include "conexion-BD.php";	
$conn = conectarBD();

// Verificar si se ha recibido el IdProducto
if (isset($_GET['producto'])) {
    $IdProducto = $_GET['producto'];

    // Obtener la información del producto
    $sql = "SELECT IdProducto, Nombre, Precio, IdCategoriaPdt FROM producto WHERE IdProducto = $IdProducto";
    $resultado = mysqli_query($conn, $sql);
    
    if (!$resultado) {
        die("Error al obtener el producto: " . mysqli_error($conn));
    }

    $infoProducto = mysqli_fetch_assoc($resultado);

    // Asignar los valores del producto
    $nombreProducto = $infoProducto['Nombre'];
    $precioProducto = $infoProducto['Precio'];
    $idCategoriaPdt = $infoProducto['IdCategoriaPdt'];
} else {
    die("No se ha recibido el Id del producto.");
}
?> 

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modificar Producto</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f9; }
        h1 { color: #333; }
        form { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); width: 400px; margin: 0 auto; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input[type="text"], select { width: 100%; padding: 10px; margin: 5px 0 20px 0; border-radius: 4px; border: 1px solid #ddd; }
        input[type="submit"] { background-color: #4CAF50; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; }
        input[type="submit"]:hover { background-color: #45a049; }
    </style>
</head>
<body>

    <h1>Modificar Producto</h1>
    
    <form action="guardar-modificacion-productos.php" method="post">
        <input type="hidden" name="IdProducto" value="<?php echo $IdProducto; ?>">

        <label for="Nombre">Nombre del Producto</label>
        <input type="text" id="Nombre" name="Nombre" value="<?php echo $nombreProducto; ?>" required>

        <label for="Precio">Precio</label>
        <input type="text" id="Precio" name="Precio" value="<?php echo $precioProducto; ?>" required>

        <label for="CategoriaPdt">Tipo de Producto</label>
        <select id="CategoriaPdt" name="CategoriaPdt" required>
            <option value="1" <?php echo ($idCategoriaPdt == 1) ? "selected" : ""; ?>>Frutas</option>
            <option value="2" <?php echo ($idCategoriaPdt == 2) ? "selected" : ""; ?>>Verduras</option>
            <option value="3" <?php echo ($idCategoriaPdt == 3) ? "selected" : ""; ?>>Bebidas</option>
            <option value="4" <?php echo ($idCategoriaPdt == 4) ? "selected" : ""; ?>>Abarrotes</option>
            <option value="5" <?php echo ($idCategoriaPdt == 5) ? "selected" : ""; ?>>Cremeria</option>
        </select>

        <input type="submit" value="Guardar Cambios">
    </form>

</body>
</html>

</html>
