<?php include '../header.php'; 

if (!isset($_GET['id'])) {
    echo "ID de Categoria no especificado.";
    exit;
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM categorias WHERE id = ?");
$stmt->execute([$id]);
$categorias = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$categorias) {
    echo "categoria no encontrada.";
    exit;
}


?>
<div class="container mt-5">
    <h2>Editar categorias</h2>

    <div class="col-xl mt-5">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Editar categorias</h5>
                <!-- <small class="text-muted float-end">Default label</small> -->
            </div>
            <div class="card-body">
                <form action="actualizar_categoria.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $categorias['id'] ?>">
                    <div class="mb-3">
                        <label class="form-label" for="CategoriaName">Nombre de la categorias</label>
                        <input type="text" class="form-control" id="CategoriaName" name="CategoriaName" value="<?= htmlspecialchars($categorias['nombre']) ?>"/>
                    </div>                    
                    <div class="mb-3">
                        <label class="form-label" for="estatus">Estatus</label>
                        <select class="form-control" id="estatus" name="estatus" required>
                            <option value="activo" <?= $categorias['estatus'] == 'activo' ? 'selected' : '' ?>>Activo</option>
                            <option value="inactivo" <?= $categorias['estatus'] == 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="categoria_lista.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
