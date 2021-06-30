<?php
  //cargar archivo de configuración
  require_once 'config/config.php';
  
  //cargar helper
require_once 'helpers/session_helper.php';

  //autocarga de clases de libraries
  spl_autoload_register(function($className){
    require_once 'libraries/' . $className . '.php';
  });
