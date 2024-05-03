<?php
if (isset($_POST["email"])) {
    try {
        require_once("conexion.php");
        $email = $_POST["email"];
        $password = $_POST["password"];
        $sql = "select * from user where email=? and password=?";
        $stm = $conn->prepare($sql);
        $stm->bindParam(1, $email);
        $stm->bindParam(2, $password);
        $stm->execute();
        if ($stm->rowCount() > 0) {
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            $username = $result[0]["username"];
            $iduser = $result[0]["iduser"];
            session_start();
            $_SESSION["username"] = $username;
            $_SESSION["iduser"] = $iduser;
            header("Location: ./");
            exit();
        } else {
            $error = "Usuario o Contraseña incorrecto";
        }
    } catch (Exception $e) {
        $error = "Error interno " . $e->getMessage();
    }
}
?>

<?php
if (isset($error)) {
    echo $error;
}
?>
<?php include("header.php"); ?>
<div class="container contenedor-productos row">
    <form action="login.php" method="post">
        <div class="modal-body">
            <h5>Para continuar comprando hay que iniciar sesión</h5>
            <hr>
            <input class="form-control email" type="email" name="email" id="" placeholder="Email" required>
            <input class="form-control" placeholder="Password" type="password" name="password" id="" required>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
    </form>
    <a href="register">*Create new account</a>
</div>

<?php include("footer.php"); ?>