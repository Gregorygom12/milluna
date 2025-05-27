<?php

include __DIR__ . '/../config.php';        // Subes un nivel desde la carpeta actual
include ROOT_PATH . 'includes/db.php';     // Ya puedes usar ROOT_PATH


$termino = $_GET['term'] ?? '';

if (!empty($termino)) {
    $stmt = $conn->prepare("SELECT id, nombre, precio, stock FROM productos WHERE nombre LIKE :termino LIMIT 10");
    $stmt->execute(['termino' => "%$termino%"]);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($resultados);
}
?>
