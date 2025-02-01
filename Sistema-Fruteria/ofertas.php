<?php
include "conexion-BD.php"; // Incluye el archivo de conexión a la base de datos
$conn = conectarBD();

// Verificar si la conexión a la base de datos es válida
if (!$conn) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

// Consulta para obtener ofertas con el precio con descuento calculado
$sql = "SELECT DISTINCT o.IdOfertas, 
                       p.Nombre AS NombreProducto, 
                       p.Precio AS PrecioOriginal,
                       o.Descuento, 
                       (p.Precio - (p.Precio * o.Descuento / 100)) AS PrecioConDescuento,
                       o.FechaInicio, 
                       o.FechaFin, 
                       o.Status 
        FROM ofertas o
        INNER JOIN producto p ON o.IdProducto = p.IdProducto
        WHERE o.Status = '1'
        ORDER BY o.FechaInicio DESC";

$resultado = mysqli_query($conn, $sql);

// Manejo de errores en la consulta
if (!$resultado) {
    die("Error al obtener las ofertas: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Ofertas</title>
    <style>
        /* Estilo general del cuerpo */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #ecf0f1 0%, #bdc3c7 100%); /* Gradiente suave de grises */
            color: #333; /* Texto en gris oscuro */
            text-align: center;
        }

        /* Contenedor principal */
        .container {
            text-align: center;
            background-color: #fff; /* Blanco para el fondo del contenedor */
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0px 6px 16px rgba(0, 0, 0, 0.1);
            width: 80%;
            margin: 30px auto;
        }

        /* Encabezados */
        h1 {
            color: #2c3e50; /* Azul oscuro para el título */
            font-size: 2.2rem;
            margin-bottom: 20px;
            font-weight: 500;
        }

        /* Estilo para la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.08);
        }

        th,
        td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #2980b9; /* Azul marino para encabezados */
            color: white;
        }

        tr:nth-child(even) {
            background-color: #ecf0f1; /* Gris claro para filas alternas */
        }

        /* Botones generales */
        .button-container a,
        .button,
        .menu-button,
        .add-button,
        .action-button {
            background-color: #2980b9; /* Azul marino para botones */
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            display: inline-block;
            text-align: center;
            transition: background-color 0.3s ease;
            margin: 12px auto;
        }

        .button-container a:hover,
        .button:hover,
        .menu-button:hover,
        .add-button:hover,
        .action-button:hover {
            background-color: #1c5980; /* Azul más oscuro al pasar el ratón */
        }

        /* Botón especial (agregar) */
        .add-button {
            width: 220px;
            background-color: #16a085; /* Verde azulado para el botón especial */
        }

        .add-button:hover {
            background-color: #1abc9c; /* Verde más claro al pasar el ratón */
        }

        /* Contenedor de detalles */
        .oferta {
            background-color: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 6px 16px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            text-align: left;
        }

        .oferta p {
            margin: 8px 0;
            font-size: 1rem;
            line-height: 1.5;
        }

        /* Formularios */
        form {
            background-color: #fff;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0px 6px 16px rgba(0, 0, 0, 0.1);
            max-width: 550px;
            margin: 0 auto;
            text-align: left;
        }

        form label {
            display: block;
            margin-bottom: 12px;
            font-weight: 600;
            color: #333;
            font-size: 1.1rem;
        }

        form input[type="number"],
        form select,
        form input[type="text"] {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 1.1rem;
            box-sizing: border-box;
            background-color: #ecf0f1; /* Fondo gris claro para inputs */
        }

        form input[type="submit"] {
            background-color: #2980b9; /* Azul marino para botón de submit */
            color: white;
            border: none;
            padding: 16px 24px;
            border-radius: 6px;
            font-size: 1.2rem;
            cursor: pointer;
            width: 100%;
            text-transform: uppercase;
            font-weight: 600;
        }

        form input[type="submit"]:hover {
            background-color: #1c5980; /* Azul más oscuro al pasar el ratón */
        }

        /* Centrado de acciones */
        .acciones {
            margin-top: 30px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include "menu.php"; ?>
        <h1>Lista de Ofertas Activas</h1>

        <?php if (mysqli_num_rows($resultado) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID Oferta</th>
                        <th>Producto</th>
                        <th>Precio Original</th>
                        <th>Descuento (%)</th>
                        <th>Precio con Oferta</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Status</th>
                        <th>Acciones</th> <!-- Nueva columna para acciones -->
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td><?php echo $fila['IdOfertas']; ?></td>
                            <td><?php echo $fila['NombreProducto']; ?></td>
                            <td>$<?php echo number_format($fila['PrecioOriginal'], 2); ?></td>
                            <td><?php echo $fila['Descuento']; ?>%</td>
                            <td>$<?php echo number_format($fila['PrecioConDescuento'], 2); ?></td>
                            <td><?php echo $fila['FechaInicio']; ?></td>
                            <td><?php echo $fila['FechaFin']; ?></td>
                            <td><?php echo $fila['Status'] == '1' ? 'Activo' : 'Inactivo'; ?></td>
                            <td>
                                <!-- Botón Modificar -->
                                <a href="modificar-oferta.php?id=<?php echo $fila['IdOfertas']; ?>" class="button">Modificar</a>
                                <!-- Botón Eliminar -->
                                <a href="eliminar-oferta.php?id=<?php echo $fila['IdOfertas']; ?>" class="button eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar esta oferta?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay ofertas activas registradas.</p>
        <?php endif; ?>

        <div class="button-container">
            <a href="agregar-oferta.php" class="button">Agregar Nueva Oferta</a>
            <a href="index.php" class="button">Inicio</a>
        </div>
    </div>
</body>
</html>
