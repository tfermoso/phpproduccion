<?php
require_once("conexion.php");
$sql="select * from product";
$consulta = $conexion->prepare($sql);
// Ejecutar la consulta
$consulta->execute();
// Obtener los resultados
$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Pedidos</title>
</head>
<body>
    <?php
    // Mostrar los resultados
    foreach ($resultados as $product) {
        echo "Name: " . $product['name'] . "<br>";
        echo "price: " . $product['price'] . "<br>";
        // Puedes mostrar más columnas según la estructura de tu tabla
        echo "<br>";
    }
    ?>
</body>
</html>