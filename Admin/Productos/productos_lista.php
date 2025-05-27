<?php include '../header.php'; ?>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Basic Tables</h4>
              <div class="d-flex justify-content-end">
                <a href="crear_producto.php" class="btn btn-primary mb-3">
                  <i class="bx bx-plus"></i> Crear producto
                </a>
              </div>
              
              <div class="card">
                <h5 class="card-header">Productos</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      <?php foreach ($productos as $producto): ?>
                      <tr>
                        <td>
                          <i class="fab fa-box fa-lg text-primary me-3"></i> 
                          <strong><?= htmlspecialchars($producto['nombre']) ?></strong>
                        </td>
                        <td>$<?= number_format($producto['precio'], 2) ?></td>
                        
                        <td><?= $producto['stock'] ?></td>   
                        <td>
                          <?php if (!empty($producto['imagen'])): ?>
                              <a href="../uploads/<?= htmlspecialchars($producto['imagen']) ?>" target="_blank">
                                <img src="../uploads/<?= htmlspecialchars($producto['imagen']) ?>" alt="Foto" width="60">
                              </a>
                          <?php else: ?>
                              <span class="text-muted">Sin imagen</span>
                          <?php endif; ?>
                        </td>                   
                        
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="editar_producto.php?id=<?= $producto['id'] ?>">
                                <i class="bx bx-edit-alt me-1"></i> Editar
                              </a>
                              <a class="dropdown-item" href="eliminar_producto.php?id=<?= $producto['id'] ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?')">
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
