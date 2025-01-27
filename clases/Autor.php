<?php

class Autor
{
    private $nombre;
    private $fecha_nacimiento;
    private $id;

    public function __construct($nombre, $fecha_nacimiento = null, $id = null)
    {
        $this->nombre = $nombre;
        $this->fecha_nacimiento = $fecha_nacimiento;
        $this->id = $id;
    }

    // Guardar y actualizar
    public function guardar($pdo)
    {
        if ($this->id) {
            $stmt = $pdo->prepare("UPDATE autores SET nombre = ?, fecha_nacimiento = ? WHERE id = ?");
            $stmt->execute([$this->nombre, $this->fecha_nacimiento, $this->id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO autores (nombre, fecha_nacimiento) VALUES (?, ?)");
            $stmt->execute([$this->nombre, $this->fecha_nacimiento]);
        }
    }

    // Eliminar
    public function eliminar($pdo)
    {
        $stmt = $pdo->prepare("DELETE FROM autores WHERE id = ?");
        $stmt->execute([$this->id]);
    }
}
