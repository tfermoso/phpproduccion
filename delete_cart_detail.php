<?php
//Proteger ejecución de script
session_start();
$idcartdetail = $_GET["idcartdetail"];
include("conexion.php");
$sql = "delete from cart_detail where idcartdetail=?";
$stm = $conn->prepare($sql);
$stm->bindParam(1, $idcartdetail);
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
