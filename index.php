<?php

include_once 'clases/Producto.php';
include_once 'clases/Cliente.php';
include_once 'clases/Factura.php';

session_start();

if (isset($_POST['submitCliente'])) {
    $nombreCliente = $_POST['nombre'];
    $direccionCliente = $_POST['direccion'];
    $contactoCliente = $_POST['contacto'];

    $cliente = new Cliente($nombreCliente, $direccionCliente, $contactoCliente);

    $_SESSION['cliente'] = $cliente;

    header('Location: index.php?step=productos');
    exit;
}

if (isset($_POST['submitProductos'])) {
    $productosSeleccionados = $_POST['productos'];
    $cantidadesProductos = $_POST['cantidades'];

    $productos = array();

    foreach ($productosSeleccionados as $indice => $productoSeleccionado) {
        $nombreProducto = $_POST['nombre_producto'][$indice];
        $descripcionProducto = $_POST['descripcion_producto'][$indice];
        $precioProducto = $_POST['precio_producto'][$indice];
        $cantidadProducto = $cantidadesProductos[$indice];

        $productos[] = new Producto($nombreProducto, $descripcionProducto, $precioProducto, $cantidadProducto);
    }

    $_SESSION['productos'] = $productos;

    header('Location: index.php?step=factura');
    exit;
}

if (isset($_POST['submitFactura'])) {
    $numeroFactura = $_POST['numero_factura'];
    $fechaFactura = $_POST['fecha_factura'];

    $cliente = $_SESSION['cliente'];
    $productos = $_SESSION['productos'];

    $factura = new Factura($numeroFactura, $fechaFactura, $cliente, $productos);

    // Limpia la sesión
    session_unset();
    session_destroy();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FACTURACION</title>
</head>
<body>
    <?php if (!isset($_GET['step']) || $_GET['step'] === 'cliente') { ?>
        <!-- Formulario de ingreso de cliente -->
        <h2>Cliente</h2>
        <form method="POST" action="index.php">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required><br>

            <label for="direccion">Dirección:</label>
            <input type="text" name="direccion" required><br>

            <label for="contacto">Contacto:</label>
            <input type="text" name="contacto" required><br>

            <input type="submit" name="submitCliente" value="Siguiente">
        </form>
    <?php } elseif ($_GET['step'] === 'productos') { ?>
      <!-- Formulario de selección de productos -->
<h2>Productos</h2>
<form method="POST" action="index.php">
    <label for="cantidad_productos">Cantidad de Productos:</label>
    <input type="number" name="cantidad_productos" min="1" max="10" required><br>

    <?php
    if (isset($_POST['cantidad_productos'])) {
        $cantidadProductos = $_POST['cantidad_productos'];
        for ($i = 0; $i < $cantidadProductos; $i++) {
            ?>
            <h3>Producto <?php echo $i + 1; ?></h3>
            <label for="nombre_producto_<?php echo $i; ?>">Nombre:</label>
            <input type="text" name="nombre_producto[]" required><br>

            <label for="descripcion_producto_<?php echo $i; ?>">Descripción:</label>
            <input type="text" name="descripcion_producto[]" required><br>

            <label for="precio_producto_<?php echo $i; ?>">Precio por Unidad:</label>
            <input type="text" name="precio_producto[]" required><br>

            <label for="cantidades_<?php echo $i; ?>">Cantidad:</label>
            <input type="number" name="cantidades[]" min="1" required><br>
            <?php
        }
    } else {
        // Mostrar los campos de entrada por defecto
        for ($i = 0; $i < 1; $i++) { // Cambiar el valor de 1 a la cantidad deseada
            ?>
            <h3>Producto <?php echo $i + 1; ?></h3>
            <label for="nombre_producto_<?php echo $i; ?>">Nombre:</label>
            <input type="text" name="nombre_producto[]" required><br>

            <label for="descripcion_producto_<?php echo $i; ?>">Descripción:</label>
            <input type="text" name="descripcion_producto[]" required><br>

            <label for="precio_producto_<?php echo $i; ?>">Precio por Unidad:</label>
            <input type="text" name="precio_producto[]" required><br>

            <label for="cantidades_<?php echo $i; ?>">Cantidad:</label>
            <input type="number" name="cantidades[]" min="1" required><br>
            <?php
        }
    }
    ?>

    <input type="submit" name="submitProductos" value="Siguiente">
</form>

    <?php } elseif ($_GET['step'] === 'factura') { ?>
        <!-- Formulario de generación de factura -->
        <h2>Factura</h2>
        <form method="POST" action="index.php">
            <label for="numero_factura">Número de Factura:</label>
            <input type="text" name="numero_factura" required><br>

            <label for="fecha_factura">Fecha de Factura:</label>
            <input type="date" name="fecha_factura" required><br>

            <input type="submit" name="submitFactura" value="Generar Factura">
        </form>
    <?php } elseif (isset($factura)) { ?>
        <!-- Muestra la factura generada -->
        <h2>Aquí está tu factura</h2>
        <p>Número de Factura: <?php echo $factura->getNumeroFactura(); ?></p>
        <p>Fecha de Factura: <?php echo $factura->getFechaFactura(); ?></p>
        <p>Cliente: <?php echo $factura->getCliente()->getNombre(); ?></p>
        <h3>Productos:</h3>
        <ul>
            <?php foreach ($factura->getProductos() as $producto) { ?>
                <li>
                    <?php echo $producto->getNombre(); ?> - <?php echo $producto->getCantidad(); ?> unidades
                    <br>
                    Descripción: <?php echo $producto->getDescripcion(); ?>
                    <br>
                    Precio por Unidad: <?php echo $producto->getPrecio(); ?>
                </li>
            <?php } ?>
        </ul>
    <?php } ?>
</body>
</html>
