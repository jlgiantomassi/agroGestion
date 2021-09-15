<?php
include_once '../../conexion/BaseDatos.php';
include_once '../funciones.php';
include_once '../controlLogin.php';
$bd = new BaseDatos();
if (isset($_REQUEST["descripcion"])) {
    $fecha = $_REQUEST["fecha"];
    $idproveedor = $_REQUEST["idproveedor"];
    $numero = $_REQUEST["numero"];
    $sql = "INSERT INTO `remitos`(`fecha`,`idempresa`,`idproveedor`,`numero`) VALUES ('" . fecha_a_mysql($fecha) . "'," . $idEmpresaActiva . "," . $idproveedor . ",'" . $numero . "')";
    $idremito = $bd->insertar($sql);


    //ver si existe el deposito primario
    $sql = "SELECT * FROM depositos WHERE idempresa=" . $idEmpresaActiva . " and idproveedor=" . $idEmpresaActiva;
    $depositoPrimario = $bd->sql($sql);
    if ($depositoPrimario) {
        $iddepositoPrimario = $depositoPrimario[0]["iddeposito"];
    } else {
        $sql = "INSERT INTO `depositos`(`deposito`, `idempresa`, `idproveedor`) VALUES ('Deposito Primario'," . $idEmpresaActiva . "," . $idEmpresaActiva . ")";
        $iddepositoPrimario = $bd->insertar($sql);
    }

    //ver si existe el deposito de la empresa del remito
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

    $datos = json_decode($_REQUEST["descripcion"]);
    foreach ($datos as $dato) {
        $sql = "INSERT INTO `remitos_descripcion` (`idremito`,`idinsumo`,`cantidad`) VALUES (" . $idremito . "," . $dato->idinsumo . "," . $dato->cantidad . ")";
        $bd->insertar($sql);
        //actualizar deposito de empresa
        $sql = "SELECT * FROM depositos_insumos WHERE iddeposito=" . $iddeposito . " and idinsumo=" . $dato->idinsumo;
        $depositoInsumo = $bd->sql($sql);
        if ($depositoInsumo) {
            $stock = $depositoInsumo[0]["stock"] - $dato->cantidad;
            $iddeposito_insumo = $depositoInsumo[0]["iddeposito_insumo"];
            $sql = "UPDATE `depositos_insumos` SET `stock`=" . $stock . " WHERE iddeposito_insumo=" . $iddeposito_insumo;
            $bd->modificar($sql);
        } else {
            $stock = -$dato->cantidad;
            $sql = "INSERT INTO `depositos_insumos`(`iddeposito`,`idinsumo`,`stock`) VALUES (" . $iddeposito . "," . $dato->idinsumo . "," . $stock . ")";
            $bd->insertar($sql);
        }

        //actualizar deposito primario de empresa
        $sql = "SELECT * FROM depositos_insumos WHERE iddeposito=" . $iddepositoPrimario . " and idinsumo=" . $dato->idinsumo;
        $depositoInsumo = $bd->sql($sql);
        if ($depositoInsumo) {
            $stock = $depositoInsumo[0]["stock"] + $dato->cantidad;
            $iddeposito_insumo = $depositoInsumo[0]["iddeposito_insumo"];
            $sql = "UPDATE `depositos_insumos` SET `stock`=" . $stock . " WHERE iddeposito_insumo=" . $iddeposito_insumo;
            $bd->modificar($sql);
        } else {
            $stock = $dato->cantidad;
            $sql = "INSERT INTO `depositos_insumos`(`iddeposito`,`idinsumo`,`stock`) VALUES (" . $iddepositoPrimario . "," . $dato->idinsumo . "," . $stock . ")";
            $bd->insertar($sql);
        }
    }
    echo true;
} else {
    echo false;
}
