<?php
session_start();
require_once("conexion.php");
include_once("./models/product.php");

$sql = "select * from product";
$consulta = $conn->prepare($sql);
// Ejecutar la consulta
$consulta->execute();
// Obtener los resultados
$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
//Compruebo si hay carrito
if (isset($_SESSION["cart"])) {
    $cart = $_SESSION["cart"];
}

if (isset($_SESSION["username"])) {
    //comprobaria si hay carrito en la bbdd
    $user = $_SESSION["username"];
    $iduser = $_SESSION["iduser"];
   // if (!isset($cart) || count($cart) == 0) {
     //   try {
            $sql = "select * from cart_detail where idcart=(select idcart from cart where iduser=? order by date desc limit 1)";
            $stm = $conn->prepare($sql);
            $stm->bindParam(1, $iduser);
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            $cart = array();
            foreach ($result as $key => $p) {
                $_SESSION["idcart"] = $p["idcart"];
                $product = new Product($p["idproduct"], $p["quantity"]);
                array_push($cart, $product); 
            }

            $_SESSION["cart"] = $cart;
            if(isset($_SESSION["idcart"])){
                $idcart=$_SESSION["idcart"];
            }

            //$_SESSION["idcart"]=$result[0]["idcart"];
  //      } catch (Exception $e) {
     //       var_dump($e->getMessage());
     //       exit();
   //     }
   // }
}
$idcart=isset($_SESSION["idcart"])?$_SESSION["idcart"]:"";

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>App Orders</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Mi Tienda</a>
            <div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contacto</a>
                    </li>

                </ul>
                <span id="user"><?php if (isset($user)) echo $user; ?></span>
            </div>
        </div>
    </nav>
    <div class="container contenedor-productos row">
        <div class="shop-cart" id="cart">
            <a class="nav-link" href="cart"><span><i class="fas fa-shopping-cart"></i><?php echo isset($cart) ? count($cart) : ''; ?> </span></a>
            <?php echo isset($_SESSION["idcart"]) ? $_SESSION["idcart"] : "nada" ?>
        </div>
        <h3>Productos</h3>

        <?php
        // Mostrar los resultados
        foreach ($resultados as $product) {
            echo '<div class="card productcard col-md-3 col-sm-12" ">
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
          <form action="add_to_cart.php" method="get">
          <div class="add-to-cart">
            <input type="hidden" name="idcart" value="' . $idcart . '">
            <input type="hidden" name="price" value="' . $product["price"] . '">
            <input type="hidden" name="idproduct" value="' . $product["idproduct"] . '">
            <input min=1 step=1 class="form-control" type="number" name="quantity" id="" required >
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-cart-plus"></i></button>
          </div>
          </form>
        </div>
      </div>';
        }
        ?>
    </div>

    <div class="modal" tabindex="-1" id="modal-login">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="login.php" method="post">
                    <div class="modal-body">
                        <h5>Para continuar comprando hay que inicial sesión</h5>
                        <hr>
                        <input class="form-control email" type="email" name="email" id="" placeholder="Email" required>
                        <input class="form-control" placeholder="Password" type="password" name="password" id="" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="./assets/js/product.js"></script>

</body>

</html>