<?php
if(isset($_POST["email"])){
    try{
        require_once("conexion.php");
        $email=$_POST["email"];
        $password=$_POST["password"];
        $sql="select * from user where email=? and password=?";
        $stm=$conn->prepare($sql);
        $stm->bindParam(1,$email);
        $stm->bindParam(2,$password);
        $stm->execute();
        if($stm->rowCount()>0){
            $result=$stm->fetchAll(PDO::FETCH_ASSOC);
            $username=$result[0]["username"];
            $iduser=$result[0]["iduser"];
            session_start();
            $_SESSION["username"]=$username;
            $_SESSION["iduser"]=$iduser;
            header("Location: ./");
            exit();
        }else{
            $error="Usuario o Contraseña incorrecto";
        }
    }catch(Exception $e){
        $error="Error interno ".$e->getMessage();
    }
    
}
?>

<?php
if(isset($error)){
    echo $error;
}
?>

