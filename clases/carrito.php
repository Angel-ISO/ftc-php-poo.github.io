<?php 
class CarritoCompras {
    private $productos;

    public function __construct() {
        $this->productos = array();
    }

    public function agregarProducto($producto) {
        $this->productos[] = $producto;
    }

    public function eliminarProducto($indice) {
        unset($this->productos[$indice]);
        $this->productos = array_values($this->productos);
    }

    public function calcularTotal() {
        $total = 0;
        foreach ($this->productos as $producto) {
            $total += $producto->getPrecio();
        }
        return $total;
    }

    public function getProductos() {
        return $this->productos;
    }

    public function setProductos($productos) {
        $this->productos = $productos;
    }
}





?>