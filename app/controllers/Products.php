<?php
//Controlador por defecto
class Products extends Controller{

    public function __construct(){
        //cargamos los modelos
        $this->productModel = $this->model('Product');
        $this->reviewModel = $this->model('Review');
    }

    public function index(){ 
        //almacenamos los datos de la portada y cargamos la vista
        $data = [    
            'title' => 'NOVEDADES',
            'description' => 'S/S 20'
        ];

        $this->view('products/index', $data);
    }

    //mostrar los detalles de un producto
    public function detail($id){
        //recuperamos los datos del producto
        $product = $this->productModel->getProduct($id);
        //recuperamos los datos de las valoraciones del producto
        $reviews = $this->reviewModel->getReviewsByProduct($id);

        //almacenamos los datos en un array y cargamos la vista
        $data = [
            'product' => $product,
            'reviews' => $reviews
        ];
        $this->view('products/detail', $data);
    }

    //hacer una búsqueda en el catálogo
    public function search(){
        //comprobar si la petición el de tipo POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Sanitizamos los datos enviados
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            //si no se ha introducido un término de búsqueda, mostramos un mensaje de error
            if (empty($_POST['search'])) {
                $data['error'] = 'No has introducido un término de búsqueda';
                //en caso contrario guardamos la búsqueda en la variable eliminando los espacios
            } else {
                $userInput = trim($_POST['search']);
            }

            //si no hay errores, continuamos
            if (empty($data['error'])) {
                //almacenamos los productos que coinciden con la búsqueda
                $productsInCatalog = $this->productModel->getSearchedProducts($userInput);

                //si la busqueda devuelve resultados, mostramos la vista con los datos
                if($productsInCatalog){
                    $data = [
                        'products' => $productsInCatalog,
                    ];
                    $this->view('products/search', $data);
                    //en caso contrario, cargamos la vista con el  error
                } else {
                    //Si la búsqueda no devuelve resultados, mostramos un mensaje al usuario
                    $data['error'] = 'La búsqueda no ha devuelto ningún resultado';
                    $this->view('products/error', $data);
                }
            //mostramos los errores   
            } else {
                $this->view('products/error', $data);
            }
        }
    }

    public function show($category){
        //si el usuario indica un orden, se aplica. 
        if (isset($_POST['ordenar'])) {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $order = $_POST['ordenar'];
        } else {
            $order = 'default';
        }

        //se recuperan los productos de la categoría solicitada y en el orden indicado.
        $products = $this->productModel->getProductsByCategory($category, $order);

        //los datos recuperados se cargan en la vista
        $data = [
            'products' => $products,
        ];
        $this->view('products/show', $data);
    }

   public function newIn(){
       //obtener últimos productos añadidos al catálodo
        $products = $this->productModel->getNewestProducts();

        //los datos recuperados se cargan en la vista
        $data = [
            'products' => $products,
        ];
        $this->view('products/show', $data);
   }

}
