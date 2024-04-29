<?php
session_start();
if(isset($_SESSION["username"])){
  if(isset($_SESSION["cart"])){
    //Existe usuario y carrito en session
    $user=$_SESSION["username"];
    $cart=$_SESSION["cart"];
    //Consultamos información de los productos a la bbdd
    require_once("conexion.php");
    

  }else{
    header("Location: ./");
    exit();
  }
}else{
     header("Location: ./");
     exit();
}
 
?>