<?php
include_once '../config/db.php';
include_once '../clases/Libro.php';
include_once '../clases/Autor.php';
include_once '../clases/Categoria.php';

//Lista de libros
$stmt = $pdo->query("SELECT * FROM libros");
$libros = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->query("SELECT * FROM autores");
$autores = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->query("SELECT * FROM categorias");
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);


$libros_con_detalles = [];
foreach ($libros as $libro) {

    $autor_stmt = $pdo->prepare("SELECT nombre FROM autores WHERE id = :autor_id");
    $autor_stmt->execute(['autor_id' => $libro['autor_id']]);
    $autor = $autor_stmt->fetch(PDO::FETCH_ASSOC);


    $categoria_stmt = $pdo->prepare("SELECT nombre FROM categorias WHERE id = :categoria_id");
    $categoria_stmt->execute(['categoria_id' => $libro['categoria_id']]);
    $categoria = $categoria_stmt->fetch(PDO::FETCH_ASSOC);


    $libros_con_detalles[] = [
        'id' => $libro['id'],
        'titulo' => $libro['titulo'],
        'autor' => $autor ? $autor['nombre'] : 'Desconocido',
        'categoria' => $categoria ? $categoria['nombre'] : 'Desconocida',
    ];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Biblioteca</title>
</head>
<body>
    <h1>Bienvenido a la Biblioteca</h1>


    <h2>Libros Existentes</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Libro</th>
                <th>Categoría</th>
                <th>Autor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($libros_con_detalles as $libro): ?>
                <tr>
                    <td><?= $libro['id'] ?></td>
                    <td><?= htmlspecialchars($libro['titulo']) ?></td>
                    <td><?= htmlspecialchars($libro['categoria']) ?></td>
                    <td><?= htmlspecialchars($libro['autor']) ?></td>
                    <td>
                        <a href="agregar_editar_libro.php?id=<?= $libro['id'] ?>">Editar</a> | 
                        <a href="eliminar_libro.php?id=<?= $libro['id'] ?>">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br>
    <a href="agregar_editar_libro.php">Agregar Libro</a>

    <h2>Autores</h2>
    <ul>
        <?php foreach ($autores as $autor): ?>
            <li>
                <?= $autor['nombre'] ?> - 
                <a href="agregar_editar_autor_categoria.php?id=<?= $autor['id'] ?>&tipo=autor">Editar</a> | 
                <a href="eliminar_autor_categoria.php?id=<?= $autor['id'] ?>&tipo=autor">Eliminar</a>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="agregar_editar_autor_categoria.php?tipo=autor">Agregar Autor</a>

    <h2>Categorías</h2>
    <ul>
        <?php foreach ($categorias as $categoria): ?>
            <li>
                <?= $categoria['nombre'] ?> - 
                <a href="agregar_editar_autor_categoria.php?id=<?= $categoria['id'] ?>&tipo=categoria">Editar</a> | 
                <a href="eliminar_autor_categoria.php?id=<?= $categoria['id'] ?>&tipo=categoria">Eliminar</a>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="agregar_editar_autor_categoria.php?tipo=categoria">Agregar Categoría</a>
</body>
</html>
