<?php
//Proteger ejecución de script
session_start();
$idcartdetail = $_GET["idcartdetail"];
$quantity = $_GET["quantity"];
include("conexion.php");
$sql = "update cart_detail set quantity=? where idcartdetail=?";
$stm = $conn->prepare($sql);
$stm->bindParam(1, $quantity);
$stm->bindParam(2, $idcartdetail);
$stm->execute();
unset($_SESSION["cart"]);
//Recuperamos el resto del carrito
$idcart=$_SESSION["idcart"];
$sql="SELECT D.idcartdetail,D.idcart,D.idproduct,D.price,D.quantity,P.name,P.description,P.image FROM cart_detail as D
left join product as P on D.idproduct=P.idproduct where idcart=?";
$stm=$conn->prepare($sql);
$stm->bindParam(1,$idcart);
$stm->execute();
$result=$stm->fetchAll(PDO::FETCH_ASSOC);


$response = array(
    'idcart' => $idcart,
    'cart'=>$result,
    'mensaje' => '¡Solicitud recibida correctamente!'
);

// Establecer las cabeceras para indicar que la respuesta es JSON
header('Content-Type: application/json');

// Devolver la respuesta en formato JSON
echo json_encode($response);
