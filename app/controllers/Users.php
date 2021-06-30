<?php
class Users extends Controller{
    public function __construct() {
        $this->userModel = $this->model('User');
    }

    public function index(){
        $this->view('users/index');
    }

    public function register(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'email' =>trim($_POST['email']),
                'pass' => trim($_POST['pass']),
                'repeatPass' => trim($_POST['repeatPass']),
                'name' => trim($_POST['name']),
                'surname' => trim($_POST['surname']),
                'address' => trim($_POST['address']),
                'city' => trim($_POST['city']),
                'postalCode' => trim($_POST['postalCode']),
                'state' => trim($_POST['state']),
                'country' => trim($_POST['country']),
                'error' => '',
                'errorPass' => '',
                'errorRepeatPass' => '',
                'errorName' => '',
                'errorSurname' => '',
                'errorAddress' => '',
                'errorPostalCode' => '',
                'errorCity' => '',
                'errorState' => '',
                'errorCountry' => ''
            ];

            if(empty($data['email'])){
                $data['errorEmail'] = 'Este campo es obligatorio';
            } else if ($this->userModel->findUserByEmail($data['email'])){  
                $data['errorEmail'] = 'La dirección de correo ya pertenece a un usuario registrado';
            } else if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                $data['errorEmail']= 'No es una dirección de correo válida';
            }

            if(empty($data['pass'])){
                $data['errorPass'] = 'Este campo es obligatorio';
            } else if (strlen($data['pass']) <6){
                $data['errorPass'] ='Al menos 8 carácteres';
            }

            if(empty($data['repeatPass'])){
                $data['errorRepeatPass'] = 'Este campo es obligatorio';
            } else if($data['pass'] != $data['repeatPass']){ 
                $data['errorRepeatPass'] = 'La contraseña no coincide';
            } 

            if(empty($data['name'])){
                $data['errorName'] = 'Este campo es obligatorio';
            }
            if(empty($data['surname'])){
                $data['errorSurname'] = 'Este campo es obligatorio';
            }
            if(empty($data['address'])){
                $data['errorAddress'] = 'Este campo es obligatorio';
            }
            if(empty($data['city'])){
                $data['errorCity'] = 'Este campo es obligatorio';
            }
            if(empty($data['postalCode'])){
                $data['errorPostalCode'] = 'Este campo es obligatorio';
            }
            if(empty($data['state'])){ 
                $data['errorState'] = 'Este campo es obligatorio';
            }
            if(empty($data['country'])){
                $data['errorCountry'] = 'Este campo es obligatorio';
            }

            if(empty($data['errorEmail']) && empty($data['errorName']) && empty($data['errorPass']) && empty($data['errorRepeatPass']) && empty($data['errorName']) && empty($data['errorSurname']) && empty($data['errorAddress']) && empty($data['errorCity']) && empty($data['errorPostalCode'])  && empty($data['errorState']) && empty($data['errorCountry'])){
                $data['pass'] = password_hash($data['pass'], PASSWORD_DEFAULT);
                if($this->userModel->register($data)){
                    header('location: ' . URLROOT . '/users/index');
               } else {
                    die('Error');
               }
            } else {  
                $this->view('users/register', $data);
            }
        } else {
            $data = [
                'email' => '',
                'pass' =>  '',
                'repeatPass' =>  '',
                'name' =>  '',
                'surname' =>  '',
                'address' =>  '',
                'city' =>  '',
                'postalCode' =>  '',
                'state' =>  '',
                'country' =>  '',
                'errorEmail' => '',
                'errorPass' => '',
                'errorRepeatPass' => '',
                'errorName' => '',
                'errorSurname' => '',
                'errorAddress' => '',
                'errorPostalCode' => '',
                'errorCity' => '',
                'errorState' => '',
                'errorCountry' => ''
            ];
            $this->view('users/register', $data);
        }     
    }

    public function login(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data =[
                'email' => trim($_POST['email']),
                'pass' => trim($_POST['pass']),
                'error' => '',    
            ];

             if(empty($data['email'])){
                $data['error'] = 'El campo email no puede estar vacío';
            } else { 
                if (!$this->userModel->findUserByEmail($data['email'])){
                    $data['error'] = 'El email no existe';
                }            
            }
           
            if(empty($data['pass'])){
                $data['error'] = 'El campo contraseña no puede estar vacío';
            }

            if(empty($data['error'])){
                
               $loggedInUser = $this->userModel->login($data['email'],$data['pass']);
               if($loggedInUser){
                   $this->createUserSession($loggedInUser);
                   $data['redirect']='products/index';
                   echo json_encode($data, JSON_PRETTY_PRINT);
               }else{
                   $data['error'] = 'Contraseña incorrecta';
             
                    echo json_encode($data, JSON_PRETTY_PRINT);
               }
            } else {
                echo json_encode($data, JSON_PRETTY_PRINT);
              
            }

        } else {
            $data = [        
                'email' =>'',
                'password' => '',
                'error' => '',
            ];

            echo json_encode($data, JSON_PRETTY_PRINT);
        }     
    } 

    public function createUserSession($user){
        $_SESSION['user_id'] = $user->id; 
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
     }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        session_destroy();
        header('location: ' . URLROOT . '/products/index');

    }    
    
    public function authenticationRequired(){
        $this->view('users/error');
    }
}


