<?php
include_once '../config/db.php';
include_once '../clases/Libro.php';


if (!isset($_GET['id'])) {
    die('ID de libro no especificado.');
}

$libro_id = $_GET['id'];


$stmt = $pdo->prepare("SELECT * FROM libros WHERE id = ?");
$stmt->execute([$libro_id]);
$libro = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$libro) {
    die('El libro no existe.');
}


$libroObj = new Libro($libro['titulo'], $libro['autor_id'], $libro['categoria_id'], $libro['disponible'], $libro['id']);
$libroObj->eliminar($pdo);

echo "Libro eliminado con éxito!";

header("Location: /biblioteca/public/index.php"); 
?>
