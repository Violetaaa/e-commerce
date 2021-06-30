<?php

class Review{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getReviewsByUser($id){
        $this->db->query('SELECT *
        FROM review
        INNER JOIN user
        ON review.user_id = user.id
        INNER JOIN product
        ON review.product_id = product.id
        WHERE user_id = :id
        ORDER BY review.date DESC
        ');

    $this->db->bind(':id', $id);
        $results = $this->db->resultSet();

        return $results;
    }

    public function getReviewsByProduct($id){
        $this->db->query('SELECT *
                            FROM review
                            INNER JOIN product
                            ON product.id = review.product_id 
                            INNER JOIN user ON user.id = review.user_id
                            WHERE product_id = :product_id
                            ORDER BY review.date DESC
                            ');
         $this->db->bind('product_id', $id);
        $results = $this->db->resultSet();

        return $results;
    }

    public function addReview($data){
        $this->db->query('INSERT INTO review (title, text, product_id, user_id) VALUES (:title, :text, :product_id, :user_id)');
        
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':text', $data['text']);
        $this->db->bind(':product_id', $data['product_id']);
        $this->db->bind(':user_id', $data['user_id']);
     
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }
}
