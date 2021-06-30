<?php
/**
 * 
 * Crea las urls con el formato "controlador/método/parámetros" y carga los controladores.
 * 
 */

 class Core {
    protected $currentController = 'Products'; //Establecemos el  controlador por defecto
    protected $currentMethod = 'index'; //establecemos el método por defecto
    protected $params = []; //parámetross
       
    public function __construct(){
        //almacenamos la url como un array
        $url = $this->getUrl();

        //1º controlador
        //si el fichero requerido existe, se establece como controlador
        if(file_exists('../app/controllers/' . ucwords($url[0]) . '.php')){
            //si existe
            $this->currentController = ucwords($url[0]);
            //destruir variable
            unset($url[0]);
        }

        //incluimos el archivo del controlador (app/controllers/nombre.php)
        require_once '../app/controllers/'. $this->currentController . '.php';

        //instanciar la clase del controlador
        $this->currentController = new $this->currentController;

        //2º comprobar la segunda parte de la url
        if(isset($url[1])){
            //Si el método existe en el controlador, lo establecemos como currentMethod. 
            if(method_exists($this->currentController, $url[1])){
                $this->currentMethod = $url[1];
              //destruir variable   
            unset($url[1]);
            }
        }

        //3º Parámetros. Si existen, se añaden. Sino, array vacío.
        $this->params = $url ? array_values($url) : [];

        //callback con controlador, método y array de parámetros
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    //devuelve la url
    public function getUrl(){ //parámetro url
        //comprobar si está definido  
        if(isset($_GET['url'])){
            //si lo está, eliminamos la brra final
            $url = rtrim($_GET['url'], '/'); 
            //sanitizar
            $url = filter_var($url, FILTER_SANITIZE_URL);//
            //convertir en array de strings sin /
            $url = explode('/', $url);
            return $url;
        }   
    }    
}