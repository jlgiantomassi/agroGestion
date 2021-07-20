<?php

include '../../conexion/BaseDatos.php';
$bd1=new BaseDatos();

$idorden=0;
$flag=true;
if(isset($_REQUEST["orden"]))
{
    $bd1->begin();
    $datos=json_decode($_REQUEST["orden"]);
    if(mysqli_query($con, "INSERT INTO ordentrabajos (fecha, idlabor,precio,observaciones,superficie,realizado,idusuario,idcampana) VALUES ('" . fecha_a_mysql($datos->fecha) . "','" . $datos->idlabor . "','" . $datos->precioLabor . "','" . $datos->observacion . "','" . $datos->supTotal . "',0,'" . $datos->idusuario . "','" . $datos->idcampana . "')"))
        $idorden = mysqli_insert_id($con);
    else
        $flag=false;
}
if(isset($_REQUEST["productores"]))
{
    $datos=json_decode($_REQUEST["productores"]);
    foreach ($datos as $key) {
        $idproductor = $key->idproductor;
        $superficie = $key->superficie;
        if(!mysqli_query($con, "INSERT INTO orden_productores (idordentrabajo, idproductor,superficie) VALUES ('" . $idorden . "','" . $idproductor . "','" . $superficie . "')"))
            $flag=false;
    }
    
}

if(isset($_REQUEST["personales"]))
{
    $datos=json_decode($_REQUEST["personales"]);
    foreach ($datos as $key) {
        $idpersonal = $key->idpersonal;
        $superficie = $key->superficie;
        $precioHa= $key->precioHa;  
        if(!mysqli_query($con, "INSERT INTO orden_personales (idordentrabajo, idpersonal,superficie,precioHa) VALUES ('" . $idorden . "','" . $idpersonal . "','" . $superficie . "','" . $precioHa . "')"))
            $flag=false;
    }
    
}
if(isset($_REQUEST["campos"]))
{
    $datos=json_decode($_REQUEST["campos"]);
    foreach ($datos as $key) {
        $idlote = $key->idlote;
        $superficie = $key->superficie; 
        if(!mysqli_query($con, "INSERT INTO orden_lotes (idordentrabajo, idlote,superficie) VALUES ('" . $idorden . "','" . $idlote . "','" . $superficie . "')"))
            $flag=false;
    }
}

if(isset($_REQUEST["insumos"]))
{
    $datos=json_decode($_REQUEST["insumos"]);
    foreach ($datos as $key) {
        $idinsumo = $key->idinsumo;
        $cantidad = $key->cantidad;
        $superficie = $key->superficie;
        $precio = $key->precio;
        $cantidadTotal=$cantidad*$superficie;
        $precioTotal=$cantidadTotal*$precio;
        if(!mysqli_query($con, "INSERT INTO orden_insumos (idordentrabajo,idinsumo,cantidadHa,cantidadTotal,precioUn,precioTotal) VALUES ('" . $idorden . "','" . $idinsumo . "','" . $cantidad . "','" . $cantidadTotal . "','" . $precio . "','" . $precioTotal . "')"))
            $flag=false;
    }
    
}

if(isset($_REQUEST["terceros"]))
{
    $datos=json_decode($_REQUEST["terceros"]);
    foreach ($datos as $key) {
        $idtercero = $key->idtercero;
        $precioHaTercero = $key->precioHaTercero; 
        if(!mysqli_query($con, "INSERT INTO orden_terceros (idordentrabajo, idtercero,precioHa) VALUES ('" . $idorden . "','" . $idtercero . "','" . $precioHaTercero . "')"))
            $flag=false;
    }
    
}

if($flag)
{
    mysqli_commit($con);
    mysqli_autocommit($con,true);
    mysqli_close($con);
    $datos = true;
    echo json_encode($datos);
}else{
    mysqli_rollback($con);
    $datos = false;
    echo json_encode($datos);
    mysqli_autocommit($con,true);
    mysqli_close($con);

}
 
       
function fecha_a_normal($fecha) {
    if ($fecha == "") {
        return "";
    } else {
        ereg("([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
        $lafecha = $mifecha[3] . "/" . $mifecha[2] . "/" . $mifecha[1];
        return $lafecha;
    }
}

function fecha_a_mysql($fecha) {
    if ($fecha == "") {
        return null;
    } else {
        ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
        $lafecha = $mifecha[3] . "-" . $mifecha[2] . "-" . $mifecha[1];
        return $lafecha;
    }
}
?>