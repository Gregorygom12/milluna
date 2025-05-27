<?php

include __DIR__ . '/../config.php';        // Subes un nivel desde la carpeta actual
include ROOT_PATH . 'includes/db.php';     // Ya puedes usar ROOT_PATH

$q = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($q !== '') {
    $stmt = $conn->prepare("SELECT id, nombre, correo FROM clientes WHERE nombre LIKE :q LIMIT 10");
    $stmt->execute(['q' => "%$q%"]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}
?>
