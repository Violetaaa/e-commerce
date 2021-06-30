<?php
class Reviews extends Controller
{
    public function __construct()
    {
        
    //cargar el modelo 
    $this->reviewModel = $this->model('Review');
    $this->cartModel = $this->model('Cart');
    }
    //mostramos las valoraciones escritas por el usuario, si las hay
    public function index()
    {
        //si el usuario no está identificado, redirigimos
        if (!isLogged()) {
            header('location: ' . URLROOT . '/' . 'users/authenticationRequired');
            //en caso contrario, continuamos
        } else {
            //si el ususario no ha realizado compras, mostramos mensaje
            if (!$this->cartModel->getOrderedProducts($_SESSION['user_id'])) {
                $data['errorAdd'] = 'Aún no has realizado una compra para poder realizar un comentario sobre nuestros productos';
                $this->view('reviews/index', $data);
            } else {
                // en caso contrario, continuamos y mostramos sus comentarios
                if ($this->reviewModel->getReviewsByUser($_SESSION['user_id'])) {

                    //almacemos los comentarios y cargamos la vista
                    $reviews = $this->reviewModel->getReviewsByUser($_SESSION['user_id']);
                    $data = [
                        'reviews' => $reviews
                    ];
                    $this->view('reviews/index', $data);
                } else {
                    //si no ha realizado comentarios, mostramos un mensaje
                    $data['errorReviews'] = 'Aún no has valorado ninguno de nuestros productos';
                    $this->view('reviews/index', $data);
                }
            }
        }
    }

    //añadir valoración
    public function add()
    {
        //si el usuario no está identificado, mos
        if (!isLogged()) {
            header('location: ' . URLROOT . '/' . 'users/authenticationRequired');
            //en caso contrario, continuamos
        } else {
            //almacenamos los productos comprados por el usuario
            $products = $this->cartModel->getOrderedProducts($_SESSION['user_id']);
            //si la petición es de tipo POST, contianumos
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                //Sanitizamos los datos enviados
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                //creamos un array con los datos 
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

                //validaciones de los datos
                if (empty($data['title'])) {
                    $data['error_title'] = 'Este campo es obligatorio';
                }
                if (empty($data['text'])) {
                    $data['errorText'] = 'Este campo es obligatorio';
                }
                if (empty($data['product_id'])) {
                    $data['errorProduct'] = 'Selecciona un producto';
                }

                //comprobar que no hay errores
                if (empty($data['error_title']) && empty($data['errorText']) && empty($data['errorProduct'])) {
                    //añadir valoración a la base de datos
                    if ($this->reviewModel->addReview($data)) {
                        header('location: ' . URLROOT . '/' . 'reviews\index');
                    } else {
                        die('Error');
                    }
                } else {
                    //cargar la vista con  los errores
                    $this->view('reviews/add', $data);
                }
            } else { //cargamos la vista con el formulario en blanco
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
