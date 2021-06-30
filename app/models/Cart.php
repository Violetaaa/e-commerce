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
 
    //Si el producto identificado por su id no está ya en el carrito, se añade.
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

    //comprobar si un producto identificado por su id ya está en el carrito
    public function alreadyInCart($id){
        //Si el producto está en el carrito, se aumenta su cantidad en 1 unidad y se devuelve true
        for ($i=0; $i<count($_SESSION['cart']); $i++){
            if($_SESSION['cart'][$i]['id'] == $id){
                $_SESSION['cart'][$i]['quantity'] ++;
                return true;
            }  
        //si no está en el carrito, devolvemos false 
        } return false;
    }

    //eliminar producto del carrito
    public function delete($id){
        //recorremos el array
        for ($i=0; $i<count($_SESSION['cart']); $i++){
            //si el id coincide, eliminamos el producto
            if($_SESSION['cart'][$i]['id'] == $id) {
                unset($_SESSION['cart'][$i]);
                //reindexamos el array
                $_SESSION['cart']= array_values($_SESSION['cart']);
            }   
        } 
    }

    //aumentar cantidad del producto en 1 unidad
    public function increaseQuantity($id){ 
        //recorremos el array. Si coincide el id del producto, aumentamos cantidad
        for ($i=0; $i<count($_SESSION['cart']); $i++){
            if($_SESSION['cart'][$i]['id'] == $id){
                $_SESSION['cart'][$i]['quantity']++; 
            }   
        } 
    }
    //reducir cantidad del producto en 1 unidad
    public function decreaseQuantity($id){ 
        //recorremos el array
        for ($i=0; $i<count($_SESSION['cart']); $i++){
            //reducimos la cantidad del producto 
            if($_SESSION['cart'][$i]['id'] == $id){
                $_SESSION['cart'][$i]['quantity']--;
                //si la cantidad es <= 0, eliminamos el producto
                if ($_SESSION['cart'][$i]['quantity']<=0){
                    unset($_SESSION['cart'][$i]);
                    //reindexamos el array
                    $_SESSION['cart']= array_values($_SESSION['cart']);    
                }
            }   
        } 
    }

    //devuelve el precio total de los artículos del carrito
    public function getTotalPrice(){
        //inicializamos la variable a 0
        $totalPrice = 0;
        //recorremos los productos del carrito
        foreach($this->cart as $product){
            //para cada producto, multiplicamos el precio por la cantidad y sumamos al total
            $price = $product['price'] * $product['quantity'];
            $totalPrice += $price;
        } 
        return $totalPrice;
    }

    //crear un nuevo pedido en la base de datos
    public function placeOrder($data){
        //1º insertar registro del pedido en tabla order
        //consulta
        $this->db->query('INSERT INTO `order` (user_id, total_price) VALUES (:user_id, :total_price)');
        //enlazar valores
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':total_price', $data['total_Price']);
        //ejecutar
        if($this->db->execute()){
            //almacenamos el id del pedido que acabamos de crear
            $orderId = $this->db->getId();
            //2º insertar registros de cada producto en tablas orderDetail
            foreach ($data['products'] as $product){
                //consulta
                $this->db->query('INSERT INTO orderDetail (order_id, product_id, quantity) VALUES (:order_id, :product_id, :quantity)');
                //enlazar valores
                $this->db->bind(':order_id', $orderId);
                $this->db->bind(':product_id', $product['id']);
                $this->db->bind(':quantity', $product['quantity']);
                //ejecutar
                $this->db->execute();
            } return true;
        } else {
            return false;
        }
    }

    //recuperar los productos únicos comprados por el usuario
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

