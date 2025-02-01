<?php 
// Incluir el archivo de conexión a la base de datos
include "conexion-BD.php"; 
$conn = conectarBD(); // Establecer la conexión a la base de datos

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (!empty($username) && !empty($password)) {
    $rol = null;
    $user = null;

    // Consulta en la tabla de administradores
    $stmtAdmin = $conn->prepare("SELECT idAdmin, username, password FROM administrador WHERE username = ?");
    if (!$stmtAdmin) {
        die("Error en la consulta SQL (admin): " . $conn->error);
    }

    $stmtAdmin->bind_param("s", $username); // Vincular el parámetro
    $stmtAdmin->execute(); // Ejecutar la consulta
    $resultadoAdmin = $stmtAdmin->get_result(); // Obtener el resultado

    if ($resultadoAdmin->num_rows > 0) {
        $user = $resultadoAdmin->fetch_assoc();
        $rol = 'admin';
    } else {
        // Consulta en la tabla de vendedores
        $stmtVendedor = $conn->prepare("SELECT idVendedor, username, password FROM vendedor WHERE username = ?");
        if (!$stmtVendedor) {
            die("Error en la consulta SQL (vendedores): " . $conn->error);
        }

        $stmtVendedor->bind_param("s", $username);
        $stmtVendedor->execute();
        $resultadoVendedor = $stmtVendedor->get_result();

        if ($resultadoVendedor->num_rows > 0) {
            $user = $resultadoVendedor->fetch_assoc();
            $rol = 'vendedor';
        }
        $stmtVendedor->close();
    }
    $stmtAdmin->close();

    // Verificar credenciales
    if ($user && $password === $user['password']) {
        if ($rol === 'admin') {
            echo "<script>window.location.href = 'index.php';</script>";
        } elseif ($rol === 'vendedor') {
            echo "<script>window.location.href = 'nueva-venta.php';</script>";
        }
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
} else {
    echo "Por favor, completa todos los campos.";
}

$conn->close(); // Cerrar la conexión a la base de datos
?>
