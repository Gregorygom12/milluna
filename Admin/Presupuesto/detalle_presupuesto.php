<?php
include '../header.php';


if (!isset($_GET['id'])) {
  echo "<div class='alert alert-danger m-4'>Presupuesto no especificado.</div>";
  exit;
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT p.id, p.fecha, p.total, c.nombre AS cliente_nombre 
                        FROM presupuestos p 
                        JOIN clientes c ON p.cliente_id = c.id 
                        WHERE p.id = ?");
$stmt->execute([$id]);
$presupuesto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$presupuesto) {
  echo "<div class='alert alert-warning m-4'>Presupuesto no encontrado.</div>";
  exit;
}

$stmtDetalle = $conn->prepare("SELECT nombre_producto, cantidad, precio_unitario 
                              FROM presupuesto_detalle WHERE presupuesto_id = ?");
$stmtDetalle->execute([$id]);
$detalles = $stmtDetalle->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h3 class="mb-0">Detalle del Presupuesto <span class="badge bg-light text-primary">#<?= $presupuesto['id'] ?></span></h3>
    </div>
    <br>
    <div class="card-body">
      <div class="row mb-4">
        <div class="col-md-4">
          <h5>Cliente:</h5>
          <p><?= htmlspecialchars($presupuesto['cliente_nombre']) ?></p>
        </div>
        <div class="col-md-4">
          <h5>Fecha:</h5>
          <p><?= htmlspecialchars($presupuesto['fecha']) ?></p>
        </div>
        <div class="col-md-4 text-md-end">
          <h5>Total:</h5>
          <p class="fs-4 fw-bold text-success">$<?= number_format($presupuesto['total'], 2) ?></p>
        </div>
      </div>

      <h4>Productos</h4>
      <table class="table table-hover table-bordered align-middle">
        <thead class="table-secondary">
          <tr>
            <th>Producto</th>
            <th class="text-center">Cantidad</th>
            <th class="text-end">Precio Unitario</th>
            <th class="text-end">Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($detalles as $item): 
            $subtotal = $item['cantidad'] * $item['precio_unitario'];
          ?>
          <tr>
            <td><?= htmlspecialchars($item['nombre_producto']) ?></td>
            <td class="text-center"><?= $item['cantidad'] ?></td>
            <td class="text-end">$<?= number_format($item['precio_unitario'], 2) ?></td>
            <td class="text-end">$<?= number_format($subtotal, 2) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <div class="text-end">
        <a href="presupuestos_lista.php" class="btn btn-outline-primary mt-3">
          <i class="bx bx-arrow-back"></i> Volver a la lista
        </a>
      </div>
    </div>
  </div>
</div>

<?php include '../footer.php'; ?>
