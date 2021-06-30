<?php

class Cart{

    private $cart;
    private $totalPrice;

    public function __construct(){

        if(isset($_SESSION['cart'])){
            $this->cart = $_SESSION['cart'];
        }

        $this->db = new Database;
    }
 
    public function add($id){
         if (!$this->alreadyInCart($id)){
            $_SESSION['cart'][] = [
                'id' => $id,
                'name' => $_POST['name'],
                'price' => $_POST['price'],
                'filename' => $_POST['filename'],
                'quantity' =>  1
            ];     
        }    
    }

    public function alreadyInCart($id){
        for ($i=0; $i<count($_SESSION['cart']); $i++){
            if($_SESSION['cart'][$i]['id'] == $id){
                $_SESSION['cart'][$i]['quantity'] ++;
                return true;
            }  
        } return false;
    }

    public function delete($id){
        for ($i=0; $i<count($_SESSION['cart']); $i++){
            if($_SESSION['cart'][$i]['id'] == $id) {
                unset($_SESSION['cart'][$i]);
                $_SESSION['cart']= array_values($_SESSION['cart']);
            }   
        } 
    }

    public function increaseQuantity($id){ 
        for ($i=0; $i<count($_SESSION['cart']); $i++){
            if($_SESSION['cart'][$i]['id'] == $id){
                $_SESSION['cart'][$i]['quantity']++; 
            }   
        } 
    }

    public function decreaseQuantity($id){ 
        for ($i=0; $i<count($_SESSION['cart']); $i++){
            if($_SESSION['cart'][$i]['id'] == $id){
                $_SESSION['cart'][$i]['quantity']--;
                if ($_SESSION['cart'][$i]['quantity']<=0){
                    unset($_SESSION['cart'][$i]);
                    $_SESSION['cart']= array_values($_SESSION['cart']);    
                }
            }   
        } 
    }

    public function getTotalPrice(){
        $totalPrice = 0;
        foreach($this->cart as $product){
            $price = $product['price'] * $product['quantity'];
            $totalPrice += $price;
        } 
        return $totalPrice;
    }

    public function placeOrder($data){
        $this->db->query('INSERT INTO `order` (user_id, total_price) VALUES (:user_id, :total_price)');
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':total_price', $data['total_Price']);

        if($this->db->execute()){
            $orderId = $this->db->getId();

            foreach ($data['products'] as $product){
                $this->db->query('INSERT INTO orderDetail (order_id, product_id, quantity) VALUES (:order_id, :product_id, :quantity)');

                $this->db->bind(':order_id', $orderId);
                $this->db->bind(':product_id', $product['id']);
                $this->db->bind(':quantity', $product['quantity']);
                
                $this->db->execute();
            } return true;
        } else {
            return false;
        }
    }

    public function getOrderedProducts($user_id){
        $this->db->query('SELECT DISTINCT product.id, product.name
        FROM product
        INNER JOIN orderDetail
        ON orderDetail.product_id = product.id
        INNER JOIN `order`
        ON orderDetail.order_id = order.id
        WHERE user_id = :id
        ');

        $this->db->bind(':id', $user_id);
        $results = $this->db->resultSet();

        return $results;
    } 
}

