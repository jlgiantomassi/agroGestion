<?php
include_once "includes/modelos/facturasModelo.php";
$idfactura=$_GET["idfactura"];
$oFactura=new facturasModel();
$oFactura->eliminar($idfactura);
header('Location: facturas.php');
?>