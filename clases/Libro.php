<?php

class Libro
{
    private $titulo;
    private $autor_id;
    private $categoria_id;
    private $disponible;
    private $id;

    public function __construct($titulo, $autor_id, $categoria_id, $disponible = true, $id = null)
    {
        $this->titulo = $titulo;
        $this->autor_id = $autor_id;
        $this->categoria_id = $categoria_id;
        $this->disponible = $disponible;
        $this->id = $id;
    }

    // Guardar y actualizar
    public function guardar($pdo)
    {
        if ($this->id) {
            $stmt = $pdo->prepare("UPDATE libros SET titulo = ?, autor_id = ?, categoria_id = ?, disponible = ? WHERE id = ?");
            $stmt->execute([$this->titulo, $this->autor_id, $this->categoria_id, $this->disponible, $this->id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO libros (titulo, autor_id, categoria_id, disponible) VALUES (?, ?, ?, ?)");
            $stmt->execute([$this->titulo, $this->autor_id, $this->categoria_id, $this->disponible]);
        }
    }

    // Eliminar
    public function eliminar($pdo)
    {
        $stmt = $pdo->prepare("DELETE FROM libros WHERE id = ?");
        $stmt->execute([$this->id]);
    }
}
