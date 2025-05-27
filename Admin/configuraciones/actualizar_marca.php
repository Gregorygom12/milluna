<?php
include '../includes/db.php';

if (
    isset($_POST['id'], $_POST['MarcaName'],
          $_POST['estatus'])
) {
    $id = intval($_POST['id']);
    $nombre = trim($_POST['MarcaName']);    
    $estatus = trim($_POST['estatus']);

    try {
        // Si se subió imagen, actualiza también la columna imagen

        $sql = "UPDATE marcas SET nombre = :nombre,
                estatus = :estatus
                WHERE id = :id";
        

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);        
        $stmt->bindParam(':estatus', $estatus);        
        $stmt->bindParam(':id', $id);


        $stmt->execute();

        header("Location: marca_lista.php?mensaje=marca_actualizada");
        exit;
    } catch (PDOException $e) {
        echo "Error al actualizar la marca: " . $e->getMessage();
    }
} else {
    echo "Faltan datos obligatorios.";
}
?>
