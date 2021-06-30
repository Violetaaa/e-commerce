<?php
session_start();

//comprobar si carrito creado
if (empty($_SESSION['cart'])){
  $_SESSION['cart'] = [];
}
//comprobar si usuario logueado
 function isLogged(){
    if(isset($_SESSION['user_id'])){
        return true;
    } else {
        return false;
    }
}