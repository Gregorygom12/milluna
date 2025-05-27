<?php include '../header.php'; 

if (!isset($_GET['id'])) {
    echo "ID de cliente no especificado.";
    exit;
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM clientes WHERE id = ?");
$stmt->execute([$id]);
$clientes = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$clientes) {
    echo "cliente no encontrado.";
    exit;
}


?>
<div class="container mt-5">
    <h2>Editar Cliente</h2>

    <div class="col-xl mt-5">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Introduzca los datos del cliente</h5>
                <!-- <small class="text-muted float-end">Default label</small> -->
            </div>
            <div class="card-body">
                <form action="actualizar_cliente.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $clientes['id'] ?>">
                    <div class="mb-3">
                        <label class="form-label" for="ClienteName">Nombre del cliente</label>
                        <input type="text" class="form-control" id="ClienteName" name="ClienteName" value="<?= htmlspecialchars($clientes['nombre']) ?>"/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="ClienteDoc">Documento</label>
                        <input type="text" class="form-control" id="ClienteDoc" Name="ClienteDoc" value="<?= htmlspecialchars($clientes['documento']) ?>"/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="ClientePhone">Telefono</label>
                        <input type="text" class="form-control" id="ClientePhone" Name="ClientePhone" value="<?= htmlspecialchars($clientes['telefono']) ?>"/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="ClienteMail">Correo</label>
                        <input type="text" class="form-control" id="ClienteMail" Name="ClienteMail" value="<?= htmlspecialchars($clientes['correo']) ?>"/>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="productos_lista.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include '../footer.php'; 
