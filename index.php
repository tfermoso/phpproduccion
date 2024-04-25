<?php
require_once("conexion.php");
$sql = "select * from product";
$consulta = $conn->prepare($sql);
// Ejecutar la consulta
$consulta->execute();
// Obtener los resultados
$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/index.css">
    <title>App Orders</title>
</head>

<body>
    <?php
    // Mostrar los resultados
    foreach ($resultados as $product) {
        echo '<div class="card" style="width: 18rem;">
        <img src="assets/product/' . $product["image"] . '" class="card-img-top" alt="...">
        <div class="card-body">
        <div class="producto-detalle">
            <div>  
                <h5 class="card-title">' . $product["name"] . '</h5>
                <p class="card-text">' . $product["description"] . '</p>
            </div>
            <div>
                <h5 class="card-title">' . $product["price"] . '€/kg</h5>
            </div>
          </div>
          <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
      </div>';
    }
    ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>