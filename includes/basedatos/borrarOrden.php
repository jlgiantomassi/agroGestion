<?php
include_once '../../conexion/conexion.php';
$id=$_GET["idorden"];
$sql="DELETE FROM ordentrabajos WHERE idordentrabajo =".$id;
$query = mysqli_query($con, $sql);
header('Location:../../verOrdenes.php');
exit;
?>

