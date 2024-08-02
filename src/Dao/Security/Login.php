<?php

namespace Dao\Security;

use \PDO;
use \PDOException;

class Login
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function verifyUser($correo, $contra)
    {
        try {
            // Consultar el usuario y el idRol de la tabla usuariorol
            $sql = "SELECT u.idUsuario, u.nombreUsuario, u.contra, ur.idRol 
                    FROM usuarios u 
                    JOIN usuariorol ur ON u.idUsuario = ur.idUsuario 
                    WHERE u.correo = :correo";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':correo', $correo);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar la contraseña
            if ($user && password_verify($contra, $user['contra'])) {
                return $user;  // Retornar el usuario con el idRol incluido
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
