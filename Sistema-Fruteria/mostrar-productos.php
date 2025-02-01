<?php
	// Incluir el archivo de conexión a la base de datos
	include "conexion-BD.php";	
	$conn = conectarBD();

	// Verificar si se ha enviado un tipo para filtrar los productos
	$tipoSeleccionado = isset($_GET['tipo']) ? $_GET['tipo'] : '';

	// Consulta SQL para obtener los productos activos, con un filtro si se ha seleccionado un tipo
	$sql = "SELECT IdProducto, Nombre, Precio, Imagen FROM producto WHERE status = 1";
	if ($tipoSeleccionado) {
		$sql .= " AND IdCategoriaPdt = '$tipoSeleccionado'";  // Filtrar por tipo de producto si se ha seleccionado
	}
	$resultado = mysqli_query($conn, $sql);
	if (!$resultado) {
		die("Error al obtener los productos: " . mysqli_error($conn));
	}

	// Consulta SQL para obtener los tipos de productos desde la tabla CategoriaPdt
	$sqlTipo = "SELECT IdCategoriaPdt, Nombre FROM CategoriaPdt";
	$resultadoTipo = mysqli_query($conn, $sqlTipo);
	if (!$resultadoTipo) {
		die("Error al obtener los tipos de productos: " . mysqli_error($conn));
	}
	// Consulta SQL para obtener los tipos de productos desde la tabla CategoriaPdt
	$sqlOferta = "SELECT IdOfertas, Descuento FROM ofertas";
	$resultadoOfertas = mysqli_query($conn, $sqlOferta);
	if (!$resultadoOfertas) {
		die("Error al obtener los descuentos: " . mysqli_error($conn));
	}
?>	

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Lista de Productos</title>
	<?php include "menu.php"; ?>
	<style>
		body {
			font-family: 'Arial', sans-serif;
			margin: 20px;
			background-color: #f4f4f9;
		}

		h1 {
			color: #333;
			font-size: 36px;
		}

		/* Estilo para la tabla */
		table {
			width: 100%;
			border-collapse: collapse;
			margin-top: 20px;
			background-color: #ffffff;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			border-radius: 8px;
		}

		table, th, td {
			border: 1px solid #ddd;
		}

		th, td {
			padding: 15px;
			text-align: center;
		}

		th {
			background-color: #3498db;
			color: white;
			font-size: 18px;
		}

		tr:nth-child(even) {
			background-color: #ecf0f1;
		}

		/* Estilo para el formulario */
		form {
			margin-bottom: 20px;
			background-color: #fff;
			padding: 15px;
			border-radius: 8px;
			box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
		}

		/* Estilo para el select y botón */
		select, button {
			padding: 10px;
			font-size: 14px;
			border-radius: 4px;
			border: 1px solid #ddd;
			cursor: pointer;
		}

		button {
			background-color: #3498db;
			color: white;
			border: none;
			margin-left: 10px;
		}

		button:hover {
			background-color: #2980b9;
		}

		/* Estilo para el botón de agregar nuevo producto */
		.agregar-boton {
			background-color: #2ecc71;
			color: white;
			border: none;
			padding: 12px 24px;
			cursor: pointer;
			text-decoration: none;
			border-radius: 4px;
			font-weight: bold;
		}

		.agregar-boton:hover {
			background-color: #27ae60;
		}

		/* Estilo para las imágenes de los productos */
		img {
			width: 100px; /* Se ajusta el tamaño de la imagen */
			height: auto;
			border-radius: 5px;
			border: 1px solid #ddd;
		}

		/* Estilo para el logo */
		.logo {
			max-width: 300px;
			width: 100%;
			display: block;
			margin: 0 auto 20px;
		}

		/* Responsividad para dispositivos pequeños */
		@media screen and (max-width: 768px) {
			table {
				width: 100%;
			}
			.agregar-boton {
				font-size: 14px;
				padding: 10px 20px;
			}
		}
	</style>
</head>
<body>
	<img src="imagenes/Logo.jpg" alt="Logo de la tienda" class="logo">

	<h1>Lista de Productos</h1>

	<!-- Formulario para filtrar productos por tipo -->
	<form action="mostrar-productos.php" method="GET">
		<h2>Filtrar por:</h2>
		<label for="tipo">Tipo de producto</label>
		<select name="tipo" id="tipo">
			<option value="">Selecciona un tipo</option>
			<?php 
				$selectedTipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';
				// Mostrar los tipos de productos en el dropdown
				while($fila = mysqli_fetch_assoc($resultadoTipo)) { ?>
					<option value="<?php echo $fila["IdCategoriaPdt"];?>" <?php echo $selectedTipo == $fila["IdCategoriaPdt"] ? 'selected' : ''; ?>>
						<?php echo $fila["Nombre"];?>
					</option>
				<?php } ?>
		</select>
		<button type="submit">Filtrar</button>
	</form>

	<!-- Tabla que muestra los productos -->
	<table>
		<tr>
			<th>Imagen</th>
			<th>Nombre del Producto</th>
			<th>Precio</th>
			<th>Modificar</th>
			<th>Eliminar</th>
		</tr>
		<?php 
			// Mostrar los productos
			while($fila = mysqli_fetch_assoc($resultado)) { ?>
				<tr>
					<td>
						<img src="imagenes/<?php echo $fila["Imagen"] ? $fila["Imagen"] : 'Default.jpg'; ?>" alt="<?php echo $fila["Nombre"]; ?>">
					</td>
					<td><?php echo $fila["Nombre"];?></td>
					<td>$<?php echo $fila["Precio"];?></td>
					<td><a href="modificar-productos.php?producto=<?php echo $fila["IdProducto"];?>">
							<img width="20px" src="imagenes/lapiz.jpeg" alt="Modificar">
						</a>
					</td>
					
					<td><a href="eliminar-productos.php?producto=<?php echo $fila["IdProducto"];?>">
							<img width="20px" src="imagenes/eliminar.png" alt="Eliminar">
						</a>
					</td>
				</tr>
			<?php } ?>
		<tr>
			<td colspan="5" style="text-align: center;">
				<a href="agregar-producto.php" class="agregar-boton">Agregar Nuevo Producto</a>
				<a href="index.php" class="agregar-boton">Cancelar</a>
				<!-- Botón para ir a ofertas -->
				<a href="ofertas.php" class="agregar-boton">Ver Ofertas Especiales</a>
			</td>
		</tr>
	</table>	
</body>
</html>
