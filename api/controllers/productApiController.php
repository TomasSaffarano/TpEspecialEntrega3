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

    // /api/productos
    // /api/productos?ofertas=false
    // /api/productos?ofertas=true
    public function getAll($req) {
        $filtrarOfertas = null;

        if(isset($req->query->ofertas)) {
            $filtrarOfertas = $req->query->ofertas;
        }
        
        $orderBy = false;
        if(isset($req->query->orderBy)){
            $orderBy = $req->query->orderBy;
        }

        $products = $this->model->getProducts($filtrarOfertas, $orderBy);
        return $this->view->response($products);
    }
    
    public function getAllCat($req) {
        $id_cat = $req->params->id_cat;
        $products = $this->model->getProductsCat($id_cat);

        if(!$products) {
            return $this->view->response("No existen productos en la categoria de id: $id_cat", 404);
        }
        return $this->view->response($products);
    }

    public function serveCategories($req) {
        $categories = $this->model->getCategories();

        if(!$categories) {
            return $this->view->response("No existen productos de categoria", 404);
        }
        return $this->view->response($categories);
    }

    public function getCat($req) {
        $id = $req->params->id;
        $category = $this->model->getCategory($id);

        if(!$category) {
            return $this->view->response("La categoria con el id $id, no existe", 404);
        }
        return $this->view->response($category);
    }

    // /api/productos/:id
    public function get($req) {
        $id = $req->params->id;
        $product = $this->model->getProduct($id);

        if(!$product) {
            return $this->view->response("El producto con el id $id, no existe", 404);
        }
        return $this->view->response($product);
    }

    public function delete($req) {
        $id = $req->params->id;

        $product = $this->model->getProduct($id);

        if (!$product) {
            return $this->view->response("El producto con el id: $id no existe", 404);
        }

        $this->model->deleteProductById($id);
        $this->view->response("El producto con el id: $id se elimino con exito");
    }

    public function create($req) {

        if (empty($req->body->nombre_producto) || empty($req->body->precio_producto) || empty($req->body->id_categoria) || empty($req->body->oferta)) {
            return $this->view->response('Falta completar datos', 400);
        }
        $nombre = $req->body->nombre_producto;       
        $precio = $req->body->precio_producto;
        $oferta = $req->body->oferta;
        $id_categoria = $req->body->id_categoria;       

        $id = $this->model->insertProduct($nombre, $precio, $oferta, $id_categoria);

        if (!$id) {
            return $this->view->response("Error al insertar tarea", 500);
        }
        // buena práctica es devolver el recurso insertado
        $producto = $this->model->getProduct($id);
        return $this->view->response($producto, 201);
    }

    public function update($req, $res) {
        $id = $req->params->id;
        $product = $this->model->getProduct($id);

        if (!$product) {
            return $this->view->response("El producto con el id: $id no existe", 404);
        }
         if (empty($req->body->nombre_producto) || empty($req->body->precio_producto)|| empty($req->body->oferta) || empty($req->body->id_categoria)) {
            return $this->view->response('Faltan completar datos', 400);
        }

        $nombre = $req->body->nombre_producto;       
        $precio = $req->body->precio_producto; 
        $oferta = $req->body->oferta;      
        $id_categoria = $req->body->id_categoria;       

        $this->model->changeProduct($id, $nombre, $precio, $oferta, $id_categoria);
        $producto = $this->model->getProduct($id);
        return $this->view->response($producto, 200);
    }
}
