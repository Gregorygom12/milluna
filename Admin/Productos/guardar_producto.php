<?php
// Incluir conexión a la base de datos
include '../includes/db.php';

$nombre_imagen = null;

if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $tmp_name = $_FILES['imagen']['tmp_name'];
    $nombre_original = basename($_FILES['imagen']['name']);
    $extension = strtolower(pathinfo($nombre_original, PATHINFO_EXTENSION));

    $permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (in_array($extension, $permitidas)) {
        // Crear nombre único
        $nombre_imagen = uniqid('img_') . '.' . $extension;
        $ruta_destino = '../../uploads/' . $nombre_imagen;
        move_uploaded_file($tmp_name, $ruta_destino);
    } else {
        echo "Formato de imagen no permitido.";
        exit;
    }
}


// Verifica si se enviaron todos los datos requeridos
if (
    isset($_POST['ArtName'], $_POST['descriptionArt'], $_POST['priceArt'],
          $_POST['estatus'], $_POST['stock'], $_POST['categoria_id'], $_POST['marca_id'])
) {
    // Sanitizar y guardar los valores recibidos
    $nombre = trim($_POST['ArtName']);
    $descripcion = trim($_POST['descriptionArt']);
    $precio = floatval($_POST['priceArt']);
    $estatus = trim($_POST['estatus']);
    $stock = intval($_POST['stock']);
    $categoria_id = intval($_POST['categoria_id']);
    $marca_id = intval($_POST['marca_id']);

    try {
        $sql = "INSERT INTO productos (nombre, descripcion, precio, estatus, stock, categoria_id, marca_id,imagen)
                VALUES (:nombre, :descripcion, :precio, :estatus, :stock, :categoria_id, :marca_id, :imagen)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':estatus', $estatus);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':categoria_id', $categoria_id);
        $stmt->bindParam(':marca_id', $marca_id);
        $stmt->bindParam(':imagen', $nombre_imagen);
        $stmt->execute();

        // Redirige a la lista de productos
        header("Location: productos_lista.php?mensaje=producto_creado");
        exit();
    } catch (PDOException $e) {
        echo "Error al guardar el producto: " . $e->getMessage();
    }
} else {
    echo "Faltan datos obligatorios.";
}
?>
