<?php include '../header.php'; 

$pagina = $_GET['pagina'] ?? 1;
$limite = 10;
$offset = ($pagina - 1) * $limite;

// Consulta para traer presupuestos
$stmt = $conn->prepare("SELECT * FROM presupuestos ORDER BY fecha DESC LIMIT :limite OFFSET :offset");
$stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
$stmt->execute();
$presupuestos = $stmt->fetchAll();

// Total de registros para paginación
$total = $conn->query("SELECT COUNT(*) FROM presupuestos")->fetchColumn();
$totalPaginas = ceil($total / $limite);


?>


    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
            

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Basic Tables</h4>              
            <div class="card">
                <h5 class="card-header">Presupuestos</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Monto</th>
                                <th>Monto</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <?php foreach ($presupuestos as $presupuesto): ?>
                            <tr>
                                <td>
                                <i class="fab fa-box fa-lg text-primary me-3"></i> 
                                <strong><?= htmlspecialchars($presupuesto['cliente_nombre']) ?></strong>
                                </td>
                                <td>$<?= number_format($presupuesto['total'], 2) ?></td>                        
                                <td><?= $presupuesto['total'] ?></td>                        
                                <td><?= $presupuesto['fecha'] ?></td>                        
                                <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="detalle_presupuesto.php?id=<?= $presupuesto['id'] ?>">
                                            <i class="bx bx-edit-alt me-1"></i> Ver detalles
                                        </a>                                    
                                    </div>
                                </div>
                                </td>

                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                            <li class="page-item <?= $i === $pagina ? 'active' : '' ?>">
                                <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
                            </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>

                </div>
            </div>

        </div>
        <!-- / Content -->

            
    </div>
    <!-- Content wrapper -->

<?php include '../footer.php'; ?>
