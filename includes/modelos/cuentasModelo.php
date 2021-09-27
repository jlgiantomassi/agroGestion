<?php
include_once($raiz."conexion/BaseDatos.php");

class cuentasModel 
{
    private $bd;
    public function __construct()
    {
        $this->bd = new BaseDatos();
    }

    public function cuentaById($idcuenta)
    {
        $sql="SELECT * FROM cuentas where idcuenta=".$idcuenta;
        return $this->bd->sql($sql);
    }

    public function listarCuentas($idempresa) //retorna todos los campos en un array asociativo
    {
        $sql="SELECT * FROM cuentas c INNER JOIN tipocuentas t ON c.idtipo=t.idtipocuenta where idempresa=".$idempresa." order by tipo,cuenta";
        return $this->bd->sql($sql);
    }

    public function tipoCuentas($idempresa)
    {
        $sql="SELECT * FROM tipocuentas WHERE idempresa=".$idempresa." order by tipo";
        return $this->bd->sql($sql);
    }

    public function listarCuentasPorTipo($idtipo,$idempresa)
    {
        $sql="SELECT * FROM cuentas WHERE idtipo=".$idtipo." and idempresaActiva=".$idempresa." order by cuenta";
        return $this->bd->sql($sql);
    }

    public function monedas($idempresa)
    {
        $sql="SELECT * FROM monedas WHERE idempresa=".$idempresa." order by moneda";
        return $this->bd->sql($sql);
    }
    public function cantidad()
    {
        return $this->bd->cantidadRegistros();
    }

    public function agregarTipoCuenta($tipo,$idempresa)
    {
        $sql="INSERT INTO `tipocuentas`(`tipo`, `idempresa`) VALUES ('".$tipo."',".$idempresa.")";
        return $this->bd->insertar($sql);
    }

    public function agregarMoneda($moneda,$idempresa)
    {
        $sql="INSERT INTO `monedas`(`moneda`, `idempresa`) VALUES ('".$moneda."',".$idempresa.")";
        return $this->bd->insertar($sql);
    }
    public function agragarCuenta($cuenta,$numero,$idtipo,$idmoneda,$idempresa)
    {
        $sql="INSERT INTO `cuentas`(`cuenta`, `idempresaActiva`, `idmoneda`, `numero`, `idtipo`) VALUES ('".$cuenta."',".$idempresa.",".$idmoneda.",".$numero.",".$idtipo.")";
        return $this->bd->insertar($sql);
    }

    public function movimientos($idcuenta)
    {
        $sql="SELECT b.beneficiario,fecha,DATE_FORMAT(fecha, '%d/%m/%Y') as fechaB,numero,debito,credito,detalle,estado FROM `movimientos` m 
        INNER JOIN beneficiarios b ON m.idbeneficiario=b.idbeneficiario
        WHERE m.idcuenta=".$idcuenta.
        " UNION
        SELECT e.empresa as beneficiario,fecha,DATE_FORMAT(fecha, '%d/%m/%Y') as fechaB,t.numero,t.importe as debito,0 as credito,detalle,estado FROM `transferencias` t 
        INNER JOIN cuentas c ON t.idcuentadestino=c.idcuenta
        INNER JOIN empresas e ON c.idempresa=e.idempresa
        WHERE t.idcuenta=".$idcuenta.
        " UNION
        SELECT e.empresa as beneficiario,fecha,DATE_FORMAT(fecha, '%d/%m/%Y') as fechaB,t.numero,0 as debito,t.importe as credito,detalle,estado FROM `transferencias` t 
        INNER JOIN cuentas c ON t.idcuenta=c.idcuenta
        INNER JOIN empresas e ON c.idempresa=e.idempresa
        WHERE t.idcuentadestino=".$idcuenta.
        " order by fecha";
        return $this->bd->sql($sql);
    }
}