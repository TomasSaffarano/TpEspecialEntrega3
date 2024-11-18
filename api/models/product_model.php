<?php

class ProductModel {
    private $db;

    public function __construct(){
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=db_supermercado;charset=utf8', 'root', '');
    }

    public function getProducts($ofertas = null, $orderBy = false) { //Trabajado en clase
        $sql = 'SELECT * FROM `productos`';

        if($ofertas != null) {
            if($ofertas == 'true')
                $sql .= ' WHERE `oferta` = 1';
            else
                $sql .= ' WHERE `oferta` = 0';
        }

        if($orderBy) {
            switch($orderBy) {
                case 'precio':
                    $sql .= ' ORDER BY `precio_producto`';
                    break;
                case 'precio_desc':
                    $sql .= ' ORDER BY `precio_producto` DESC';
                    break;
                case 'categoria':
                    $sql .= ' ORDER BY `id_categoria`';
                    break;
                case 'categoria_desc':
                    $sql .= ' ORDER BY `id_categoria` DESC';
                    break;
            }
        }

        $query =  $this->db->prepare($sql);
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

    public function getCategories(){
        $query = $this->db->prepare('SELECT * FROM categorias');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getCategory($id){
        $query = $this->db->prepare('SELECT * FROM `categorias` WHERE `id_categoria` = ?');
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function insertProduct($product_name, $product_price, $oferta, $id_category){
        $query = $this->db->prepare('INSERT INTO `productos` (`nombre_producto`, `precio_producto`, `oferta`, `id_categoria`) VALUES (?, ?, ?, ?)');
        $query->execute([$product_name, $product_price, $oferta, $id_category]);   
        return $this->db->lastInsertId();
    }
    
    public function changeProduct($id_product, $product_name, $product_price, $oferta, $id_category){
        $query = $this->db->prepare('UPDATE `productos` SET `nombre_producto`=?, `precio_producto`=?, `oferta`=?, `id_categoria`=? WHERE `id_producto` = ?');
        $query->execute([$product_name, $product_price, $oferta, $id_category, $id_product]);
  
    }

    public function deleteProductById($id){
        $query = $this->db->prepare('DELETE FROM `productos` WHERE `id_producto` = ?');
        $query->execute([$id]);
    }
}
?> 