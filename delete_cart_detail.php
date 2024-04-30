<?php
$id=$_GET["idcartdetail"];
$response = array(
    'param1' => $id,
    'mensaje' => '¡Solicitud recibida correctamente!'
);

// Establecer las cabeceras para indicar que la respuesta es JSON
header('Content-Type: application/json');

// Devolver la respuesta en formato JSON
echo json_encode($response);
?>