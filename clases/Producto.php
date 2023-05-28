<?php 

class Producto {
    private $nombre;
    private $descripcion;
    private $precio;
    private $cantidadStock;

    public function __construct($nombre, $descripcion, $precio, $cantidadStock) {
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->cantidadStock = $cantidadStock;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function getCantidadStock() {
        return $this->cantidadStock;
    }

    public function setCantidadStock($cantidadStock) {
        $this->cantidadStock = $cantidadStock;
    }
}




?>


