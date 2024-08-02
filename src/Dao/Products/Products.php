<?php

namespace Dao\Products;

class Products extends \Dao\Table
{
    public static function createProductosFarmacia(
        $nombreProducto,
        $precioProducto,
        $cantidadProducto,
        $imagenProducto,
        $estadoProducto

    ) {
        $InsSql = "INSERT INTO productos (nombreProducto, precioProducto, cantidadProducto, imagenProducto, estadoProducto)
           VALUES (:nombreProducto, :precioProducto, :cantidadProducto, :imagenProducto, :estadoProducto);";
        $insParams = [
            'nombreProducto' => $nombreProducto,
            'precioProducto' => $precioProducto,
            'cantidadProducto' => $cantidadProducto,
            'imagenProducto' => $imagenProducto,
            'estadoProducto' => $estadoProducto
        ];

        return self::executeNonQuery($InsSql, $insParams);
    }

    public static function updateProductosFarmacia(
        $idProducto,
        $nombreProducto,
        $precioProducto,
        $cantidadProducto,
        $imagenProducto,
        $estadoProducto
    ) {
        $UpdSql = "UPDATE productos SET nombreProducto = :nombreProducto, precioProducto = :precioProducto, 
        cantidadProducto = :cantidadProducto, imagenProducto = :imagenProducto, estadoProducto = :estadoProducto WHERE idProducto = :idProducto;";
        $updParams = [
            'idProducto' => $idProducto,
            'nombreProducto' => $nombreProducto,
            'precioProducto' => $precioProducto,
            'cantidadProducto' => $cantidadProducto,
            'imagenProducto' => $imagenProducto,
            'estadoProducto' => $estadoProducto
        ];

        return self::executeNonQuery($UpdSql, $updParams);
    }

    public static function deleteProductosFarmacia(string $idProducto)
    {
        $sqlstr = "DELETE FROM productos WHERE idProducto = :idProducto;";
        $params = ["idProducto" => $idProducto];
        return self::executeNonQuery($sqlstr, $params);
    }


    public static function readAllProductosFarmacia($filter = '')
    {
        $sqlstr = "SELECT * FROM productos where nombreProducto like :filter;";
        $params = array('filter' => "%" . $filter . "%");
        return self::obtenerRegistros($sqlstr, $params);
    }

    public static function readProductosFarmacia($idProducto)
    {
        $sqlstr = "SELECT * from productos where idProducto = :idProducto;";
        $params = array('idProducto' => $idProducto);
        return self::obtenerUnRegistro($sqlstr, $params);
    }
}
