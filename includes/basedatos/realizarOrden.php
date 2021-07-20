<?php
    include_once '../../conexion/conexion.php';
    //actualizar ordentrabajos y dejar la orden como realizada
    $id=$_GET["idorden"];
    $sql="UPDATE ordentrabajos SET realizado=1 WHERE idordentrabajo =".$id;
    $query = mysqli_query($con, $sql);

    //cargar los datos de la orden a actividades
    

    header('Location:../../verOrdenes.php');
    exit;
?>

