<?php
include "conexion-BD.php";
$conn = conectarBD();

if (!$conn) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Verificar que se recibieron datos
if (!isset($_POST['IdProducto']) || !isset($_POST['Cantidad'])) {
    die("No se recibieron datos válidos para procesar la venta.");
}

// Obtener los datos enviados desde el formulario
$productos = $_POST['IdProducto'];
$cantidades = $_POST['Cantidad'];
$metodoPago = $_POST['IdMetodoPago'];

$total = 0; // Variable para acumular el total

echo "<h1>Detalles de la Venta</h1>";

foreach ($productos as $index => $idProducto) {
    $cantidad = intval($cantidades[$index]); // Asegurar que la cantidad sea un número entero

    if ($cantidad <= 0) {
        continue; // Ignorar productos con cantidad inválida
    }

    // Consulta para obtener el precio del producto, considerando la oferta activa
    $sql = "SELECT 
                p.Nombre,
                COALESCE(o.Descuento, 0) AS Descuento,
                CASE 
                    WHEN o.Status = '1' THEN (p.Precio - (p.Precio * o.Descuento / 100))
                    ELSE p.Precio 
                END AS PrecioFinal
            FROM producto p
            LEFT JOIN ofertas o ON p.IdProducto = o.IdProducto AND o.Status = '1'
            WHERE p.IdProducto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idProducto);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($producto = $resultado->fetch_assoc()) {
        // Calcular subtotal para este producto
        $subtotal = $producto['PrecioFinal'] * $cantidad;
        $total += $subtotal; // Acumular el total

        echo "<p>{$producto['Nombre']}: {$cantidad} x $".number_format($producto['PrecioFinal'], 2)." = $".number_format($subtotal, 2)."</p>";
    } else {
        echo "<p>Error: Producto con ID {$idProducto} no encontrado.</p>";
    }
}

// Mostrar el total final
echo "<h2>Total a pagar: $".number_format($total, 2)."</h2>";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Oferta</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<a href="nueva-venta.php" class="add-button">Registrar Nueva Venta</a>

<a href="ventas-diaria.php" class="add-button">Ver Ventas Diarias</a>


</body>
</html>