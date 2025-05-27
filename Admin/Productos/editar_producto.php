<?php include '../header.php'; 

if (!isset($_GET['id'])) {
    echo "ID de producto no especificado.";
    exit;
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM productos WHERE id = ?");
$stmt->execute([$id]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$producto) {
    echo "Producto no encontrado.";
    exit;
}

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
                <form action="actualizar_producto.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                    <div class="mb-3">
                        <label class="form-label" for="ArtName">Nombre del Articulo</label>
                        <input type="text" class="form-control" id="ArtName" name="ArtName" value="<?= htmlspecialchars($producto['nombre']) ?>"/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="descriptionArt">Descripcion</label>
                        <input type="text" class="form-control" id="descriptionArt" Name="descriptionArt" value="<?= htmlspecialchars($producto['descripcion']) ?>"/>
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
                              value="<?= $producto['precio'] ?>"
                            />
                            <!-- <span class="input-group-text" id="priceArt2">@example.com</span> -->
                        </div>
                        <!-- <div class="form-text">You can use letters, numbers & periods</div> -->
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="estatus">Estatus</label>
                        <select class="form-control" id="estatus" name="estatus" required>
                            <option value="activo" <?= $producto['estatus'] == 'activo' ? 'selected' : '' ?>>Activo</option>
                            <option value="inactivo" <?= $producto['estatus'] == 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="stock">Stock</label>
                        <input type="number" class="form-control" id="stock" name="stock" min="0" value="<?= $producto['stock'] ?>" required />
                    </div>
                    <div class="mb-3">
                        <label for="categoria_id">Categoría:</label>
                        <select name="categoria_id" id="categoria_id" class="form-select" required>
                            <option value="">-- Selecciona una categoría --</option>
                            <?php foreach ($resultadoCat as $row): ?>
                                <option value="<?= $row['id'] ?>" <?= $row['id'] == $producto['categoria_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($row['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="marca_id">Marca:</label>
                        <select name="marca_id" id="marca_id" class="form-select" required>
                        <option value="">-- Selecciona una Marca --</option>
                            <?php foreach ($resultadoMar as $row): ?>
                                <option value="<?= $row['id'] ?>" <?= $row['id'] == $producto['marca_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($row['nombre']) ?>
                                </option>
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
<?php include '../footer.php'; 
