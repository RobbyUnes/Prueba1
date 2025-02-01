<?php
include "conexion-BD.php"; // Conexión a la base de datos
$conn = conectarBD();

if (!$conn) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM ofertas WHERE IdOfertas = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<p>Oferta eliminada correctamente.</p>";
    } else {
        echo "<p>Error al eliminar la oferta: " . $conn->error . "</p>";
    }
} else {
    echo "<p>ID de oferta no especificado.</p>";
}

echo '<a href="ofertas.php">Volver a la lista de ofertas</a>';
?>
