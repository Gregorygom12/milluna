<?php
include '../includes/db.php';

if (
    isset($_POST['id'], $_POST['ArtName'], $_POST['descriptionArt'], $_POST['priceArt'],
          $_POST['estatus'], $_POST['stock'], $_POST['categoria_id'], $_POST['marca_id'])
) {
    $id = intval($_POST['id']);
    $nombre = trim($_POST['ArtName']);
    $descripcion = trim($_POST['descriptionArt']);
    $precio = floatval($_POST['priceArt']);
    $estatus = trim($_POST['estatus']);
    $stock = intval($_POST['stock']);
    $categoria_id = intval($_POST['categoria_id']);
    $marca_id = intval($_POST['marca_id']);

    $nombre_imagen = null;

    // Verificar si se subió una nueva imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['imagen']['tmp_name'];
        $nombre_original = basename($_FILES['imagen']['name']);
        $extension = strtolower(pathinfo($nombre_original, PATHINFO_EXTENSION));
        $permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($extension, $permitidas)) {
            $nombre_imagen = uniqid('img_') . '.' . $extension;
            $ruta_destino = '../uploads/' . $nombre_imagen;
            move_uploaded_file($tmp_name, $ruta_destino);
        } else {
            echo "Formato de imagen no permitido.";
            exit;
        }
    }

    try {
        // Si se subió imagen, actualiza también la columna imagen
        if ($nombre_imagen) {
            $sql = "UPDATE productos SET nombre = :nombre, descripcion = :descripcion, precio = :precio,
                    estatus = :estatus, stock = :stock, categoria_id = :categoria_id,
                    marca_id = :marca_id, imagen = :imagen
                    WHERE id = :id";
        } else {
            $sql = "UPDATE productos SET nombre = :nombre, descripcion = :descripcion, precio = :precio,
                    estatus = :estatus, stock = :stock, categoria_id = :categoria_id,
                    marca_id = :marca_id
                    WHERE id = :id";
        }

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':estatus', $estatus);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':categoria_id', $categoria_id);
        $stmt->bindParam(':marca_id', $marca_id);
        $stmt->bindParam(':id', $id);

        if ($nombre_imagen) {
            $stmt->bindParam(':imagen', $nombre_imagen);
        }

        $stmt->execute();

        header("Location: productos_lista.php?mensaje=producto_actualizado");
        exit;
    } catch (PDOException $e) {
        echo "Error al actualizar el producto: " . $e->getMessage();
    }
} else {
    echo "Faltan datos obligatorios.";
}
?>
