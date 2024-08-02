<?php

namespace Dao\Usuarios;

class Usuarios extends \Dao\Table
{
    public static function updateUsuarios(
        $idUsuario,
        $idRol,
        $estadoUsuario
    ) {
        $UpdSql = "UPDATE usuariorol SET idRol = :idRol WHERE idUsuario = :idUsuario;
                   UPDATE usuarios SET estadoUsuario = :estadoUsuario WHERE idUsuario = :idUsuario;";
        $updParams = [
            'idUsuario' => $idUsuario,
            'idRol' => $idRol,
            'estadoUsuario' => $estadoUsuario
        ];

        return self::executeNonQuery($UpdSql, $updParams);
    }

    public static function readAllUsuarios($filter = '')
    {
        $sqlstr =
            "SELECT u.idUsuario, u.nombreUsuario, u.correo, u.estadoUsuario, r.rol
        FROM usuarios u
        JOIN usuariorol ur ON u.idUsuario = ur.idUsuario
        JOIN roles r ON ur.idRol = r.idRol
        WHERE u.nombreUsuario LIKE :filter;";

        $params = array('filter' => "%" . $filter . "%");
        return self::obtenerRegistros($sqlstr, $params);
    }

    public static function readUsuario($idUsuario)
    {
        $sqlstr = "SELECT u.idUsuario, u.nombreUsuario, u.correo, u.estadoUsuario, ur.idRol
                   FROM usuarios u
                   JOIN usuariorol ur ON u.idUsuario = ur.idUsuario
                   WHERE u.idUsuario = :idUsuario;";
        $params = array('idUsuario' => $idUsuario);
        return self::obtenerUnRegistro($sqlstr, $params);
    }
}
