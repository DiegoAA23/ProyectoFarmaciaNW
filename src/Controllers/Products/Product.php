<?php

namespace Controllers\Products;

use \Dao\Products\Products as DaoProducts;
use \Utilities\Validators as Validators;
use \Utilities\Site as Site;

class Product extends \Controllers\PublicController
{
    private $mode = "NAN";
    private $modeDscArr = [
        "INS" => "Nuevo Producto",
        "UPD" => "Actualizando Producto %s",
        "DSP" => "Detalle de %s",
        "DEL" => "Eliminando %s"
    ];

    private $idProducto;
    private $nombreProducto = "";
    private $precioProducto;
    private $cantidadProducto;
    private $imagenProducto;
    private $estadoProducto = "ACT";

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

    private function obtenerDatosdelGet()
    {
        if (isset($_GET["mode"])) {
            $this->mode = $_GET["mode"];
        }

        if (!isset($this->modeDscArr[$this->mode])) {
            throw new \Exception("Modo no valido");
        }
        if (isset($_GET["idProducto"])) {
            $this->idProducto = intval($_GET["idProducto"]);
        }

        if ($this->mode != "INS" && $this->idProducto <= 0) {
            throw new \Exception("ID no valido");
        }
    }

    private function getDatosFromDB()
    {
        if ($this->idProducto > 0) {
            $product = DaoProducts::readProductosFarmacia($this->idProducto);

            if (!$product) {
                throw new \Exception("Producto no encontrado");
            }

            $this->nombreProducto = $product["nombreProducto"];
            $this->precioProducto = $product["precioProducto"];
            $this->cantidadProducto = $product["cantidadProducto"];
            $this->imagenProducto = $product["imagenProducto"];
            $this->estadoProducto = $product["estadoProducto"];
        }
    }

    private function showView()
    {
        $this->generateXSRFToken();
        $viewData = array();
        $viewData["mode"] = $this->mode;
        $viewData["modeDsc"] = sprintf($this->modeDscArr[$this->mode], $this->nombreProducto);
        $viewData["idProducto"] = $this->idProducto;
        $viewData["nombreProducto"] = $this->nombreProducto;
        $viewData["precioProducto"] = $this->precioProducto;
        $viewData["cantidadProducto"] = $this->cantidadProducto;
        $viewData["imagenProducto"] = $this->imagenProducto;
        $viewData["estadoProducto"] = $this->estadoProducto;

        $viewData["errors"] = $this->errors;

        $viewData["prdest" . $this->estadoProducto] = "selected";

        $viewData["xsrftk"] = $this->xsrftk;
        $viewData["isReadOnly"] = in_array($this->mode, ["DEL", "DSP"]) ? "readonly" : "";
        $viewData["isDisplay"] = $this->mode == "DSP";
        \Views\Renderer::render("products/form", $viewData);
    }

    private function obtenerDatosDePost()
    {
        $tmpNombreProducto = $_POST["nombreProducto"] ?? "";
        $tmpPrecioProducto = $_POST["precioProducto"] ?? "";
        $tmpCantidadProducto = $_POST["cantidadProducto"] ?? "";
        $tmpImagenProducto = $_POST["imagenProducto"] ?? "";
        $tmpEstadoProducto = $_POST["estadoProducto"] ?? "ACT";
        $tmpMode = $_POST["mode"] ?? "";
        $tmpXsrfTk = $_POST["xsrftk"] ?? "";

        $this->getXSRFToken();
        if (!$this->compareXSRFToken($tmpXsrfTk)) {
            $this->throwError("Ocurrio un error al procesar la solicitud.");
        }


        if (Validators::IsEmpty($tmpNombreProducto)) {
            $this->addError("nombreProducto", "El nombre no puede estar vacio", "error");
        }
        $this->nombreProducto = $tmpNombreProducto;


        if (Validators::IsEmpty($tmpPrecioProducto)) {
            $this->addError("precioProducto", "El precio no puede estar vacio", "error");
        }
        $this->precioProducto = $tmpPrecioProducto;


        if (Validators::IsEmpty($tmpCantidadProducto)) {
            $this->addError("cantidadProducto", "La cantidad no puede estar vacia", "error");
        }
        $this->cantidadProducto = $tmpCantidadProducto;


        if (Validators::IsEmpty($tmpImagenProducto)) {
            $this->addError("imagenProducto", "La imagen no puede estar vacia", "error");
        }
        $this->imagenProducto = $tmpImagenProducto;


        if (Validators::IsEmpty($tmpMode) || !in_array($tmpMode, ["INS", "UPD", "DEL"])) {
            $this->throwError("Ocurrio un error al procesar la solicitud.");
        }

        $this->estadoProducto = $tmpEstadoProducto;

        if (Validators::IsEmpty($tmpMode) || !in_array($tmpMode, ["INS", "UPD", "DEL"])) {
            $this->throwError("Ocurrio un error al procesar la solicitud.");
        }
    }

    private function throwError($msg)
    {
        Site::redirectToWithMsg(
            "index.php?page=Products-Products",
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
        $_SESSION[$this->nombreProducto . "_xsrftk"] = $this->xsrftk;
    }
    private function getXSRFToken()
    {
        if (isset($_SESSION[$this->nombreProducto . "_xsrftk"])) {
            $this->xsrftk = $_SESSION[$this->nombreProducto . "_xsrftk"];
        }
    }
    private function compareXSRFToken($postXSFR)
    {
        return $postXSFR === $this->xsrftk;
    }

    private function procesarAccion()
    {
        switch ($this->mode) {
            case "INS":
                $insResult = DaoProducts::createProductosFarmacia(
                    $this->nombreProducto,
                    $this->precioProducto,
                    $this->cantidadProducto,
                    $this->imagenProducto,
                    $this->estadoProducto
                );
                $this->validateDBOperation(
                    "Producto insertado correctamente",
                    "Ocurrio un error al insertar el producto",
                    $insResult
                );
                break;
            case "UPD":
                $updResult = DaoProducts::updateProductosFarmacia(
                    $this->idProducto,
                    $this->nombreProducto,
                    $this->precioProducto,
                    $this->cantidadProducto,
                    $this->imagenProducto,
                    $this->estadoProducto
                );
                $this->validateDBOperation(
                    "Producto actualizado correctamente",
                    "Ocurrio un error al actualizar el producto",
                    $updResult
                );
                break;
            case "DEL":
                $delResult = DaoProducts::deleteProductosFarmacia($this->idProducto);
                $this->validateDBOperation(
                    "Producto eliminado correctamente",
                    "Ocurrio un error al eliminar el producto",
                    $delResult
                );
                break;
        }
    }

    private function validateDBOperation($msg, $error, $result)
    {
        if (!$result) {
            $this->errors["error_general"] = $error;
        } else {
            Site::redirectToWithMsg(
                "index.php?page=Products-Products",
                $msg
            );
        }
    }
}
