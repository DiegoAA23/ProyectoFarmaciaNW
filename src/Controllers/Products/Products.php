<?php

namespace Controllers\Products;

use \Dao\Products\Products as DaoProducts;

const SESSION_PRODUCTS_SEARCH = "products_search_data";

//PublicController: para tener un public function run
class Products extends \Controllers\PublicController
{
    public function run(): void
    {
        $viewData = array();

        $viewData["search"] = $this->getSessionSearchData();

        if ($this->isPostBack()) {
            $viewData["search"] = $this->getSearchData();
            $this->setSessionSearchData($viewData["search"]);
        }

        $viewData["products"] = DaoProducts::readAllProductosFarmacia($viewData["search"]);
        $viewData["total"] = count($viewData["products"]);

        \Views\Renderer::render("products/lista", $viewData);
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
        if (isset($_SESSION[SESSION_PRODUCTS_SEARCH])) {
            return $_SESSION[SESSION_PRODUCTS_SEARCH];
        }
        return "";
    }

    private function setSessionSearchData($search)
    {
        $_SESSION[SESSION_PRODUCTS_SEARCH] = $search;
    }
}
