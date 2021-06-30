<?php
class Reviews extends Controller
{
    public function __construct()
    {
        
    $this->reviewModel = $this->model('Review');
    $this->cartModel = $this->model('Cart');
    }
    public function index()
    {
        if (!isLogged()) {
            header('location: ' . URLROOT . '/' . 'users/authenticationRequired');
        } else {
            if (!$this->cartModel->getOrderedProducts($_SESSION['user_id'])) {
                $data['errorAdd'] = 'Aún no has realizado una compra para poder realizar un comentario sobre nuestros productos';
                $this->view('reviews/index', $data);
            } else {
                if ($this->reviewModel->getReviewsByUser($_SESSION['user_id'])) {

                    $reviews = $this->reviewModel->getReviewsByUser($_SESSION['user_id']);
                    $data = [
                        'reviews' => $reviews
                    ];
                    $this->view('reviews/index', $data);
                } else {
                    $data['errorReviews'] = 'Aún no has valorado ninguno de nuestros productos';
                    $this->view('reviews/index', $data);
                }
            }
        }
    }

    public function add()
    {
        if (!isLogged()) {
            header('location: ' . URLROOT . '/' . 'users/authenticationRequired');
        } else {
            $products = $this->cartModel->getOrderedProducts($_SESSION['user_id']);
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = [
                    'title' => trim($_POST['title']),
                    'text' => trim($_POST['text']),
                    'product_id' => trim($_POST['product_id']),
                    'user_id' => $_SESSION['user_id'],
                    'error_title' => '',
                    'errorText' => '',
                    'errorProduct' => '',
                    'products' => $products
                ];

                if (empty($data['title'])) {
                    $data['error_title'] = 'Este campo es obligatorio';
                }
                if (empty($data['text'])) {
                    $data['errorText'] = 'Este campo es obligatorio';
                }
                if (empty($data['product_id'])) {
                    $data['errorProduct'] = 'Selecciona un producto';
                }

                if (empty($data['error_title']) && empty($data['errorText']) && empty($data['errorProduct'])) {
                    if ($this->reviewModel->addReview($data)) {
                        header('location: ' . URLROOT . '/' . 'reviews\index');
                    } else {
                        die('Error');
                    }
                } else {
                    $this->view('reviews/add', $data);
                }
            } else { 
                $data = [
                    'title' => '',
                    'text' => '',
                    'product_id' => '',
                    'user_id' => '',
                    'error_title' => '',
                    'errorText' => '',
                    'errorProduct' => '',
                    'products' => $products
                ];
                $this->view('reviews/add', $data);
            }
        }
    }
}
