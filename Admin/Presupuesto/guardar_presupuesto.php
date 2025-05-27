<?php

include __DIR__ . '/../config.php';        // Subes un nivel desde la carpeta actual
include ROOT_PATH . 'includes/db.php';     // Ya puedes usar ROOT_PATH



$fecha = $_POST['fecha'];
$cliente_id = null;

try {
    $conn->beginTransaction();

    // Verificamos si es cliente nuevo o existente
    if (!empty($_POST['cliente_id'])) {
        $cliente_id = $_POST['cliente_id'];
        $cliente_name = $_POST['cliente'];
        $total = isset($_POST['total']) ? floatval($_POST['total']) : 0;

    } else {
        // Insertar cliente nuevo
        $nuevo_nombre = trim($_POST['nuevo_nombre']);
        $nuevo_telefono = trim($_POST['nuevo_telefono']);
        $nuevo_correo = trim($_POST['nuevo_correo']);
        $nuevo_direccion = trim($_POST['nuevo_direccion']);

        if (!empty($nuevo_nombre)) {
            $stmt = $conn->prepare("INSERT INTO clientes (nombre, telefono, correo, direccion) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nuevo_nombre, $nuevo_telefono, $nuevo_correo, $nuevo_direccion]);
            $cliente_id = $conn->lastInsertId();
        } else {
            throw new Exception("Falta el nombre del cliente.");
        }
    }

    // Insertar presupuesto
    $stmt = $conn->prepare("INSERT INTO presupuestos (cliente_id, fecha,cliente_nombre,total) VALUES (?, ?,?,?)");
    $stmt->execute([$cliente_id, $fecha,$cliente_name,$total]);
    $presupuesto_id = $conn->lastInsertId();

    // Insertar productos
    $producto_ids = $_POST['producto_id'];
    $cantidades = $_POST['cantidad'];
    $precios = $_POST['precio'];
    $nombres = $_POST['producto_nombre'];

    for ($i = 0; $i < count($producto_ids); $i++) {
        $producto_id = $producto_ids[$i];
        $cantidad = $cantidades[$i];
        $precio = $precios[$i];
        $nombre = $nombres[$i];

        if ($producto_id && $cantidad > 0 && $precio >= 0) {
            $stmt = $conn->prepare("INSERT INTO presupuesto_detalle (presupuesto_id, producto_id, nombre_producto, cantidad, precio_unitario) VALUES (?, ?, ?, ?,?)");
            $stmt->execute([$presupuesto_id, $producto_id, $nombre, $cantidad, $precio]);
        }
    }

    $conn->commit();
    header("Location: presupuestos_lista.php?msg=ok");
    exit;

} catch (Exception $e) {
    $conn->rollBack();
    echo "Error al guardar el presupuesto: " . $e->getMessage();
}
?>
