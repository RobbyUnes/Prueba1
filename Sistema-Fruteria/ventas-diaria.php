<?php
// Incluir archivo de conexión a la base de datos
include "conexion-BD.php"; 
$conn = conectarBD(); // Establecer la conexión a la base de datos

// Consulta SQL para calcular el total vendido por día
$sql = "SELECT Fecha, SUM(Precio * Cantidad) AS TotalVendido
        FROM ventas
        WHERE Status = 1
        GROUP BY Fecha
        ORDER BY Fecha";

$resultado = mysqli_query($conn, $sql); // Ejecutar la consulta

// Verificar si la consulta fue exitosa
if (!$resultado) {
    die("Error en la consulta SQL: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Vendido por Día</title>

    <!-- Estilos CSS integrados -->
    <style>
        /* Estilo general */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f1f5f8;
            color: #333;
            text-align: center;
            padding: 30px;
            margin: 0;
        }

        /* Estilo para el encabezado */
        h1 {
            color: #2c3e50;
            font-size: 36px;
            margin-bottom: 30px;
            font-weight: bold;
        }

        /* Estilo para la tabla */
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        th, td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ecf0f1;
        }

        /* Encabezados de la tabla */
        th {
            background-color: #3498db;
            color: #fff;
            font-size: 18px;
            font-weight: 600;
        }

        /* Fila par de la tabla */
        tr:nth-child(even) {
            background-color: #ecf3f9;
        }

        /* Fila impar de la tabla */
        tr:nth-child(odd) {
            background-color: #ffffff;
        }

        /* Estilo para el botón */
        .add-button {
            background-color: #2980b9;
            color: #fff;
            padding: 14px 24px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            display: inline-block;
            margin-top: 30px;
            transition: background-color 0.3s ease;
        }

        .add-button:hover {
            background-color: #1abc9c;
        }

        /* Estilos adicionales para mejorar la visualización */
        a {
            text-decoration: none;
        }

        table th, table td {
            text-align: center;
        }

        /* Responsividad: Hacer que la tabla se ajuste en pantallas pequeñas */
        @media screen and (max-width: 768px) {
            table {
                width: 100%;
            }
            .add-button {
                font-size: 14px;
                padding: 10px 20px;
            }
        }
    </style>
</head>
<body>

 <?php include "menu.php"; ?>

<h1>Total Vendido por Día</h1>

<!-- Tabla para mostrar el total vendido por día -->
<table>
    <tr>
        <th>Fecha</th>
        <th>Total Vendido</th>
    </tr>
    <?php 
    // Iterar sobre los resultados de la consulta
    while ($fila = mysqli_fetch_assoc($resultado)) { ?>
        <tr>
            <td><?php echo $fila['Fecha']; ?></td> <!-- Mostrar la fecha -->
            <td>$<?php echo number_format($fila['TotalVendido'], 2); ?></td> <!-- Mostrar el total vendido -->
        </tr>
    <?php } ?>
</table>

<!-- Botón para regresar a la lista de ventas -->
<a href="ventas.php" class="add-button">Regresar a Lista de Ventas</a>

</body>
</html>
