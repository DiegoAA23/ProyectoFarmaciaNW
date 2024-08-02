<?php

namespace Controllers\Sec;

use Controllers\PublicController;
use \Utilities\Validators;
use Dao\Security\Login as LoginDao;
use Exception;

class Login extends PublicController
{
    private $txtEmail = "";
    private $txtPswd = "";
    private $errorEmail = "";
    private $errorPswd = "";
    private $generalError = "";
    private $hasErrors = false;

    public function run(): void
    {
        if ($this->isPostBack()) {
            $this->txtEmail = $_POST["txtEmail"] ?? '';
            $this->txtPswd = $_POST["txtPswd"] ?? '';

            // Validaciones
            if (!Validators::IsValidEmail($this->txtEmail)) {
                $this->errorEmail = "El correo no tiene el formato adecuado";
                $this->hasErrors = true;
            }
            if (empty($this->txtPswd)) {
                $this->errorPswd = "La contraseña no puede estar vacía.";
                $this->hasErrors = true;
            }

            if (!$this->hasErrors) {
                try {
                    $db = new \PDO('mysql:host=127.0.0.1;dbname=farmacia;charset=utf8mb4', 'root', '', [
                        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    ]);

                    $loginDao = new LoginDao($db);
                    $user = $loginDao->verifyUser($this->txtEmail, $this->txtPswd);

                    if ($user) {
                        // Guarda el usuario en la sesión incluyendo el idRol
                        $_SESSION['user'] = [
                            'idUsuario' => $user['idUsuario'],
                            'nombreUsuario' => $user['nombreUsuario'],
                            'idRol' => $user['idRol']
                        ];

                        $idRol = $user['idRol'];

                        // Redirección basada en el rol
                        switch ($idRol) {
                            case 1:
                                \Utilities\Site::redirectTo("index.php?page=Products_Products");
                                break;
                            case 2:
                                \Utilities\Site::redirectTo("index.php?page=Productos_Productos");
                                break;
                            case 3:
                                \Utilities\Site::redirectTo("index.php?page=Productos_Productos");
                                break;
                            default:
                                \Utilities\Site::redirectToWithMsg("index.php?page=Productos_Productos", "¡Inicio de sesión exitoso!");
                                break;
                        }
                    } else {
                        $this->generalError = "Correo o contraseña incorrectos.";
                    }
                } catch (Exception $ex) {
                    $this->generalError = "Ocurrió un error, por favor intente nuevamente.";
                }
            }
        }

        $viewData = get_object_vars($this);
        \Views\Renderer::render("security/login", $viewData);
    }
}
