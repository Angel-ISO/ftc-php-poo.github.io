<?php
class Factura {
    private $numero;
    private $fecha;
    private $productos;
    private $total;

    public function __construct($numero, $fecha, $productos) {
        $this->numero = $numero;
        $this->fecha = $fecha;
        $this->productos = $productos;
        $this->total = $this->calcularTotal();
    }

    public function calcularTotal() {
        $total = 0;
        foreach ($this->productos as $producto) {
            $total += $producto->getPrecio();
        }
        return $total;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function getProductos() {
        return $this->productos;
    }

    public function setProductos($productos) {
        $this->productos = $productos;
        $this->total = $this->calcularTotal();
    }

    public function getTotal() {
        return $this->total;
    }
}




?>