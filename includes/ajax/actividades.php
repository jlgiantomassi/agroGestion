<?php
$raiz="../../";
include_once $raiz.'includes/modelos/actividadesModelo.php';
include_once $raiz.'includes/modelos/cultivosModelo.php';
$oActividad=new actividadesModel();
$oCultivo=new cultivosModel();

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
    case "insLabor":
        $labor=$_GET["labor"];
        $precio=$_GET["precio"];
        $idusuario=$_["idusuario"];
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
    case "modificarInsumosDeActividad":
        $id=$_GET["idactividad"];
        $superficie=$_GET["superficie"];
        $datos=$oActividad->modificarInsumosDeActividad($id,$superficie);
        echo $datos;
    break;
    case "tipoMaquinaria":
        $id=$_GET["idactividad"];
        $datos=$oActividad->actividadMaquinaria($id);
        echo json_encode($datos);
    break;
    case "guardarTipoMaquinaria":
        $id=$_GET["idactividad"];
        $tipo=$_GET["tipoMaquinaria"];
        $oActividad->borrarActividadesPersonales($id);
        $oActividad->borrarActividadesTerceros($id);
        $datos=$oActividad->guardarActividadMaquinaria($id,$tipo);
        echo $datos;
    break;
    case "agregarPersonal":
        $idactividad=$_GET["idactividad"];
        $idpersonal=$_GET["idpersonal"];
        $precioHa=$_GET["precioHa"];
        $datos=$oActividad->guardarActividadPersonal($idactividad,$idpersonal,$precioHa);
        echo json_encode($datos);
    break;
    case "agregarTercero":
        $idactividad=$_GET["idactividad"];
        $idtercero=$_GET["idtercero"];
        $precioHa=$_GET["precioHa"];
        $datos=$oActividad->guardarActividadTercero($idactividad,$idtercero,$precioHa);
        echo json_encode($datos);
    break;

    case "listaPersonales":
        $idactividad=$_GET["idactividad"];
        $datos=$oActividad->listarPersonales($idactividad);
        echo json_encode($datos);
    break;
    case "listaTerceros":
        $idactividad=$_GET["idactividad"];
        $datos=$oActividad->listarTerceros($idactividad);
        echo json_encode($datos);
    break;
    case "borrarPersonal":
        $id=$_GET["idactividad_personal"];
        echo $oActividad->borrarPersonales($id);
    break;
    case "borrarTercero":
        $id=$_GET["idactividad_tercero"];
        echo $oActividad->borrarTerceros($id);
    break;
    case "modificarPersonal":
        $id=$_GET["idactividad_personal"];
        $precioHa=$_GET["precioHa"];
        echo $oActividad->modificarPersonales($id,$precioHa);
    break;
    case "modificarTercero":
        $id=$_GET["idactividad_tercero"];
        $precioHa=$_GET["precioHa"];
        echo $oActividad->modificarTerceros($id,$precioHa);
    break;
    case "guardarObservaciones":
        $id=$_GET["idactividad"];
        $observaciones=$_GET["observaciones"];
        echo $oActividad->guardarObservaciones($id,$observaciones);
    break;
    case "importeInsumosLote":
        $id=$_GET["idlotecampana"];
        echo json_encode($oActividad->importeInsumos($id));
    break;
    case "capitalizacion":
        $id=$_GET["idlotecampana"];
        $estado=$_GET["estado"];
        echo $oCultivo->capitalizacion($id,$estado);
    break;
    case "insProductorActividad":
        $idactividad=$_GET["idactividad"];
        $idempresa=$_GET["idempresa"];
        $total=$_GET["total"];
        echo $oActividad->guardarProductorActividad($idactividad,$idempresa,$total);
    break;
    case "ProductorActividad":
        $idactividad=$_GET["idactividad"];
        echo json_encode($oActividad->ProductorActividad($idactividad));
    break;

}
?>