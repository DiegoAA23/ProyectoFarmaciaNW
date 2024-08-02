<?php

namespace Controllers\Productos;

use Controllers\PublicController;
use \Dao\Productos\Productos as ProductosDao;
use \Views\Renderer as Renderer;
use \Utilities\Site as Site;
//unset($_SESSION['carrito']);
class Productos extends PublicController
{
  
  public function run(): void
  {
    Site::addLink("public/css/catalogo.css");
    $viewData = [];
    $viewData["productos"] = ProductosDao::obtenerProductos();

    /*echo '<pre>';
        print_r($viewData);
        echo '</pre>';*/
    Renderer::render("catalogo", $viewData);
  }
}