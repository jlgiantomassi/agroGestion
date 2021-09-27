<?php
include_once '../../conexion/BaseDatos.php';
include_once '../funciones.php';
include_once '../controlLogin.php';
$bd = new BaseDatos();
if (isset($_REQUEST["descripcion"])) {
    $fecha = $_REQUEST["fecha"];
    $vencimiento = $_REQUEST["vencimiento"];
    $idproveedor = $_REQUEST["idproveedor"];
    $numero = $_REQUEST["numero"];
    $importe=$_REQUEST["importe"];
    $iva=$_REQUEST["iva"];
    $importeTotal=$importe+$iva;
    $sql = "INSERT INTO `facturas`(`fecha`,`vencimiento`,`idempresa`,`idproveedor`,`numero`,`importe`,`iva`,`importeTotal`) VALUES ('" . fecha_a_mysql($fecha) . "','" . fecha_a_mysql($vencimiento) . "'," . $idEmpresaActiva . "," . $idproveedor . ",'" . $numero . "'," . $importe . "," . $iva . "," . $importeTotal . ")";
    $idfactura = $bd->insertar($sql);

    $datos = json_decode($_REQUEST["descripcion"]);
    foreach ($datos as $dato) {
        if ($dato->idinsumo == 0) { //si la descripcion no es de un insumo
            $importe = $dato->cantidad * $dato->precioUn;
            $importeTotal = $importe + $dato->iva;
            $sql = "INSERT INTO `facturas_detalles` (`idfactura`,`detalle`,`cantidad`,`precioUn`,`iva`,`importe`,`importeTotal`) VALUES (" . $idfactura . ",'" . $dato->detalle . "'," . $dato->cantidad . "," . $dato->precioUn . "," . $dato->iva . "," . $importe . "," . $importeTotal . ")";
            //echo $sql;
            $bd->insertar($sql);
        } else { //si la descripcion es de un insumo
            $sql = "SELECT * FROM depositos WHERE idempresa=" . $idEmpresaActiva . " and idproveedor=" . $idproveedor;
            $deposito = $bd->sql($sql);
            if ($deposito) {
                $iddeposito = $deposito[0]["iddeposito"];
            } else {
                $sql = "SELECT empresa FROM empresas WHERE idempresa=" . $idproveedor;
                $emp = $bd->sql($sql);
                $proveedor = $emp[0]["empresa"];
                $sql = "INSERT INTO `depositos`(`idempresa`,`idproveedor`,`deposito`) VALUES (" . $idEmpresaActiva . "," . $idproveedor . ",'Deposito " . $proveedor . "')";
                $iddeposito = $bd->insertar($sql);
            }

            $importe = $dato->cantidad * $dato->precioUn;
            $importeTotal = $importe + $dato->iva;
            $sql = "INSERT INTO `facturas_descripcion` (`idfactura`,`idinsumo`,`cantidad`,`precioUn`,`iva`,`importe`,`importeTotal`) VALUES (" . $idfactura . "," . $dato->idinsumo . "," . $dato->cantidad . "," . $dato->precioUn . "," . $dato->iva . "," . $importe . "," . $importeTotal . ")";
            $bd->insertar($sql);
            //actualizamos el precio de los insumos
            $sql="UPDATE `insumos` SET `precio`=".$dato->precioUn." WHERE idinsumo=".$dato->idinsumo;
            $bd->modificar($sql);
            //actualizar deposito de empresa
            $sql = "SELECT * FROM depositos_insumos WHERE iddeposito=" . $iddeposito . " and idinsumo=" . $dato->idinsumo;
            $depositoInsumo = $bd->sql($sql);
            if ($depositoInsumo) {
                $stock = $depositoInsumo[0]["stock"] + $dato->cantidad;
                $iddeposito_insumo = $depositoInsumo[0]["iddeposito_insumo"];
                $sql = "UPDATE `depositos_insumos` SET `stock`=" . $stock . " WHERE iddeposito_insumo=" . $iddeposito_insumo;
                $bd->modificar($sql);
            } else {
                $stock = $dato->cantidad;
                $sql = "INSERT INTO `depositos_insumos`(`iddeposito`,`idinsumo`,`stock`) VALUES (" . $iddeposito . "," . $dato->idinsumo . "," . $stock . ")";
                $bd->insertar($sql);
            }
        }
    }
    echo true;
} else {
    echo false;
}
