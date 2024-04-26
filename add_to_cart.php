<?php
include_once("./models/product.php");
session_start();

if(isset($_GET["idproduct"])){
    $idproduct=$_GET["idproduct"];
    $quantity=isset($_GET["quantity"])?$_GET["quantity"]:1;
    //Comprobamos si el usuario se ha logeado
    if(isset($_SESSION["user"])){
        //Guardamos en bbdd
    }else{
        //Guardamos el carrito en session
        $product=new Product($idproduct,$quantity);
        if(isset($_SESSION["cart"])){
            $cart=$_SESSION["cart"];                  
        }else{
            $cart=array();  
        }
        array_push($cart,$product);
        $_SESSION["cart"]=$cart;
      
    }
}
header("Location: ./");
exit();
?>