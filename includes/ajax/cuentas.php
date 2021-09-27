<?php
$raiz = "../../";
include_once($raiz . "includes/controlLogin.php");
include_once($raiz . "conexion/BaseDatos.php");
include_once $raiz . 'includes/modelos/cuentasModelo.php';

$accion = $_GET['accion'];
switch ($accion) {
    case "agregarTipoCuenta":
        $tipo=$_GET["tipo"];
        $oCuentas = new cuentasModel();
        echo $oCuentas->agregarTipoCuenta($tipo,$idEmpresaActiva);
    break;
    case "agregarMoneda":
        $moneda=$_GET["moneda"];
        $oCuentas = new cuentasModel();
        echo $oCuentas->agregarMoneda($moneda,$idEmpresaActiva);
    break;
}
