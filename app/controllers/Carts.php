<?php
class Carts extends Controller{

    public function __construct(){
        $this->cartModel = $this->model('Cart');
        $this->userModel = $this->model('User');
    }

    public function index(){
        $totalPrice = $this->cartModel->getTotalPrice();
        
        $data=[
            'products' => $_SESSION['cart'],
            'totalPrice' => $totalPrice
        ];
        
        $this->view('carts/index', $data);
    } 
    
    public function placeOrder(){
        if(!isLogged()){
            header('location: ' . URLROOT . '/' . 'users/authenticationRequired');

        } else {
            $totalPrice = $this->cartModel->getTotalPrice();

            $data=[
                'products' => $_SESSION['cart'],
                'total_Price' => $totalPrice,
                'user_id' => $_SESSION['user_id'],
            ];
      
            if($this->cartModel->placeOrder($data)){
               
                unset($_SESSION['cart']);
                $this->view('carts/placeOrder');
            } 
        }
    }

    public function add($id){
        $this->cartModel->add($id);
        header('location: ' . URLROOT . '/' . 'carts');

    }
 
    public function delete($id){
        $this->cartModel->delete($id);
        header('location: ' . URLROOT . '/' . 'carts');
    }
  
    public function increaseQuantity($id){
        $this->cartModel->increaseQuantity($id);
        header('location: ' . URLROOT . '/' . 'carts');
    }
  
    public function decreaseQuantity($id){
        $this->cartModel->decreaseQuantity($id);
        header('location: ' . URLROOT . '/' . 'carts');
    }
   
    public function getTotalPrice(){
        $totalPrice = $this->cartModel->getTotalPrice();
        $data = [
            'totalPrice' => $totalPrice
        ];
        $this->view('carts/index', $data);
    }
 
    public function getTotalItems(){
        $total = 0;
        if(isset($_SESSION['quantity'])){
            foreach($_SESSION['quantity'] as $quantity){
                $total = $total + $quantity;
            }
        }
        return $total;
    }
    
    public function empty(){
        session_destroy();
        unset($_SESSION['cart']);
        header('location: ' . URLROOT . '/' . 'carts');
    }

}