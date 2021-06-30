<?php
// Default controller
class Products extends Controller{

    public function __construct(){
        $this->productModel = $this->model('Product');
        $this->reviewModel = $this->model('Review');
    }

    public function index(){ 
    
        $data = [    
            'title' => 'NOVEDADES',
            'description' => 'S/S 20'
        ];

        $this->view('products/index', $data);
    }

  
    public function detail($id){
        $product = $this->productModel->getProduct($id);
       
        $reviews = $this->reviewModel->getReviewsByProduct($id);
        
        $data = [
            'product' => $product,
            'reviews' => $reviews
        ];
        $this->view('products/detail', $data);
    }

  
    public function search(){
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            if (empty($_POST['search'])) {
                $data['error'] = 'No has introducido un término de búsqueda';
            } else {
                $userInput = trim($_POST['search']);
            }

            if (empty($data['error'])) {
                $productsInCatalog = $this->productModel->getSearchedProducts($userInput);

                if($productsInCatalog){
                    $data = [
                        'products' => $productsInCatalog,
                    ];
                    $this->view('products/search', $data);
                } else {
                    $data['error'] = 'La búsqueda no ha devuelto ningún resultado';
                    $this->view('products/error', $data);
                }
            } else {
                $this->view('products/error', $data);
            }
        }
    }

    public function show($category){
        if (isset($_POST['ordenar'])) {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $order = $_POST['ordenar'];
        } else {
            $order = 'default';
        }

        $products = $this->productModel->getProductsByCategory($category, $order);

        $data = [
            'products' => $products,
        ];
        $this->view('products/show', $data);
    }

   public function newIn(){
        $products = $this->productModel->getNewestProducts();

        $data = [
            'products' => $products,
        ];
        $this->view('products/show', $data);
   }
}
