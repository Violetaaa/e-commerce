<?php
class Users extends Controller{
    public function __construct() {
        //cargar modelo
        $this->userModel = $this->model('User');
    }

    public function index(){
        $this->view('users/index');
    }

  
    public function register(){
        //Si la solicitud es de tipo POST, procesamos el formulario
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Sanitizamos los datos enviados
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            //Inicializamos el array que contendrá los datos y errores del formulario 
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

            //Validamos los datos introducidos por el usuario
            if(empty($data['email'])){//Comprobar si el usuario ha introducido un email
                $data['errorEmail'] = 'Este campo es obligatorio';
            } else if ($this->userModel->findUserByEmail($data['email'])){  //Comprobar si el email ya existe en la base de datos
                $data['errorEmail'] = 'La dirección de correo ya pertenece a un usuario registrado';
                //comprar que se ha introducido un email válido
            } else if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                $data['errorEmail']= 'No es una dirección de correo válida';
            }

             //Comprobar si el usuario ha introducido una contraseña
             if(empty($data['pass'])){
                $data['errorPass'] = 'Este campo es obligatorio';
            } else if (strlen($data['pass']) <6){//comprobar que al campo tiene al menos 8 carácteres
                $data['errorPass'] ='Al menos 8 carácteres';
            }

             //Comprobar si el usuario ha introducido nuevamente la contraseña
             if(empty($data['repeatPass'])){
                $data['errorRepeatPass'] = 'Este campo es obligatorio';
            } else if($data['pass'] != $data['repeatPass']){ //comprobar que coincide con la primera constraseña introducida
                $data['errorRepeatPass'] = 'La contraseña no coincide';
            } 
            //comprobar que se introdujeron el resto de datos
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

            //Si no hay errores, continuamos con el registro
            if(empty($data['errorEmail']) && empty($data['errorName']) && empty($data['errorPass']) && empty($data['errorRepeatPass']) && empty($data['errorName']) && empty($data['errorSurname']) && empty($data['errorAddress']) && empty($data['errorCity']) && empty($data['errorPostalCode'])  && empty($data['errorState']) && empty($data['errorCountry'])){
                //Hash de la contraseña
                $data['pass'] = password_hash($data['pass'], PASSWORD_DEFAULT);
                //Registramos el usuario 
                if($this->userModel->register($data)){
                    header('location: ' . URLROOT . '/users/index');
               } else {
                    die('Error');
               }
            } else {  //Si hay errores, cargamos la vista y los mostramos
                $this->view('users/register', $data);
            }
        } else {
            //cargamos de nuevo el formulario en blanco 
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
            //cargamos la vista
            $this->view('users/register', $data);
        }     
    }

    public function login(){
        //Si la solicitud es de tipo POST, procesamos el formulario
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Sanitizamos los datos enviados
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            //Inicializamos el array que contendrá los datos del formulario 
            $data =[
                'email' => trim($_POST['email']),
                'pass' => trim($_POST['pass']),
                'error' => '',    
            ];

             //Validamos los datos introducidos por el usuario
             if(empty($data['email'])){ //Comprobar si el usuario ha introducido un email
                $data['error'] = 'El campo email no puede estar vacío';
            } else { //Comprobar si el email introducido existe en la base de datos
                if (!$this->userModel->findUserByEmail($data['email'])){
                    $data['error'] = 'El email no existe';
                }            
            }
           
             //Comprobar si el usuario ha introducido la contraseña
            if(empty($data['pass'])){
                $data['error'] = 'El campo contraseña no puede estar vacío';
            }

            //Si no hay errores, continuamos con el login
            if(empty($data['error'])){
                
               //Comprobamos si usuario y contraseña coinciden 
               $loggedInUser = $this->userModel->login($data['email'],$data['pass']);
                //Si el email y contraseña son correctos, creamos las variables de sesión
               if($loggedInUser){
                   $this->createUserSession($loggedInUser);
                   //almacenamos la información para redirigir 
                   $data['redirect']='products/index';
                   echo json_encode($data, JSON_PRETTY_PRINT);
               }else{
                   //Si el email y contraseña no coinciden, mostramos el error
                   $data['error'] = 'Contraseña incorrecta';
             
                    echo json_encode($data, JSON_PRETTY_PRINT);
               }
            } else {
                // Si había errores, los mostramos
                echo json_encode($data, JSON_PRETTY_PRINT);
              
            }

        } else {
            // formulario en blanco
            $data = [        
                'email' =>'',
                'password' => '',
                'error' => '',
            ];

            //c
            echo json_encode($data, JSON_PRETTY_PRINT);
        }     
    } 

    //crear variables de sesión del usuario
    public function createUserSession($user){
        $_SESSION['user_id'] = $user->id; 
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
     }

    //cerrar sesión, eliminar variables de sesión y redirigir al ususario a la página principal
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


