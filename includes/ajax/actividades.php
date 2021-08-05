<?php
$raiz="../../";
include_once $raiz.'includes/modelos/actividadesModelo.php';
$oActividad=new actividadesModel();

$accion = $_GET['accion'];
switch ($accion) {
    case "guardar":
        $idlotecampana=$_GET["idlotecampana"];
        $idlabor=$_GET["idlabor"];
        $fecha=$_GET["fecha"];
        $superficie=$_GET["superficie"];
        $precioha=$_GET["precioha"];

        echo $oActividad->insertarActividades($idlotecampana,$idlabor,$fecha,$superficie,$precioha);
    break;
    case "cargar":
        $idlotecampana=$_GET["idlotecampana"];
        $datos=$oActividad->cargarActividades($idlotecampana);
        echo json_encode($datos);
    break;
}
?>