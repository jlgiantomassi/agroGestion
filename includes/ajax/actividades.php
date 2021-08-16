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
    case "borrar":
        $idactividad=$_GET["idactividad"];
        $datos=$oActividad->borrarActividades($idactividad);
        echo $datos;
    break;
    case "modificar":
        $idactividad=$_GET["idactividad"];
        $fecha=$_GET["fecha"];
        $superficie=$_GET["superficie"];
        $precioHa=$_GET["precioHa"];
        $datos=$oActividad->modificarActividades($idactividad,$fecha,$precioHa,$superficie);
        echo $datos;
    break;
    case "listaInsumos":
        $idactividad=$_GET["idactividad"];
        $datos=$oActividad->cargarInsumos($idactividad);
        echo json_encode($datos);
    break;
    case "insertarInsumo":
        $idactividad=   $_GET["idactividad"];
        $superficie=    $_GET["superficie"];
        $precio=        $_GET["precio"];
        $cantidadha=    $_GET["cantidadha"];
        $idinsumo=      $_GET["idinsumo"];
        echo $oActividad->insertarActividadInsumo($idactividad,$idinsumo,$precio,$cantidadha,$superficie*$cantidadha);
    break;
    case "borrarInsumo":
        $id=$_GET["idactividad_insumo"];
        echo $oActividad->borrarActividadInsumo($id);
    break;
    case "modificarInsumo":
        $id=$_GET["idactividad_insumo"];
        $precio=$_GET["precio"];
        $cantidadHa=$_GET["cantidadHa"];
        $cantidadTotal=$_GET["cantidadTotal"];
        $datos=$oActividad->modificarActividadInsumo($id,$precio,$cantidadHa,$cantidadTotal);
        echo $datos;
    break;
}
?>