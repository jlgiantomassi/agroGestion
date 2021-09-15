<?php
$raiz="";
include("includes/controlLogin.php");

include_once "includes/modelos/remitosModelo.php";
$idremito=$_GET["idremito"];
$oRemito=new remitosModel();
$oRemito->eliminar($idremito,$idEmpresaActiva);
header('Location: remitos.php');
?>