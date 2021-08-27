<?php
$raiz="../../";
include_once '../modelos/ordenesModelo.php';
$id=$_GET["idorden"];
$oOrdenes=new ordenesModel();
$oOrdenes->borrarOrden($id);
header('Location:../../verOrdenes.php');
?>

