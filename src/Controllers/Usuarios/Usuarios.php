<?php

namespace Controllers\Usuarios;

use \Dao\Usuarios\Usuarios as DaoUsuarios;

const SESSION_USUARIOS_SEARCH = "usuarios_search_data";

//PublicController: para tener un public function run
class Usuarios extends \Controllers\PublicController
{
    public function run(): void
    {
        $viewData = array();

        $viewData["search"] = $this->getSessionSearchData();

        if ($this->isPostBack()) {
            $viewData["search"] = $this->getSearchData();
            $this->setSessionSearchData($viewData["search"]);
        }

        $viewData["usuarios"] = DaoUsuarios::readAllUsuarios($viewData["search"]);
        $viewData["total"] = count($viewData["usuarios"]);

        \Views\Renderer::render("usuarios/lista", $viewData);
    }

    private function getSearchData()
    {
        if (isset($_POST["search"])) {
            return $_POST["search"];
        }
        return "";
    }

    private function getSessionSearchData()
    {
        if (isset($_SESSION[SESSION_USUARIOS_SEARCH])) {
            return $_SESSION[SESSION_USUARIOS_SEARCH];
        }
        return "";
    }

    private function setSessionSearchData($search)
    {
        $_SESSION[SESSION_USUARIOS_SEARCH] = $search;
    }
}
