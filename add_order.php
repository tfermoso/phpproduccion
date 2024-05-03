<?php
session_start();
if(isset($_SESSION["username"]) && isset($_SESSION["idcart"])){
    $iduser=$_SESSION["iduser"];
    $user = $_SESSION["username"];
    $idcart=$_SESSION["idcart"];
    if(isset($_POST["date"])){
        $date=$_POST["date"];
        $idaddress=$_POST["idaddress"];
        include("conexion.php");
        $sql="insert into `order` (deliverydate,idcart,idaddress) values (?,?,?)";
        $stm=$conn->prepare($sql);
        $stm->bindParam(1,$date);
        $stm->bindParam(2,$idcart);
        $stm->bindParam(3,$idaddress);
        $stm->execute();
        if($stm->rowCount()>0){
            //Pendiente borrar datos de session
            unset($_SESSION["cart"]);
            unset($_SESSION["idcart"]);
            //header("Location: ./");
            //exit();
        }

    }else{
        header("Location: ./");
        exit();
    }
}else{
    header("Location: ./");
}
?>
<?php include("header.php");?>
<div class="container">
<div class="alert alert-primary alerta" role="alert" >
  Pedido creado correctamente, <a href="./" class="alert-link">continuar</a>.
</div>
</div>
<?php include("footer.php");?>