<?php include '../header.php'; ?>
<?php
$sql = "SELECT id, nombre FROM categorias";
$stmt = $conn->prepare($sql);
$stmt->execute();
$resultadoCat = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT id, nombre FROM marcas";
$stmt = $conn->prepare($sql);
$stmt->execute();
$resultadoMar = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="container mt-5">
    <h2>Crear nuevo producto</h2>

    <div class="col-xl mt-5">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Introduzca los datos del nuevo producto</h5>
                <!-- <small class="text-muted float-end">Default label</small> -->
            </div>
            <div class="card-body">
                <form action="guardar_producto.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label" for="ArtName">Nombre del Articulo</label>
                        <input type="text" class="form-control" id="ArtName" name="ArtName" placeholder="Nombre del Articulo..." />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="descriptionArt">Descripcion</label>
                        <input type="text" class="form-control" id="descriptionArt" Name="descriptionArt" placeholder="Descripcion..." />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="priceArt">Precio</label>
                        <div class="input-group input-group-merge">
                            <input
                              type="number"
                              id="priceArt"
                              name="priceArt"
                              class="form-control"
                              placeholder=""
                              aria-label="john.doe"
                              step="0.01"
                            />
                            <!-- <span class="input-group-text" id="priceArt2">@example.com</span> -->
                        </div>
                        <!-- <div class="form-text">You can use letters, numbers & periods</div> -->
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="estatus">Estatus</label>
                        <select class="form-control" id="estatus" name="estatus" required>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="stock">Stock</label>
                        <input type="number" class="form-control" id="stock" name="stock" min="0" value="0" required />
                    </div>
                    <div class="mb-3">
                        <label for="categoria_id">Categoría:</label>
                        <select name="categoria_id" id="categoria_id" class="form-select" required>
                        <option value="">-- Selecciona una categoría --</option>
                        <?php foreach ($resultadoCat as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['nombre']) ?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="marca_id">Marca:</label>
                        <select name="marca_id" id="marca_id" class="form-select" required>
                        <option value="">-- Selecciona una Marca --</option>
                        <?php foreach ($resultadoMar as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['nombre']) ?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>
                     <div class="mb-3">
                        <label for="imagen">Imagen del producto:</label>
                        <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                    </div>


                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="productos_lista.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
