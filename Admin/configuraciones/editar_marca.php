<?php include '../header.php'; 

if (!isset($_GET['id'])) {
    echo "ID de Marca no especificado.";
    exit;
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM marcas WHERE id = ?");
$stmt->execute([$id]);
$marcas = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$marcas) {
    echo "Marca no encontrada.";
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
    <h2>Editar Marca</h2>

    <div class="col-xl mt-5">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Editar Marca</h5>
                <!-- <small class="text-muted float-end">Default label</small> -->
            </div>
            <div class="card-body">
                <form action="actualizar_marca.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $marcas['id'] ?>">
                    <div class="mb-3">
                        <label class="form-label" for="MarcaName">Nombre de la Marca</label>
                        <input type="text" class="form-control" id="MarcaName" name="MarcaName" value="<?= htmlspecialchars($marcas['nombre']) ?>"/>
                    </div>                    
                    <div class="mb-3">
                        <label class="form-label" for="estatus">Estatus</label>
                        <select class="form-control" id="estatus" name="estatus" required>
                            <option value="activo" <?= $marcas['estatus'] == 'activo' ? 'selected' : '' ?>>Activo</option>
                            <option value="inactivo" <?= $marcas['estatus'] == 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="marca_lista.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
