<?php
include_once '../config/db.php';
include_once '../clases/Autor.php';
include_once '../clases/Categoria.php';

$id = $_GET['id'] ?? null;
$tipo = $_GET['tipo'] ?? 'autor';


$nombre = '';
$fecha_nacimiento = '';
if ($id && $tipo == 'autor') {
    // Obtener autor para editar
    $stmt = $pdo->prepare("SELECT * FROM autores WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $autor = $stmt->fetch(PDO::FETCH_ASSOC);
    $nombre = $autor['nombre'] ?? '';
    $fecha_nacimiento = $autor['fecha_nacimiento'] ?? '';
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
    
    if ($tipo == 'autor') {
        if ($id) {
            // Actualizar autor
            $stmt = $pdo->prepare("UPDATE autores SET nombre = :nombre, fecha_nacimiento = :fecha_nacimiento WHERE id = :id");
            $stmt->execute(['nombre' => $nombre, 'fecha_nacimiento' => $fecha_nacimiento, 'id' => $id]);
        } else {
            // Agregar autor
            $stmt = $pdo->prepare("INSERT INTO autores (nombre, fecha_nacimiento) VALUES (:nombre, :fecha_nacimiento)");
            $stmt->execute(['nombre' => $nombre, 'fecha_nacimiento' => $fecha_nacimiento]);
        }
    } else {
        if ($id) {
            // Actualizar categoría
            $stmt = $pdo->prepare("UPDATE categorias SET nombre = :nombre WHERE id = :id");
            $stmt->execute(['nombre' => $nombre, 'id' => $id]);
        } else {
            // Agregar categoría
            $stmt = $pdo->prepare("INSERT INTO categorias (nombre) VALUES (:nombre)");
            $stmt->execute(['nombre' => $nombre]);
        }
    }

    header("Location: /biblioteca/public/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar/Editar <?= $tipo == 'autor' ? 'Autor' : 'Categoría' ?></title>
</head>
<body>
    <h1><?= $id ? 'Editar' : 'Agregar' ?> <?= $tipo == 'autor' ? 'Autor' : 'Categoría' ?></h1>
    
    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre) ?>" required>
        
        <?php if ($tipo == 'autor'): ?>
            <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= htmlspecialchars($fecha_nacimiento) ?>" required>
        <?php endif; ?>
        
        <button type="submit"><?= $id ? 'Actualizar' : 'Agregar' ?></button>
    </form>
    
    <a href="/biblioteca/public/index.php">Volver a la lista</a>
</body>
</html>
