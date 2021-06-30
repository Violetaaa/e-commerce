<?php
/**
 * Controlador base. Carga los modelos y las vistas
 */
 class Controller{
     //carga el modelo que se pasa por parámetro
     public function model($model){
        //requerimos el archivo .php del modelo que queremos cargar
        require_once '../app/models/' . $model . '.php';
        //devuelve una nueva instancia del modelo
        return new $model();
     }

     //carga la vista
     public function view($view, $data=[]){
         //comprobamos si existe el archivo de la vista
        if(file_exists('../app/views/' . $view . '.php')){
            //Si existe, cargamos el archivo
            require_once '../app/views/' . $view . '.php';
        } else {
            //Si no existe, mostramos un mensaje de error
            die('La vista no existe');
        } 
     }
 }