<?php
include "conexion-BD.php";
$conn = conectarBD();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigoBarras = $_POST['CodigoBarras'];

    // Validar entrada
    if (empty($codigoBarras)) {
        echo json_encode(["error" => "Código de barras vacío"]);
        exit;
    }

    // Consultar producto en la base de datos
    $sqlProducto = "SELECT CodigoBarra, Nombre, Precio FROM producto WHERE CodigoBarra = ?";
    $stmt = $conn->prepare($sqlProducto);
    $stmt->bind_param("s", $codigoBarras);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
        echo json_encode($producto);
    } else {
        echo json_encode(["error" => "Producto no encontrado"]);
    }

    $stmt->close();
    $conn->close();
}
?>
