<?php
include_once($raiz . "conexion/BaseDatos.php");
include_once($raiz . "includes/funciones.php");
include_once($raiz . "includes/controlLogin.php");

class facturasModel
{
    private $bd;
    public function __construct()
    {
        $this->bd = new BaseDatos();
    }

    public function listarFacturas($fechaDesde, $fechaHasta, $idproveedor, $idempresa)  //returno un array asociativo con el usuario pasado por id
    {
        $fechaDesde = fecha_a_mysql($fechaDesde);
        $fechaHasta = fecha_a_mysql($fechaHasta);
        $subsql = " and fecha>='" . $fechaDesde . "' and fecha <='" . $fechaHasta . "'";
        if ($idproveedor > 0)
            $subsql .= " and f.idproveedor=" . $idproveedor;

        $sql = "SELECT f.idfactura,numero,importe,iva,importeTotal as total,DATE_FORMAT(f.fecha,'%d/%m/%Y') as fecha,DATE_FORMAT(f.vencimiento,'%d/%m/%Y') as vencimiento,e.empresa  FROM facturas f INNER JOIN empresas e ON f.idproveedor=e.idempresa WHERE f.idempresa=" . $idempresa . $subsql. " ORDER BY f.fecha ASC";
        /*$sql="SELECT f.idfactura,SUM(ifnull(fd.importeTotal,0)) + SUM(ifnull(fdet.importeTotal,0)) as total,DATE_FORMAT(f.fecha,'%d/%m/%Y') as fecha,DATE_FORMAT(f.vencimiento,'%d/%m/%Y') as vencimiento,e.empresa  
        FROM facturas f 
        LEFT JOIN facturas_descripcion fd ON f.idfactura=fd.idfactura 
        LEFT JOIN facturas_detalles fdet ON f.idfactura=fdet.idfactura 
        INNER JOIN empresas e ON f.idproveedor=e.idempresa 
        WHERE f.idempresa=" . $idempresa . $subsql . " GROUP by f.idfactura";
        */
        return $this->bd->sql($sql);
    }

    public function saldoProveedor($fecha,$idproveedor,$idempresa)
    {
        $sql="SELECT SUM(importeTotal) as saldo FROM facturas f WHERE fecha<'".fecha_a_mysql($fecha)."' and idproveedor=".$idproveedor." and idempresa=".$idempresa;
        return $this->bd->sql($sql);
    }

    public function verFactura($idfactura)
    {
        $sql = "SELECT DATE_FORMAT(f.fecha,'%d/%m/%Y') as fecha,DATE_FORMAT(f.vencimiento,'%d/%m/%Y') as vencimiento,f.numero FROM facturas f WHERE f.idfactura=" . $idfactura;
        return $this->bd->sql($sql);
    }
    public function verDescripcionFactura($idfactura)
    {
        $sql = "SELECT e.empresa,i.insumo,fd.precioUn,fd.cantidad,fd.importe,fd.iva,fd.importeTotal FROM facturas f 
        INNER JOIN facturas_descripcion fd ON f.idfactura=fd.idfactura 
        INNER JOIN empresas e ON f.idproveedor=e.idempresa 
        INNER JOIN insumos i ON fd.idinsumo=i.idinsumo
        WHERE f.idfactura=" . $idfactura;
        return $this->bd->sql($sql);
    }

    public function verDetallesFactura($idfactura)
    {
        $sql = "SELECT e.empresa,fd.detalle as insumo,fd.precioUn,fd.cantidad,fd.importe,fd.iva,fd.importeTotal FROM facturas f 
        INNER JOIN facturas_detalles fd ON f.idfactura=fd.idfactura 
        INNER JOIN empresas e ON f.idproveedor=e.idempresa 
        WHERE f.idfactura=" . $idfactura;
        return $this->bd->sql($sql);
    }

    public function eliminar($idfactura)
    {
        $sql="SELECT idempresa,idproveedor FROM facturas WHERE idfactura=".$idfactura;
        $datos=$this->bd->sql($sql);
        $idempresa=$datos[0]["idempresa"];
        $idproveedor=$datos[0]["idproveedor"];
        $sql = "SELECT * FROM depositos WHERE idempresa=" . $idempresa . " and idproveedor=" . $idproveedor;
        $deposito = $this->bd->sql($sql);
        $iddeposito=$deposito[0]["iddeposito"];

        $sql="SELECT * FROM facturas_descripcion WHERE idfactura=".$idfactura;
        $facturasDesc=$this->bd->sql($sql);
        foreach ($facturasDesc as $row) {
            $sql = "SELECT * FROM depositos_insumos WHERE iddeposito=" . $iddeposito . " and idinsumo=" . $row["idinsumo"];
            $deposito_insumo = $this->bd->sql($sql);
            $stock=$deposito_insumo[0]["stock"];
            $iddeposito_insumo=$deposito_insumo[0]["iddeposito_insumo"];
            $stock-=$row["cantidad"];
            $sql = "UPDATE `depositos_insumos` SET `stock`=" . $stock . " WHERE iddeposito_insumo=" . $iddeposito_insumo;
            $this->bd->modificar($sql);
        }
        
        $sql = "DELETE FROM facturas WHERE idfactura=" . $idfactura;
        return $this->bd->eliminar($sql);
    }
}
