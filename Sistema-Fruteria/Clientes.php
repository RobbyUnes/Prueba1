<?php 
// Incluir el archivo de conexión a la base de datos
include "conexion-BD.php"; 
$conn = conectarBD(); // Establecer la conexión a la base de datos

// Consulta SQL para obtener solo los clientes activos (Status = 1)
$sql = "SELECT IdCliente, Nombre, Direccion, Telefono, Status FROM cliente WHERE Status = 1";
$resultado = mysqli_query($conn, $sql); // Ejecutar la consulta

// Verificar si la consulta fue exitosa
if (!$resultado) {
    die("Error al obtener los clientes: " . mysqli_error($conn)); // Mostrar mensaje de error si falla
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
    <!-- Enlace al archivo CSS externo -->
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
<?php include "menu.php"; ?>
<!-- Encabezado principal -->
<h1>Lista de Clientes</h1>

<!-- Tabla para mostrar la lista de clientes activos -->
<table>
    <tr>
        <!-- Encabezados de las columnas -->
        <th>Nombre</th>
        <th>Dirección</th>
        <th>Teléfono</th>
        <th>Estado</th>
        <th>Acciones</th>
    </tr>
    <?php 
    // Iterar sobre los resultados de la consulta y mostrar los datos en la tabla
    while ($fila = mysqli_fetch_assoc($resultado)) { ?>
        <tr>
            <!-- Mostrar el nombre del cliente -->
            <td><?php echo $fila['Nombre']; ?></td>

            <!-- Mostrar la dirección del cliente -->
            <td><?php echo $fila['Direccion']; ?></td>

            <!-- Mostrar el teléfono del cliente -->
            <td><?php echo $fila['Telefono']; ?></td>

            <!-- Mostrar el estado del cliente (Siempre será Activo por la consulta SQL) -->
            <td>Activo</td>

            <!-- Acciones para editar o eliminar al cliente -->
            <td>
                <!-- Enlace para editar el cliente -->
                <a href="editar-clientes.php?cliente=<?php echo $fila['IdCliente']; ?>" class="action-button">Editar</a>

               <!-- Enlace para eliminar el cliente con confirmación -->
                 <!-- Enlace para eliminar el cliente -->
                <a href="eliminar-clientes.php?cliente=<?php echo $fila['IdCliente']; ?>" class="action-button delete-button" 
                   onclick="return confirm('¿Estás seguro de que deseas eliminar este cliente?');">
                   Eliminar
                </a>

                </a>
            </td>
        </tr>
    <?php } ?>
</table>

<!-- Botón para agregar un nuevo cliente -->
<a href="agregar-clientes.php" class="add-button">Agregar Nuevo Cliente</a>
<a href="index.php" class="add-button">Cancelar</a>

</body>
</html>
