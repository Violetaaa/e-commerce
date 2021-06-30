<?php

class Product{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getProductsByCategory($category, $order){
        $query = 'SELECT * FROM product INNER JOIN image ON product.id=image.product_id WHERE category_id =:category_id';

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

        $this->db->bind('category_id', $category);

        $results = $this->db->resultSet();

        return $results;
    }

    public function getProduct($id){
        $this->db->query('SELECT * FROM product INNER JOIN image ON product.id=image.product_id where product.id = :id');
        $this->db->bind(':id', $id);

        $row = $this->db->single();
        return $row;
    }

    public function getSearchedProducts($search){ 
        $this->db->query('SELECT * FROM product INNER JOIN image ON product.id=image.product_id  WHERE name LIKE :search OR description LIKE :search');
        $search = "%".$search."%";
        $this->db->bind(':search', $search);

        $results = $this->db->resultSet();

        return $results;
    }
    
    public function getNewestProducts(){
        $this->db->query('SELECT * FROM product INNER JOIN image ON product.id=image.product_id  ORDER BY product.created_at LIMIT 9');

        $results = $this->db->resultSet();

        return $results;  
    }
}