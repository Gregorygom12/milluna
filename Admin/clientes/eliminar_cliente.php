<?php
include __DIR__ . '/../config.php';        // Subes un nivel desde la carpeta actual
include ROOT_PATH . 'includes/db.php';     // Ya puedes usar ROOT_PATH

// Validar que se recibió el ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID de clientes no proporcionado.');
}

$id = (int) $_GET['id']; // Asegurar que es un número

// Preparar y ejecutar el DELETE
$stmt = $conn->prepare("DELETE FROM clientes WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

if ($stmt->execute()) {
    header("Location: clientes_lista.php?mensaje=eliminado");
    exit;
} else {
    echo "Error al eliminar el cliente.";
}
?>
