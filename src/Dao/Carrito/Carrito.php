<?php

namespace Dao\Carrito;

use Dao\Table;

class Carrito extends Table
{
    public function guardarFactura($carrito, $total)
    {

        $sqlstr = "INSERT INTO factura VALUES ";
        $params = [];
        $registros = self::executeNonQuery($sqlstr, $params);
        return $registros;
    }
}
