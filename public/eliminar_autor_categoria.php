<?php
include_once '../config/db.php';

$id = $_GET['id'] ?? null;
$tipo = $_GET['tipo'] ?? null;

if ($id && $tipo) {
    if ($tipo == 'autor') {
        $stmt = $pdo->prepare("DELETE FROM autores WHERE id = :id");
        $stmt->execute(['id' => $id]);
    } elseif ($tipo == 'categoria') {
        $stmt = $pdo->prepare("DELETE FROM categorias WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    header("Location: /biblioteca/public/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar</title>
</head>
<body>
    <p>La eliminación fue exitosa. <a href="/biblioteca/public/index.php">Volver a la página principal</a></p>
</body>
</html>
