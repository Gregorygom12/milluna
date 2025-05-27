<?php include '../header.php'; 

$pagina = $_GET['pagina'] ?? 1;
$limite = 10;
$offset = ($pagina - 1) * $limite;

// Consulta para traer presupuestos
$stmt = $conn->prepare("SELECT * FROM categorias LIMIT :limite OFFSET :offset");
$stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
$stmt->execute();
$categorias = $stmt->fetchAll();

// Total de registros para paginación
$total = $conn->query("SELECT COUNT(*) FROM marcas")->fetchColumn();
$totalPaginas = ceil($total / $limite);


?>


    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
            

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Basic Tables</h4>              
            <div class="card">
                <h5 class="card-header">Marcas</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Estatus</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <?php foreach ($categorias as $categoria): ?>
                            <tr>
                                <td>
                                <i class="fab fa-box fa-lg text-primary me-3"></i> 
                                <strong><?= htmlspecialchars($categoria['nombre']) ?></strong>
                                </td>
                                <td><?= $categoria['estatus'] ?></td>                        
                                <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="editar_categoria.php?id=<?= $categoria['id'] ?>">
                                            <i class="bx bx-edit-alt me-1"></i>Editar
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
