<?php
include_once '../config/db.php';
include_once '../clases/Libro.php';
include_once '../clases/Autor.php';
include_once '../clases/Categoria.php';


$stmt = $pdo->query("SELECT * FROM autores");
$autores = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt = $pdo->query("SELECT * FROM categorias");
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);


if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM libros WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $libro = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$libro) {
        die('El libro no existe.');
    }
} else {
    $libro = null;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $autor_id = $_POST['autor_id'];
    $categoria_id = $_POST['categoria_id'];
    $disponible = isset($_POST['disponible']) ? 1 : 0;

    $libroObj = new Libro($titulo, $autor_id, $categoria_id, $disponible, $libro['id'] ?? null);
    $libroObj->guardar($pdo);

    echo "Libro guardado con éxito!";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar / Editar Libro</title>
</head>
<body>
    <h1><?= $libro ? 'Editar' : 'Agregar' ?> Libro</h1>

    <form method="POST" action="">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" value="<?= $libro['titulo'] ?? '' ?>" required><br>

        <label for="autor_id">Autor:</label>
        <select name="autor_id" id="autor_id" required>
            <?php foreach ($autores as $autor): ?>
                <option value="<?= $autor['id'] ?>" <?= $libro && $libro['autor_id'] == $autor['id'] ? 'selected' : '' ?>><?= $autor['nombre'] ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="categoria_id">Categoría:</label>
        <select name="categoria_id" id="categoria_id" required>
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?= $categoria['id'] ?>" <?= $libro && $libro['categoria_id'] == $categoria['id'] ? 'selected' : '' ?>><?= $categoria['nombre'] ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="disponible">Disponible:</label>
        <input type="checkbox" name="disponible" id="disponible" <?= $libro && $libro['disponible'] ? 'checked' : '' ?>><br>

        <button type="submit"><?= $libro ? 'Actualizar' : 'Agregar' ?> Libro</button>
    </form>
    <a href="/biblioteca/public/index.php">Volver a la lista</a>
</body>
</html>
