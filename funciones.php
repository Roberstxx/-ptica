<?php
include 'conexion.php';

if (isset($_GET['seccion'])) {
    $seccion = $_GET['seccion'];

    if ($seccion == "registrar_cliente") {
        echo '<h2>Registrar Cliente</h2>
        <form action="funciones.php" method="POST">
            <input type="hidden" name="accion" value="registrar_cliente">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="apellido" placeholder="Apellido" required>
            <input type="date" name="fecha_nacimiento" required>
            <input type="text" name="telefono" placeholder="Teléfono">
            <input type="email" name="correo" placeholder="Correo">
            <button type="submit">Registrar</button>
        </form>';
    }

    if ($seccion == "registrar_venta") {
        echo '<h2>Registrar Venta</h2>
        <form action="funciones.php" method="POST">
            <input type="hidden" name="accion" value="registrar_venta">
            <input type="number" name="id_cliente" placeholder="ID Cliente" required>
            <input type="number" name="id_sucursal" placeholder="ID Sucursal" required>
            <input type="number" name="monto_total" placeholder="Monto Total" required>
            <button type="submit">Registrar Venta</button>
        </form>';
    }

    if ($seccion == "registrar_pago") {
        echo '<h2>Registrar Pago</h2>
        <form action="funciones.php" method="POST">
            <input type="hidden" name="accion" value="registrar_pago">
            <label for="id_venta">Selecciona una Venta:</label>
            <select name="id_venta" required>';
        
        $result = $conn->query("SELECT id_venta, id_cliente, monto_total FROM Venta WHERE estado_pago = 'Pendiente'");
        while ($row = $result->fetch_assoc()) {
            echo '<option value="'.$row["id_venta"].'">Venta #'.$row["id_venta"].' - Cliente '.$row["id_cliente"].' - Total: $'.$row["monto_total"].'</option>';
        }

        echo '</select>
            <input type="number" name="monto_pagado" placeholder="Monto Pagado" required>
            <select name="metodo_pago">
                <option value="Efectivo">Efectivo</option>
                <option value="Tarjeta">Tarjeta</option>
                <option value="Transferencia">Transferencia</option>
            </select>
            <button type="submit">Registrar Pago</button>
        </form>';
    }

    if ($seccion == "consultar_ventas") {
        echo '<h2>Consultar Ventas</h2>';
        
        $result = $conn->query("SELECT Venta.id_venta, Cliente.nombre, Cliente.apellido, Venta.monto_total, Venta.estado_pago 
                                FROM Venta 
                                INNER JOIN Cliente ON Venta.id_cliente = Cliente.id_cliente");
        
        if ($result->num_rows > 0) {
            echo '<table border="1">
                    <tr>
                        <th>ID Venta</th>
                        <th>Cliente</th>
                        <th>Monto Total</th>
                        <th>Estado de Pago</th>
                    </tr>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                        <td>'.$row["id_venta"].'</td>
                        <td>'.$row["nombre"].' '.$row["apellido"].'</td>
                        <td>$'.$row["monto_total"].'</td>
                        <td>'.$row["estado_pago"].'</td>
                      </tr>';
            }
            echo '</table>';
        } else {
            echo "No hay ventas registradas.";
        }
    }

    if ($seccion == "registrar_sucursal") {
        echo '<h2>Registrar Sucursal</h2>
        <form action="funciones.php" method="POST">
            <input type="hidden" name="accion" value="registrar_sucursal">
            <input type="text" name="nombre_sucursal" placeholder="Nombre de la Sucursal" required>
            <input type="text" name="direccion" placeholder="Dirección" required>
            <input type="text" name="telefono" placeholder="Teléfono" required>
            <button type="submit">Registrar Sucursal</button>
        </form>';
    }
}

// Procesamiento de formularios
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accion'])) {
    if ($_POST['accion'] == "registrar_cliente") {
        $sql = "INSERT INTO Cliente (nombre, apellido, fecha_nacimiento, telefono, correo) 
                VALUES ('{$_POST['nombre']}', '{$_POST['apellido']}', '{$_POST['fecha_nacimiento']}', '{$_POST['telefono']}', '{$_POST['correo']}')";
    }

    if ($_POST['accion'] == "registrar_venta") {
        $sql = "INSERT INTO Venta (id_cliente, id_sucursal, monto_total, estado_pago) 
                VALUES ('{$_POST['id_cliente']}', '{$_POST['id_sucursal']}', '{$_POST['monto_total']}', 'Pendiente')";
        
        if ($conn->query($sql) === TRUE) {
            $id_venta = $conn->insert_id;
            echo "Venta registrada con éxito. Número de comprobante: <a href='comprobante.php?id_venta=$id_venta' target='_blank'>$id_venta</a>";
        }
    }

    if ($_POST['accion'] == "registrar_pago") {
        $sql = "INSERT INTO Pago (id_venta, monto_pagado, metodo_pago) 
                VALUES ('{$_POST['id_venta']}', '{$_POST['monto_pagado']}', '{$_POST['metodo_pago']}')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Pago registrado con éxito.";
        }
    }

    if ($_POST['accion'] == "registrar_sucursal") {
        $sql = "INSERT INTO Sucursal (nombre_sucursal, direccion, telefono) 
                VALUES ('{$_POST['nombre_sucursal']}', '{$_POST['direccion']}', '{$_POST['telefono']}')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Sucursal registrada con éxito.";
        }
    }

    if ($conn->query($sql) === TRUE) {
        echo "Operación realizada con éxito.";
    } else {
        echo "Error: " . $conn->error;
    }
    $conn->close();
}
?>
