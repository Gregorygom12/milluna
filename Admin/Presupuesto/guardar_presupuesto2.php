 <?php
include '../../includes/db.php';

// Validar si hay datos
if (!isset($_POST['cliente_id'], $_POST['productos'], $_POST['cantidades'], $_POST['precios'])) {
    die("Faltan datos del formulario.");
}

$cliente_id = intval($_POST['cliente_id']);
$productos = $_POST['productos'];
$cantidades = $_POST['cantidades'];
$precios = $_POST['precios'];

try {
    $conn->beginTransaction();

    // Insertar en presupuestos
    $stmt = $conn->prepare("INSERT INTO presupuestos (cliente_id, fecha, total) VALUES (:cliente_id, NOW(), 0)");
    $stmt->bindParam(':cliente_id', $cliente_id);
    $stmt->execute();
    $presupuesto_id = $conn->lastInsertId();

    $total = 0;

    // Insertar los detalles
    $stmt_detalle = $conn->prepare("
        INSERT INTO presupuesto_detalles (presupuesto_id, producto_id, cantidad, precio_unitario, subtotal)
        VALUES (:presupuesto_id, :producto_id, :cantidad, :precio_unitario, :subtotal)
    ");

    for ($i = 0; $i < count($productos); $i++) {
        $producto_id = intval($productos[$i]);
        $cantidad = floatval($cantidades[$i]);
        $precio_unitario = floatval($precios[$i]);
        $subtotal = $cantidad * $precio_unitario;

        $stmt_detalle->execute([
            ':presupuesto_id' => $presupuesto_id,
            ':producto_id' => $producto_id,
            ':cantidad' => $cantidad,
            ':precio_unitario' => $precio_unitario,
            ':subtotal' => $subtotal
        ]);

        $total += $subtotal;
    }

    // Actualizar total en presupuesto
    $stmt = $conn->prepare("UPDATE presupuestos SET total = :total WHERE id = :id");
    $stmt->execute([':total' => $total, ':id' => $presupuesto_id]);

    $conn->commit();

    header("Location: presupuestos_lista.php?exito=1");
    exit;

} catch (Exception $e) {
    $conn->rollBack();
    echo "Error al guardar presupuesto: " . $e->getMessage();
} 