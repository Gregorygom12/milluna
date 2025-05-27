<?php
// Incluir conexión a la base de datos
include '../includes/db.php';


// Verifica si se enviaron todos los datos requeridos
if (
    isset($_POST['MarcaName'],
          $_POST['estatus'])
) {
    // Sanitizar y guardar los valores recibidos
    $nombre = trim($_POST['MarcaName']);
    
    $estatus = trim($_POST['estatus']);


    try {
        $sql = "INSERT INTO marcas (nombre, estatus)
                VALUES (:nombre, :estatus)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        
        $stmt->bindParam(':estatus', $estatus);
        $stmt->execute();

        // Redirige a la lista de productos
        header("Location: marca_lista.php?mensaje=marca_creado");
        exit();
    } catch (PDOException $e) {
        echo "Error al guardar la marca: " . $e->getMessage();
    }
} else {
    echo "Faltan datos obligatorios.";
}
?>
