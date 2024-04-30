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


$response = array(
    'pairam1' => $idcartdetail,
    'mensaje' => '¡Solicitud recibida correctamente!'
);

// Establecer las cabeceras para indicar que la respuesta es JSON
header('Content-Type: application/json');

// Devolver la respuesta en formato JSON
echo json_encode($response);
