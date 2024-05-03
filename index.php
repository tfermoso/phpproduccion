<?php
session_start();
var_dump($_SESSION);

require_once("conexion.php");
include_once("./models/product.php");

$sql = "select * from product";
$consulta = $conn->prepare($sql);
// Ejecutar la consulta
$consulta->execute();
// Obtener los resultados
$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

if (isset($_SESSION["username"])) {
    //comprobaria si hay carrito en la bbdd
    $user = $_SESSION["username"];
    $iduser = $_SESSION["iduser"];
    $sql = "select C.idcart from cart C 
    left join `order` O on C.idcart=O.idcart 
    where iduser=? and O.idcart is null order by C.date desc limit 1";
    $stm = $conn->prepare($sql);
    $stm->bindParam(1, $iduser);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    var_dump($result);
    if ($stm->rowCount() > 0) {
        var_dump($result);
        $idcart = $result[0]["idcart"];
        //Consulto los articulos del carrito
        $sql = "select * from cart_detail where idcart=?";
        $stm = $conn->prepare($sql);
        $stm->bindParam(1, $idcart);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        $cart = array();
        foreach ($result as $key => $p) {
            $product = new Product($p["idproduct"], $p["quantity"]);
            array_push($cart, $product);
        }

        $_SESSION["idcart"] = $idcart;
        $_SESSION["cart"] = $cart;
    }
} else {
    if (isset($_SESSION["cart"])) {
        $cart = $_SESSION["cart"];
    }
}


?>
<?php include("header.php"); ?>
    <div class="container contenedor-productos row">
        <div class="shop-cart" id="cart">
            <a class="nav-link" href="cart"><span><i class="fas fa-shopping-cart"></i><?php echo isset($cart) ? count($cart) : ''; ?> </span></a>
            <?php echo isset($idcart) ? $idcart : "nada" ?>
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

<?php include("footer.php"); ?>