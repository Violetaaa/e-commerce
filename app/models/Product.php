<?php

class Product{
    private $db;

    public function __construct(){
        //creamos instancia de la base de datos
        $this->db = new Database;
    }

    //devolver productos de la categoría solicitada
    public function getProductsByCategory($category, $order){
        //consulta
        $query = 'SELECT * FROM product INNER JOIN image ON product.id=image.product_id WHERE category_id =:category_id';

        //añadimos a la consulta la claúsula ORDER si el usuario lo solicita
        switch($order){
            case 'default':
                break;
            case 'precioAsc':
                $query .= ' ORDER BY price ASC';
                break;
            case 'precioDesc':
                $query .= ' ORDER BY price DESC';
                break;
            case 'novedades':
                $query .= ' ORDER BY created_at ASC';
                break;
        }

        $this->db->query($query);

        //enlazar valores
        $this->db->bind('category_id', $category);

        $results = $this->db->resultSet();

        return $results;
    }

    //devolver un producto identificado por su id
    public function getProduct($id){
        //consulta
        $this->db->query('SELECT * FROM product INNER JOIN image ON product.id=image.product_id where product.id = :id');
        //enlazar valores
        $this->db->bind(':id', $id);

        $row = $this->db->single();
        return $row;
    }

    //devolver productos que coinciden con el término de búsqueda
    public function getSearchedProducts($search){ 
        //consulta
        $this->db->query('SELECT * FROM product INNER JOIN image ON product.id=image.product_id  WHERE name LIKE :search OR description LIKE :search');
        //añadir % al término de búsqueda
        $search = "%".$search."%";
        //enlazar valores
        $this->db->bind(':search', $search);

        $results = $this->db->resultSet();

        return $results;
    }
    //recupera los últimos 9 productos añadidos
    public function getNewestProducts(){
        $this->db->query('SELECT * FROM product INNER JOIN image ON product.id=image.product_id  ORDER BY product.created_at LIMIT 9');

        $results = $this->db->resultSet();

        return $results;  
    }
}