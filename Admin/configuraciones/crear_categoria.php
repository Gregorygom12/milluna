<?php include '../header.php'; 

?>
<div class="container mt-5">
    <h2>Crear nueva Categoria</h2>

    <div class="col-xl mt-5">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Introduzca los datos de la nueva Categoria</h5>
                <!-- <small class="text-muted float-end">Default label</small> -->
            </div>
            <div class="card-body">
                <form action="guardar_categoria.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label" for="CategoriaName">Nombre de la Categoria</label>
                        <input type="text" class="form-control" id="CategoriaName" name="CategoriaName" placeholder="Nombre de la Categoria..." />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="estatus">Estatus</label>
                        <select class="form-control" id="estatus" name="estatus" required>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="productos_lista.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
