<?php
include_once '../../conexion/BaseDatos.php';
include_once '../funciones.php';
include_once '../controlLogin.php';
$bd=new BaseDatos();
if(isset($_REQUEST["descripcion"]))
{
    $fecha=$_REQUEST["fecha"];
    $idempresa=$_REQUEST["idempresa"];
    $sql="INSERT INTO `facturas`(`fecha`,`idempresa`) VALUES ('".fecha_a_mysql($fecha)."',".$idempresa.")";
    $idfactura=$bd->insertar($sql);
    $sql="SELECT * FROM depositos WHERE idempresa=".$idEmpresaActiva." and idproveedor=".$idempresa;
    $deposito=$bd->sql($sql);
    if($deposito)
    {
        $iddeposito=$deposito[0]["iddeposito"];
    }else
    {
        $sql="SELECT empresa FROM empresas WHERE idempresa=".$idempresa;
        $emp=$bd->sql($sql);
        $empresa=$emp[0]["empresa"];
        $sql="INSERT INTO `depositos`(`idempresa`,`idproveedor`,`deposito`) VALUES (".$idEmpresaActiva.",".$idempresa.",'Deposito ".$empresa."')";
        $iddeposito=$bd->insertar($sql);
    }
    $datos=json_decode($_REQUEST["descripcion"]);
    foreach ($datos as $dato) {
        $sql="INSERT INTO `facturas_descripcion` (`idfactura`,`idinsumo`,`cantidad`,`precioUn`,`importeTotal`) VALUES (".$idfactura.",".$dato->idinsumo.",".$dato->cantidad.",".$dato->precioUn.",".$dato->cantidad*$dato->precioUn.")";
        $bd->insertar($sql);
        //actualizar deposito de empresa
        $sql="SELECT * FROM depositos_insumos WHERE iddeposito=".$iddeposito." and idinsumo=".$dato->idinsumo;
        $depositoInsumo=$bd->sql($sql);
        if($depositoInsumo)
        {
            $stock=$depositoInsumo[0]["stock"]+$dato->cantidad;
            $iddeposito_insumo=$depositoInsumo[0]["iddeposito_insumo"];
            $sql="UPDATE `depositos_insumos` SET `stock`=".$stock." WHERE iddeposito_insumo=".$iddeposito_insumo;
            $bd->modificar($sql);
        }
        else
        {
            $stock=$dato->cantidad;
            $sql="INSERT INTO `depositos_insumos`(`iddeposito`,`idinsumo`,`stock`) VALUES (".$iddeposito.",".$dato->idinsumo.",".$stock.")";
            $bd->insertar($sql);
        }
    }
    echo true;
}else{
    echo false;
}

?>