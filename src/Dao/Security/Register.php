<?php
namespace Dao\Security;

use \PDO;
use \PDOException;

class Register {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registerUser($nombreUsuario, $correo, $telefono, $contra) {
        try {
            $this->conn->beginTransaction();

            $sqlUser = "INSERT INTO usuarios (nombreUsuario, correo, telefono, estadoUsuario, contra) 
                        VALUES (:nombreUsuario, :correo, :telefono, 'ACT', :contra)";
            $stmtUser = $this->conn->prepare($sqlUser);
            
            $stmtUser->bindParam(':nombreUsuario', $nombreUsuario);
            $stmtUser->bindParam(':correo', $correo);
            $stmtUser->bindParam(':telefono', $telefono);
            $stmtUser->bindParam(':contra', password_hash($contra, PASSWORD_BCRYPT));
            
            if (!$stmtUser->execute()) {
                $this->conn->rollBack();
                return false;
            }

            $idUsuario = $this->conn->lastInsertId();

            $sqlRole = "INSERT INTO usuariorol (idUsuario, idRol) VALUES (:idUsuario, 2)";
            $stmtRole = $this->conn->prepare($sqlRole);
            $stmtRole->bindParam(':idUsuario', $idUsuario);

            if (!$stmtRole->execute()) {
                $this->conn->rollBack();
                return false;
            }

            $this->conn->commit();
            return true;

        } catch (PDOException $e) {
            $this->conn->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function isEmailRegistered($correo) {
        try {
            $sql = "SELECT COUNT(*) FROM usuarios WHERE correo = :correo";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':correo', $correo);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            return $count > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>