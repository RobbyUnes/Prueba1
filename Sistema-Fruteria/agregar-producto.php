<?php
    include "conexion-BD.php";    
    $conn = conectarBD();

    // Verificar si el formulario ha sido enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
        $precio = mysqli_real_escape_string($conn, $_POST['precio']);
        $categoria = mysqli_real_escape_string($conn, $_POST['categoria']);
        
        // Consulta para insertar el nuevo producto
        $sql = "INSERT INTO producto (Nombre, Precio, IdCategoriaPdt, status) VALUES ('$nombre', '$precio', '$categoria', 1)";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Producto agregado exitosamente');</script>";
            echo "<script>window.location.href = 'mostrar-productos.php';</script>"; // Redirigir a la lista de productos
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    // Consulta para obtener las categorías
    $sqlCategoria = "SELECT IdCategoriaPdt, Nombre FROM CategoriaPdt";
    $resultadoCategoria = mysqli_query($conn, $sqlCategoria);
    if (!$resultadoCategoria) {
        die("Error al obtener las categorías: " . mysqli_error($conn));
    }
?>  

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agregar Producto</title>
    <style>
        /* Estilo básico para la página */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }

        h1 {
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        button {
            padding: 10px;
            font-size: 14px;
            border-radius: 4px;
            border: none;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .cancelar-boton {
            background-color: #f44336;
            margin-left: 10px;
        }

        .cancelar-boton:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
     <?php include "menu.php"; ?>
    <h1>Agregar Nuevo Producto</h1>

    <form action="agregar-producto.php" method="POST">
        <label for="nombre">Nombre del Producto:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="precio">Precio del Producto:</label>
        <input type="number" id="precio" name="precio" step="0.01" required>

        <label for="categoria">Categoría:</label>
        <select id="categoria" name="categoria" required>
            <option value="">Selecciona una categoría</option>
            <?php
                while($fila = mysqli_fetch_assoc($resultadoCategoria)) { ?>
                    <option value="<?php echo $fila["IdCategoriaPdt"];?>">
                        <?php echo $fila["Nombre"];?>
                    </option>
            <?php } ?>
        </select>

        <button type="submit">Agregar Producto</button>
        <a href="mostrar-productos.php" class="cancelar-boton">Cancelar</a>
    </form>

</body>
</html>
