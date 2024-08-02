<?php

namespace Dao\Productos;

use Dao\Table;

class Productos extends Table
{
  public static function obtenerProductos()
  {
    $sqlstr = "SELECT idProducto, nombreProducto, precioProducto, cantidadProducto, imagenProducto FROM productos WHERE cantidadProducto > 0";
    $params = [];
    $registros = self::obtenerRegistros($sqlstr, $params);
    return $registros;
  }
}
