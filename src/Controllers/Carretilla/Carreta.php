<?php

namespace Controllers\Carretilla;

use Controllers\PublicController;
use \Views\Renderer as Renderer;
use \Utilities\Site as Site;
use Dao\Carrito\Carrito;

class Carreta extends PublicController
{
    public function run(): void
    {
        Site::addLink("public/css/carretilla.css");
        $viewData = [];

        if (isset($_SESSION['carrito'])) {
            $carrito = [];
            $total = 0;

            foreach ($_SESSION['carrito'] as $id => $producto) {
                $carrito[] = [
                    'id' => ($id),
                    'nombre' => ($producto['nombre']),
                    'precio' => ($producto['precio']),
                    'cantidad' => ($producto['cantidad']),
                    'subtotal' => ($producto['precio']) * ($producto['cantidad']),
                ];
            }

            foreach ($carrito as $item) {
                $total += $item['subtotal'];
            }

            $viewData['carrito'] = $carrito;
            $viewData['total'][0]['tot'] = $total;
        } else {
            $viewData['carrito'] = ['mensaje' => 'El carrito está vacío.'];
        }
/*
        echo '<pre>';
        print_r($viewData);
        echo '</pre>';
        */
        Renderer::render("carretilla", $viewData);
    }

    public function guardarFactura()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['transactionId']) && isset($data['carrito']) && isset($data['total'])) {
            $carritoDAO = new Carrito();

            $transactionId = $data['transactionId'];
            $carrito = $data['carrito'];
            $total = $data['total'];

            $carritoDAO->guardarFactura($carrito, $total);
        }

        echo json_encode(['status' => 'success']);
    }
}
