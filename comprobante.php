<?php
include 'conexion.php';

if (isset($_GET['id_venta'])) {
    $id_venta = $_GET['id_venta'];
    $sql = "SELECT v.id_venta, c.nombre, c.apellido, v.monto_total, v.estado_pago 
            FROM Venta v 
            JOIN Cliente c ON v.id_cliente = c.id_cliente 
            WHERE v.id_venta = $id_venta";
    
    $result = $conn->query($sql);
    if ($row = $result->fetch_assoc()) {
        echo "<h2>Comprobante de Venta</h2>";
        echo "<p><strong>Número de Venta:</strong> {$row['id_venta']}</p>";
        echo "<p><strong>Cliente:</strong> {$row['nombre']} {$row['apellido']}</p>";
        echo "<p><strong>Total:</strong> \${$row['monto_total']}</p>";
        echo "<p><strong>Estado de Pago:</strong> {$row['estado_pago']}</p>";
    } else {
        echo "No se encontró la venta.";
    }
}
?>
