<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venta de Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            font-size: 18px;
        }

        #venta-container {
            width: 85%;
            margin: 0 auto;
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th, td {
            border: 2px solid #ddd;
            padding: 15px;
            text-align: center;
            font-size: 20px;
        }

        th {
            background-color: #6699cc;
            color: white;
        }

        button {
            padding: 15px 30px;
            background-color: #0066cc;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 20px;
            font-size: 18px;
        }

        button:hover {
            background-color: #004a99;
        }

        #total {
            text-align: right;
            font-size: 24px;
            margin-top: 30px;
            color: #003366;
        }

        label {
            font-size: 22px;
            margin-top: 20px;
        }

        input[type="text"], input[type="number"] {
            font-size: 22px;
            padding: 10px;
            width: 300px;
            margin-top: 10px;
            border: 2px solid #6699cc;
        }

        input[type="text"]:focus, input[type="number"]:focus {
            border-color: #0066cc;
        }
    </style>
</head>
<body>
    <!-- Incluye el menú -->
    <?php include 'menu.php'; ?>

    <div id="venta-container">
        <!-- Escaneo de productos -->
        <label for="CodigoBarras">Escanear Producto</label>
        <input type="text" id="CodigoBarras" placeholder="Código de Barras">
        <button id="add-producto">Agregar Producto</button>

        <!-- Tabla de productos -->
        <table id="tabla-productos">
            <thead>
                <tr>
                    <th>Código de Barras</th>
                    <th>Descripción</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Importe</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Los productos se agregarán dinámicamente aquí -->
            </tbody>
        </table>

        <!-- Total -->
        <div id="total">Total: $0.00</div>

        <!-- Campo para pago y cálculo del cambio -->
        <div id="cambio-container">
            <label for="MontoPagado">Monto Pagado:</label>
            <input type="number" id="MontoPagado" placeholder="Ingrese el monto pagado">
            <div id="cambio">Cambio: $0.00</div>
            <button id="calcular-cambio">Calcular Cambio</button>
        </div>

        <!-- Botón para registrar la venta -->
        <button id="registrar-venta">Registrar Venta</button>
    </div>

    <script>
        let total = 0;

        function agregarProducto(codigo, descripcion, precio) {
            const tabla = document.querySelector("#tabla-productos tbody");
            let filaExistente = Array.from(tabla.rows).find(row => row.cells[0].innerText === codigo);

            if (filaExistente) {
                let cantidadCell = filaExistente.cells[3];
                let importeCell = filaExistente.cells[4];
                let cantidad = parseInt(cantidadCell.innerText) + 1;
                cantidadCell.innerText = cantidad;
                let nuevoImporte = cantidad * precio;
                importeCell.innerText = `$${nuevoImporte.toFixed(2)}`;
                total += precio;
            } else {
                const cantidad = 1;
                const importe = cantidad * precio;
                total += importe;
                const fila = document.createElement("tr");
                fila.innerHTML = `
                    <td>${codigo}</td>
                    <td>${descripcion}</td>
                    <td>$${precio.toFixed(2)}</td>
                    <td>${cantidad}</td>
                    <td>$${importe.toFixed(2)}</td>
                    <td><button class="eliminar">Eliminar</button></td>
                `;
                tabla.appendChild(fila);
                fila.querySelector(".eliminar").addEventListener("click", function () {
                    total -= importe;
                    fila.remove();
                    document.getElementById("total").innerText = `Total: $${total.toFixed(2)}`;
                });
            }
            document.getElementById("total").innerText = `Total: $${total.toFixed(2)}`;
        }

        document.getElementById("calcular-cambio").addEventListener("click", function () {
            const montoPagado = parseFloat(document.getElementById("MontoPagado").value);

            if (isNaN(montoPagado) || montoPagado < total) {
                alert("El monto ingresado es insuficiente para cubrir el total.");
                return;
            }

            const cambio = montoPagado - total;
            document.getElementById("cambio").innerText = `Cambio: $${cambio.toFixed(2)}`;
        });

        document.getElementById("registrar-venta").addEventListener("click", function () {
            const montoPagado = parseFloat(document.getElementById("MontoPagado").value);

            if (isNaN(montoPagado) || montoPagado < total) {
                alert("Por favor, verifica el monto pagado. Es insuficiente.");
                return;
            }

            alert("Venta registrada exitosamente. Total: $" + total.toFixed(2));
            document.querySelector("#tabla-productos tbody").innerHTML = "";
            document.getElementById("total").innerText = "Total: $0.00";
            document.getElementById("MontoPagado").value = "";
            document.getElementById("cambio").innerText = "Cambio: $0.00";
            total = 0;
        });
    </script>
</body>
</html>
