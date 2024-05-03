<?php
include_once("./models/product.php");
session_start();
if (isset($_SESSION["username"])) {
    $user = $_SESSION["username"];
    if (isset($_SESSION["cart"])) {
        //Existe usuario y carrito en session
        $user = $_SESSION["username"];
        $cart = $_SESSION["cart"];
        $iduser = $_SESSION["iduser"];

        require_once("conexion.php");
        //Consultamos las direcciones del usuario
        $slq = "select * from address where iduser=" . $iduser;
        $stm = $conn->prepare($slq);
        $stm->execute();
        $address = $stm->fetchAll(PDO::FETCH_ASSOC);
        //Consultamos información de los productos a la bbdd
        foreach ($cart as $product) {
            $sql = "select * from product where idproduct=?";
            $stm = $conn->prepare($sql);
            $stm->bindParam(1, $product->idproduct);
            $stm->execute();
            if ($stm->rowCount() > 0) {
                $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                $product->name = $result[0]["name"];
                $product->description = $result[0]["description"];
                $product->price = $result[0]["price"];
                $product->image = $result[0]["image"];
            }
        }
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
        //Borramos la tabla cartdetail
        $sql = "delete from cart_detail where idcart=" . $idcart;
        $stm = $conn->prepare($sql);
        $stm->execute();
        //Insertamos los productos en cart_detail
        foreach ($cart as $key => $product) {
            $sql = "insert into cart_detail (idcart,idproduct,quantity,price) values (?,?,?,?)";
            $stm = $conn->prepare($sql);
            $stm->bindParam(1, $idcart);
            $stm->bindParam(2, $product->idproduct);
            $stm->bindParam(3, $product->quantity);
            $stm->bindParam(4, $product->price);
            $stm->execute();
            $idcartdetail = $conn->lastInsertId();
            $product->idcartdetail = $idcartdetail;
        }
    } else {
        header("Location: ./");
        exit();
    }
} else {
    header("Location: ./");
    exit();
}

var_dump($cart);
?>
<?php include("header.php"); ?>
    <div class="container contenedor-productos row">
        <div class="shop-cart" id="cart">
            <a class="nav-link" href="cart"><span><i class="fas fa-shopping-cart"></i><span id="products_count"><?php echo isset($cart) ? count($cart) : ''; ?></span> </span></a>
        </div>
        <h3>Carrito</h3>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col">Product</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Total</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($cart as $key => $product) {
                        $total += $product->price * $product->quantity;
                        echo '<tr id="idcartdetail' . $product->idcartdetail . '">
                            <th scope="row">' . $key . '</th>
                            <td><img class="img-cart" src="assets/product/' . $product->image . '" alt="" srcset=""></td>
                            <td>
                                <h6>' . $product->name . '</h6>
                                <p>' . $product->description . '</p>
                            </td>
                            <td><input class="quantity" type="number" name="" id="" value="' . $product->quantity . '"></td>
                            <td>' . $product->price . ' €/kg</td>
                            <td>' . $product->price * $product->quantity . ' €</td>
                            <td><span class="delete" ><i class="fa-solid fa-x"></i></span></td>
                        </tr>';
                    }
                    echo "<tr><td class='importe_total'  colspan='5'>Total:</td><td class='euros_total' id='euros_total' colspan='2'>" . $total . " €</td></tr>"

                    ?>


                </tbody>
            </table>
        </div>
        <button class="btn btn-success" id="btnConfir" type="button">Order Confirm</button>
        <div class="datos_envio">
            <form action="add_order" method="post">
                <span>Delivery date:</span><input type="date" name="date" required>
                <hr>
                <span>Delivery Address:</span>
                <div class="address row">
                    <?php
                    foreach ($address as $key => $dir) {
                        echo '<div class="col-md-3 col-sm-12">
                    <input type="radio" name="idaddress" value="' . $dir["idaddress"] . '"  required>
                    <h5>' . $dir["street"] . '</h5>
                    <p><span>' . $dir["zipcode"] . '</span>-<span>' . $dir["city"] . '</span></p>
                    <p>' . $dir["country"] . '</p>
                </div>';
                    }
                    ?>

                </div>
                <div>
                    <a href="add_address"><i class="fa-solid fa-location-dot"></i><i class="fa-solid fa-plus"></i></a>
                </div>
                <input type="submit" value="Create Order" class="btn btn-success">
            </form>
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