<?php
require_once './api/models/product_model.php';
require_once './api/views/json.view.php';

class productApiController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new ProductModel();
        $this->view = new JSONView();
    }

    // /api/tareas
    public function getAll($req, $res) {
       
        $products = $this->model->getProducts();
        // mando las tareas a la vista
        return $this->view->response($products);
    }
    
    public function getAllCat($req, $res) {
        // obtengo el id de la tarea desde la ruta
        $id_cat = $req->params->id_cat;

        // obtengo la tarea de la DB
        $products = $this->model->getProductsCat($id_cat);

        if(!$products) {
            return $this->view->response("No existen productos de categoria", 404);
        }

        // mando la tarea a la vista
        return $this->view->response($products);
    }

    public function get($req, $res) {
        // obtengo el id de la tarea desde la ruta
        $id = $req->params->id;

        // obtengo la tarea de la DB
        $product = $this->model->getProduct($id);

        if(!$product) {
            return $this->view->response("El producto con el id=$id no existe", 404);
        }

        // mando la tarea a la vista
        return $this->view->response($product);
    }

    public function delete($req, $res) {
        $id = $req->params->id;

        $product = $this->model->getProduct($id);

        if (!$product) {
            return $this->view->response("El producto con el id=$id no existe", 404);
        }

        $this->model->deleteProductById($id);
        $this->view->response("El producto con el id=$id se eliminó con éxito");
    }


    public function create($req, $res) {

        // valido los datos
        if (empty($req->body->nombre_producto) || empty($req->body->precio_producto)|| empty($req->body->id_categoria)) {
            return $this->view->response('Faltan completar datos', 400);
        }

        // obtengo los datos
        $nombre = $req->body->nombre_producto;       
        $precio = $req->body->precio_producto;       
        $id_categoria = $req->body->id_categoria;       

        // inserto los datos
        $id = $this->model->insertProduct($nombre, $precio, $id_categoria);

        if (!$id) {
            return $this->view->response("Error al insertar tarea", 500);
        }
        // buena práctica es devolver el recurso insertado
        $producto = $this->model->getProduct($id);
        return $this->view->response($producto, 201);
    }

    public function update($req, $res) {
        $id = $req->params->id;

        // verifico que exista
        $product = $this->model->getProduct($id);

        if (!$product) {
            return $this->view->response("El producto con el id=$id no existe", 404);
        }

         // valido los datos
         if (empty($req->body->nombre_producto) || empty($req->body->precio_producto) || empty($req->body->id_categoria)) {
            return $this->view->response('Faltan completar datos', 400);
        }

        // obtengo los datos
        $nombre = $req->body->nombre_producto;       
        $precio = $req->body->precio_producto;       
        $id_categoria = $req->body->id_categoria;       


        // actualiza la tarea
        $this->model->changeProduct($nombre, $precio, $id_categoria, $id);

        // obtengo la tarea modificada y la devuelvo en la respuesta
        $producto = $this->model->getProduct($id);
        return $this->view->response($producto, 200);
    }


}
