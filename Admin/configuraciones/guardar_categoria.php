<?php
// Incluir conexión a la base de datos
include '../includes/db.php';


// Verifica si se enviaron todos los datos requeridos
if (
    isset($_POST['CategoriaName'],
          $_POST['estatus'])
) {
    // Sanitizar y guardar los valores recibidos
    $nombre = trim($_POST['CategoriaName']);
    
    $estatus = trim($_POST['estatus']);


    try {
        $sql = "INSERT INTO categorias (nombre, estatus)
                VALUES (:nombre, :estatus)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        
        $stmt->bindParam(':estatus', $estatus);
        $stmt->execute();

        // Redirige a la lista de productos
        header("Location: categoria_lista.php?mensaje=categoria_creada");
        exit();
    } catch (PDOException $e) {
        echo "Error al guardar la categoria: " . $e->getMessage();
    }
} else {
    echo "Faltan datos obligatorios.";
}
?>
