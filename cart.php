<?php
session_start();
if(isset($_SESSION["username"])){
  if(isset($_SESSION["cart"])){
    //Existe usuario y carrito en session
    $user=$_SESSION["username"];
    $cart=$_SESSION["cart"];
    //Consultamos información de los productos a la bbdd
    require_once("conexion.php");
    foreach ($cart as $product) {
        $sql="select * from product where idproduct=?";
        $stm=$conn->prepare($sql);
        $stm->bindParam(1,$product->idproduct);
        $stm->execute();
        if($stm->rowCount()>0){
            $result=$stm->fetchAll(PDO::FETCH_ASSOC);
            $product->name=$result[0]["name"];
            $product->description=$result[0]["description"];
            $product->price=$result[0]["price"];
            $product->image=$result[0]["image"];
        }

    }

  }else{
    header("Location: ./");
    exit();
  }
}else{
     header("Location: ./");
     exit();
}

echo $cart;
?>

