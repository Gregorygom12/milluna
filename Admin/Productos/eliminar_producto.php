<?php
include '../includes/db.php'; // o la ruta correcta a tu header que incluya db.php

// Validar que se recibió el ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID de producto no proporcionado.');
}

$id = (int) $_GET['id']; // Asegurar que es un número

// Preparar y ejecutar el DELETE
$stmt = $conn->prepare("DELETE FROM productos WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

if ($stmt->execute()) {
    header("Location: productos_lista.php?mensaje=eliminado");
    exit;
} else {
    echo "Error al eliminar el producto.";
}
?>
