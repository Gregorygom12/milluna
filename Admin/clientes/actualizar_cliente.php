<?php

include __DIR__ . '/../config.php';        // Subes un nivel desde la carpeta actual
include ROOT_PATH . 'includes/db.php';     // Ya puedes usar ROOT_PATH
if (
    isset($_POST['id'], $_POST['ClienteName'], $_POST['ClienteDoc'], $_POST['ClientePhone'],
          $_POST['ClienteMail'])
) {
    $id = intval($_POST['id']);
    $ClienteName = trim($_POST['ClienteName']);
    $ClienteDoc = trim($_POST['ClienteDoc']);
    $ClientePhone = trim($_POST['ClientePhone']);
    $ClienteMail = trim($_POST['ClienteMail']);


    try {

        $sql = "UPDATE clientes SET nombre = :nombre, documento = :documento, telefono = :telefono,
            correo = :correo
            WHERE id = :id";


        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $ClienteName);
        $stmt->bindParam(':documento', $ClienteDoc);
        $stmt->bindParam(':telefono', $ClientePhone);
        $stmt->bindParam(':correo', $ClienteMail);
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        header("Location: clientes_lista.php?mensaje=cliente_actualizado");
        exit;
    } catch (PDOException $e) {
        echo "Error al actualizar el cliente: " . $e->getMessage();
    }
} else {
    echo "Faltan datos obligatorios.";
}
?>
