<?php

namespace Controllers\Usuarios;

use \Dao\Usuarios\Usuarios as DaoUsuarios;
use \Utilities\Validators as Validators;
use \Utilities\Site as Site;

class Usuario extends \Controllers\PublicController
{
    private $mode = "NAN";
    private $modeDscArr = [
        "UPD" => "Actualizando Usuario %s",
        "DSP" => "Detalle de %s",
    ];

    private $idUsuario;
    private $nombreUsuario;
    private $correo;
    private $idRol;
    private $estadoUsuario;

    private $errors = array();
    private $xsrftk = "";

    public function run(): void
    {
        $this->obtenerDatosDelGet();

        $this->getDatosFromDB();

        if ($this->isPostBack()) {

            $this->obtenerDatosDePost();
            if (count($this->errors) === 0) {

                $this->procesarAccion();
            }
        }

        $this->showView();
    }

    private function obtenerDatosDelGet()
    {
        if (isset($_GET["mode"])) {
            $this->mode = $_GET["mode"];
        }

        if (!isset($this->modeDscArr[$this->mode])) {
            throw new \Exception("Modo no valido");
        }
        if (isset($_GET["idUsuario"])) {
            $this->idUsuario = intval($_GET["idUsuario"]);
        }
    }

    private function getDatosFromDB()
    {
        if ($this->idUsuario > 0) {
            $usuario = DaoUsuarios::readUsuario($this->idUsuario);

            if (!$usuario) {
                throw new \Exception("Usuario no encontrado");
            }

            $this->nombreUsuario = $usuario["nombreUsuario"];
            $this->correo = $usuario["correo"];
            $this->idRol = $usuario["idRol"];
            $this->estadoUsuario = $usuario["estadoUsuario"];
        }
    }

    private function showView()
    {
        $this->generateXSRFToken();
        $viewData = array();
        $viewData["mode"] = $this->mode;
        $viewData["modeDsc"] = sprintf($this->modeDscArr[$this->mode], $this->nombreUsuario);
        $viewData["idUsuario"] = $this->idUsuario;
        $viewData["nombreUsuario"] = $this->nombreUsuario;
        $viewData["correo"] = $this->correo;
        $viewData["idRol"] = $this->idRol;
        $viewData["estadoUsuario"] = $this->estadoUsuario;

        $viewData["errors"] = $this->errors;

        // Dos combo boxes
        $viewData["prdest" . $this->estadoUsuario] = "selected";
        $viewData["prdcat" . $this->idRol] = "selected";

        $viewData["xsrftk"] = $this->xsrftk;
        $viewData["isReadOnly"] = in_array($this->mode, ["DSP"]) ? "readonly" : "";
        $viewData["isDisplay"] = $this->mode == "DSP";
        \Views\Renderer::render("usuarios/form", $viewData);
    }

    private function obtenerDatosDePost()
    {
        $tmpNombre = $_POST["nombreUsuario"] ?? "";
        $tmpCorreo = $_POST["correo"] ?? "";
        $tmpEstado = $_POST["estadoUsuario"] ?? "";
        $tmpRol = $_POST["idRol"] ?? "";
        $tmpMode = $_POST["mode"] ?? "";
        $tmpXsrfTk = $_POST["xsrftk"] ?? "";

        $this->getXSRFToken();
        if (!$this->compareXSRFToken($tmpXsrfTk)) {
            $this->throwError("Ocurrio un error al procesar la solicitud.");
        }

        if (Validators::IsEmpty($tmpNombre)) {
            $this->addError("nombreUsuario", "El nombre no puede estar vacio", "error");
        }
        $this->nombreUsuario = $tmpNombre;

        if (Validators::IsEmpty($tmpCorreo)) {
            $this->addError("correo", "El correo no puede estar vacio", "error");
        }
        $this->correo = $tmpCorreo;

        $this->estadoUsuario = $tmpEstado;
        $this->idRol = $tmpRol;

        if (Validators::IsEmpty($tmpMode) || !in_array($tmpMode, ["UPD", "DSP"])) {
            $this->throwError("Ocurrio un error al procesar la solicitud.");
        }
    }

    private function throwError($msg)
    {
        Site::redirectToWithMsg(
            "index.php?page=Usuarios-Usuarios",
            $msg
        );
    }

    private function addError($key, $msg, $context = "general")
    {
        if (!isset($this->errors[$context . "_" . $key])) {
            $this->errors[$context . "_" . $key] = [];
        }
        $this->errors[$context . "_" . $key][] = $msg;
    }

    private function generateXSRFToken()
    {
        $this->xsrftk = md5(uniqid(rand(), true));
        $_SESSION[$this->nombreUsuario . "_xsrftk"] = $this->xsrftk;
    }
    private function getXSRFToken()
    {
        if (isset($_SESSION[$this->nombreUsuario . "_xsrftk"])) {
            $this->xsrftk = $_SESSION[$this->nombreUsuario . "_xsrftk"];
        }
    }
    private function compareXSRFToken($postXSFR)
    {
        return $postXSFR === $this->xsrftk;
    }

    private function procesarAccion()
    {
        switch ($this->mode) {
            case "UPD":
                $updResult = DaoUsuarios::updateUsuarios(
                    $this->idUsuario,
                    $this->idRol,
                    $this->estadoUsuario
                );
                $this->validateDBOperation("Usuario actualizado correctamente", "Ocurrio un error al actualizar el usuario", $updResult);
                break;
        }
    }

    private function validateDBOperation($msg, $error, $result)
    {
        if (!$result) {
            $this->errors["error_general"] = $error;
        } else {
            Site::redirectToWithMsg(
                "index.php?page=Usuarios-Usuarios",
                $msg
            );
        }
    }
}
