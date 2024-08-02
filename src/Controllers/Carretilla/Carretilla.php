<?php
if (isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['precio']) && isset($_POST['cantidad'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array();
    }

    $_SESSION['carrito'][$id] = array(
        'nombre' => $nombre,
        'precio' => $precio,
        'cantidad' => $cantidad
    );

    echo 'Producto agregado al carrito.';
} else {
    echo 'Datos del producto incompletos.';
}


