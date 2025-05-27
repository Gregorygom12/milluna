<?php
include '../includes/db.php';

if (
    isset($_POST['id'], $_POST['CategoriaName'],
          $_POST['estatus'])
) {
    $id = intval($_POST['id']);
    $nombre = trim($_POST['CategoriaName']);    
    $estatus = trim($_POST['estatus']);

    try {
        // Si se subió imagen, actualiza también la columna imagen

        $sql = "UPDATE categorias SET nombre = :nombre,
                estatus = :estatus
                WHERE id = :id";
        

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);        
        $stmt->bindParam(':estatus', $estatus);        
        $stmt->bindParam(':id', $id);


        $stmt->execute();

        header("Location: categoria_lista.php?mensaje=categoria_actualizada");
        exit;
    } catch (PDOException $e) {
        echo "Error al actualizar la categoria: " . $e->getMessage();
    }
} else {
    echo "Faltan datos obligatorios.";
}
?>
