<?php

namespace Controllers\Sec;

use Controllers\PublicController;
use \Utilities\Validators;
use Dao\Security\Register as RegisterDao;
use Exception;

class Register extends PublicController
{
    private $nombreUsuario = "";
    private $correo = "";
    private $telefono = "";
    private $contra = "";
    private $errorNombreUsuario = "";
    private $errorCorreo = "";
    private $errorTelefono = "";
    private $errorContra = "";
    private $generalError = "";
    private $hasErrors = false;

    public function run() :void
    {
        if ($this->isPostBack()) {
            $this->nombreUsuario = $_POST["nombreUsuario"];
            $this->correo = $_POST["correo"];
            $this->telefono = $_POST["telefono"];
            $this->contra = $_POST["contra"];
            
            // Validaciones
            if (empty($this->nombreUsuario)) {
                $this->errorNombreUsuario = "El nombre de usuario no puede estar vacío.";
                $this->hasErrors = true;
            }
            if (!(Validators::IsValidEmail($this->correo))) {
                $this->errorCorreo = "El correo no tiene el formato adecuado";
                $this->hasErrors = true;
            } else {
                $db = new \PDO('mysql:host=127.0.0.1;dbname=farmacia;charset=utf8mb4', 'root', '', [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                ]);

                $registerDao = new RegisterDao($db);

                if ($registerDao->isEmailRegistered($this->correo)) {
                    $this->errorCorreo = "El correo electrónico ya está registrado.";
                    $this->hasErrors = true;
                }
            }
            if (empty($this->telefono) || !preg_match("/^[0-9]{8}$/", $this->telefono)) {
                $this->errorTelefono = "El teléfono debe tener 8 dígitos.";
                $this->hasErrors = true;
            }
            if (!Validators::IsValidPassword($this->contra)) {
                $this->errorContra = "La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un caracter especial.";
                $this->hasErrors = true;
            }

            if (!$this->hasErrors) {
                try {
                    if ($registerDao->registerUser($this->nombreUsuario, $this->correo, $this->telefono, $this->contra)) {
                        \Utilities\Site::redirectToWithMsg("index.php?page=sec_login", "¡Usuario Registrado Satisfactoriamente!");
                    } else {
                        $this->generalError = "No se pudo registrar al usuario. Intente de nuevo más tarde.";
                    }
                } catch (Exception $ex) {
                    $this->generalError = "Ocurrió un error, por favor intente nuevamente.";
                }
            }
        }
        
        $viewData = get_object_vars($this);
        \Views\Renderer::render("security/sigin", $viewData);
    }
}
?>