<?php include 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Óptica - Sistema de Ventas</title>
    <link rel="stylesheet" href="style.css">
    <script src="js/main.js" defer></script>
</head>
<body>
    <h1>Óptica - Sistema de Ventas</h1>
    
    <nav>
        <button onclick="cargarSeccion('registrar_cliente')">Registrar Cliente</button>
        <button onclick="cargarSeccion('registrar_sucursal')">Registrar Sucursal</button>
        <button onclick="cargarSeccion('registrar_venta')">Registrar Venta</button>
        <button onclick="cargarSeccion('registrar_pago')">Registrar Pago</button>
        <button onclick="cargarSeccion('consultar_ventas')">Consultar Ventas</button>
    </nav>

    <div id="contenido">
        <h2>Bienvenido al sistema</h2>
        <p>Selecciona una opción para comenzar.</p>
    </div>
</body>
</html>
