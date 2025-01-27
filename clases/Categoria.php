<?php

class Categoria
{
    private $nombre;
    private $id;

    public function __construct($nombre, $id = null)
    {
        $this->nombre = $nombre;
        $this->id = $id;
    }

    // Guardar y actualizar
    public function guardar($pdo)
    {
        if ($this->id) {
            $stmt = $pdo->prepare("UPDATE categorias SET nombre = ? WHERE id = ?");
            $stmt->execute([$this->nombre, $this->id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO categorias (nombre) VALUES (?)");
            $stmt->execute([$this->nombre]);
        }
    }

    // Eliminar
    public function eliminar($pdo)
    {
        $stmt = $pdo->prepare("DELETE FROM categorias WHERE id = ?");
        $stmt->execute([$this->id]);
    }
}
