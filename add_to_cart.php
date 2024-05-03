<?php
include_once("./models/product.php");
session_start();
var_dump($_SESSION);
var_dump($_GET);
if (isset($_GET["idproduct"])) {
    $idproduct = $_GET["idproduct"];
    $quantity = isset($_GET["quantity"]) ? $_GET["quantity"] : 1;
    //Comprobamos si el usuario se ha logeado
    if (isset($_SESSION["username"])) {
        $iduser=$_SESSION["iduser"];
        //Guardamos en bbdd   
        $price = $_GET["price"];
        include("conexion.php");
        if (isset($_SESSION["idcart"])) {
            $idcart = $_SESSION["idcart"];
        } else {
            //Guardamos el carrito en bbdd
            $sql = "insert into cart (iduser) value (?)";
            $stm = $conn->prepare($sql);
            $stm->bindParam(1, $iduser);
            $stm->execute();
            $idcart = $conn->lastInsertId();
            $_SESSION["idcart"] = $idcart;
        }
        $sql = "insert into cart_detail (idcart,idproduct,quantity,price)
             values (?,?,?,?)";
             var_dump($_GET);
             var_dump($idcart);
            $stm = $conn->prepare($sql);
            $stm->bindParam(1, $idcart);
            $stm->bindParam(2, $idproduct);
            $stm->bindParam(3, $quantity);
            $stm->bindParam(4, $price);
            $stm->execute();
    } else {
        //Guardamos el carrito en session
        $product = new Product($idproduct, $quantity);
        if (isset($_SESSION["cart"])) {
            $cart = $_SESSION["cart"];
        } else {
            $cart = array();
        }
        array_push($cart, $product);
        $_SESSION["cart"] = $cart;
    }
}

header("Location: ./");
exit();
