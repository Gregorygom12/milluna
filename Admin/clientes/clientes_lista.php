<?php include '../header.php'; 

// Ejemplo de obtención de clientes (ajusta a tu estructura real)
$stmt = $conn->prepare("SELECT * FROM clientes ORDER BY id DESC");
$stmt->execute();
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Paginación (opcional)
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$porPagina = 10;
$totalClientes = count($clientes);
$totalPaginas = ceil($totalClientes / $porPagina);
$clientes = array_slice($clientes, ($pagina - 1) * $porPagina, $porPagina);

?>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Basic Tables</h4>              
              <div class="card">
                <h5 class="card-header">Clientes</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Id</th>
                        <th>Documento</th>
                        <th>Nombre</th>
                        <th>Status</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      <?php foreach ($clientes as $cliente): ?>
                      <tr>
                        <td>
                          <i class="fab fa-box fa-lg text-primary me-3"></i> 
                          <strong><?= htmlspecialchars($cliente['id']) ?></strong>
                        </td>
                        <td><?= htmlspecialchars($cliente['documento'], 2) ?></td>
                        
                        <td><?= $cliente['nombre'] ?></td>   
                        <td><?= $cliente['estatus'] ?></td>   
                 
                        
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="editar_cliente.php?id=<?= $cliente['id'] ?>">
                                <i class="bx bx-edit-alt me-1"></i> Editar
                              </a>
                              <a class="dropdown-item" href="eliminar_cliente.php?id=<?= $cliente['id'] ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este cliente?')">
                                <i class="bx bx-trash me-1"></i> Eliminar
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

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  ©
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  , made with ❤️ by
                  <a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder">ThemeSelection</a>
                </div>
                <div>
                  <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                  <a href="https://themeselection.com/" target="_blank" class="footer-link me-4">More Themes</a>

                  <a
                    href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/"
                    target="_blank"
                    class="footer-link me-4"
                    >Documentation</a
                  >

                  <a
                    href="https://github.com/themeselection/sneat-html-admin-template-free/issues"
                    target="_blank"
                    class="footer-link me-4"
                    >Support</a
                  >
                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
<?php include '../footer.php'; ?>
