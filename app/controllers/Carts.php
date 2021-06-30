<?php
class Carts extends Controller{

    public function __construct(){
        $this->cartModel = $this->model('Cart');
        $this->userModel = $this->model('User');
    }

    //mostrar carrito
    public function index(){
        $totalPrice = $this->cartModel->getTotalPrice();
        
        $data=[
            'products' => $_SESSION['cart'],
            'totalPrice' => $totalPrice
        ];
        
        $this->view('carts/index', $data);
    } 
    
    //confirmar compra
    public function placeOrder(){
        //Si el usuario no está logueado, redirigimos y mostramos mensaje de error
        if(!isLogged()){
            header('location: ' . URLROOT . '/' . 'users/authenticationRequired');

        // si está logueado, continuamos
        } else {
            $totalPrice = $this->cartModel->getTotalPrice();

            $data=[
                'products' => $_SESSION['cart'],
                'total_Price' => $totalPrice,
                'user_id' => $_SESSION['user_id'],
            ];

            //insertar pedido
            if($this->cartModel->placeOrder($data)){
                //eliminar el carrito y redirigir al usuario 
                unset($_SESSION['cart']);
                $this->view('carts/placeOrder');
            } 
        }
    }

    //añadir producto al carrito
    public function add($id){
        $this->cartModel->add($id);
        header('location: ' . URLROOT . '/' . 'carts');

    }
    //eliminar producto del carrito
    public function delete($id){
        $this->cartModel->delete($id);
        header('location: ' . URLROOT . '/' . 'carts');
    }

    //aumentar cantidad del producto en 1 unidad
    public function increaseQuantity($id){
        $this->cartModel->increaseQuantity($id);
        header('location: ' . URLROOT . '/' . 'carts');
    }

    //disminuir cantidad del producto en 1 unidad
    public function decreaseQuantity($id){
        $this->cartModel->decreaseQuantity($id);
        header('location: ' . URLROOT . '/' . 'carts');
    }

    //precio total de los productos del carrito
    public function getTotalPrice(){
        $totalPrice = $this->cartModel->getTotalPrice();
        $data = [
            'totalPrice' => $totalPrice
        ];
        $this->view('carts/index', $data);
    }

    //número de productos dentro del carrito
    public function getTotalItems(){
        $total = 0;
        if(isset($_SESSION['quantity'])){
            foreach($_SESSION['quantity'] as $quantity){
                $total = $total + $quantity;
            }
        }
        return $total;
    }
    
    //vaciar carrito
    public function empty(){
        session_destroy();
        unset($_SESSION['cart']);
        header('location: ' . URLROOT . '/' . 'carts');
    }

}