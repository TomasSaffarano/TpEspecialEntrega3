<?php

class ProductModel {
    private $db;

    public function __construct(){
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=db_supermercado;charset=utf8', 'root', '');
    }

    public function getProducts() {
        $query =  $this->db->prepare('SELECT * FROM `productos`');
        $query->execute();
        $all_products = $query->fetchAll(PDO::FETCH_OBJ);
        return $all_products;
    }

    public function getProduct($id) {
        $query = $this->db->prepare('SELECT * FROM `productos` WHERE `id_producto` = ?');
        $query->execute([$id]);
        $product = $query->fetch(PDO::FETCH_OBJ);
        return $product;
    }

    public function getProductsCat($id_cat) {
        $query = $this->db->prepare('SELECT * FROM `productos` WHERE `id_categoria` = ?');
        $query->execute([$id_cat]);
        $products = $query->fetchAll(PDO::FETCH_OBJ);
        return $products;
    }

    public function getSelect(){
        $query = $this->db->prepare('SELECT * FROM `categorias`');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function insertProduct($product_name, $product_price, $id_category){
        $query = $this->db->prepare('INSERT INTO `productos` (`nombre_producto`, `precio_producto`, `id_categoria`) VALUES (?, ?, ?)');
        $query->execute([$product_name, $product_price, $id_category]);   
        return $this->db->lastInsertId();
    }
    
    public function changeProduct($product_name, $product_price, $id_category, $id_product){
        $query = $this->db->prepare('UPDATE `productos` SET `nombre_producto`=?, `precio_producto`=?, `id_categoria`=? WHERE `id_producto` = ?');
        $query->execute([$product_name, $product_price, $id_category, $id_product]);
  
    }

    public function deleteProductById($id){
        $query = $this->db->prepare('DELETE FROM `productos` WHERE `id_producto` = ?');
        $query->execute([$id]);
    }
}
?> 