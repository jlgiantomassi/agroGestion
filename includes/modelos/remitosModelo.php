<?php
include_once($raiz . "conexion/BaseDatos.php");
include_once($raiz . "includes/funciones.php");



class remitosModel
{
    private $bd;
    public function __construct()
    {
        $this->bd = new BaseDatos();
    }

    public function listarRemitos($fechaDesde, $fechaHasta, $idproveedor, $idempresa)  //returno un array asociativo con el usuario pasado por id
    {
        $fechaDesde = fecha_a_mysql($fechaDesde);
        $fechaHasta = fecha_a_mysql($fechaHasta);
        $subsql = " and fecha>='" . $fechaDesde . "' and fecha <='" . $fechaHasta . "'";
        if ($idproveedor > 0)
            $subsql .= " and r.idproveedor=" . $idproveedor;

        $sql = "SELECT r.idremito,SUM(rd.cantidad) as total,DATE_FORMAT(r.fecha,'%d/%m/%Y') as fecha,e.empresa  FROM remitos r INNER JOIN remitos_descripcion rd ON r.idremito=rd.idremito INNER JOIN empresas e ON r.idproveedor=e.idempresa WHERE r.idempresa=" . $idempresa . $subsql . " GROUP by r.idremito";
        return $this->bd->sql($sql);
    }

    public function verRemito($idremito)
    {
        $sql = "SELECT DATE_FORMAT(r.fecha,'%d/%m/%Y') as fecha,e.empresa,i.insumo,rd.cantidad,r.numero FROM remitos r 
        INNER JOIN remitos_descripcion rd ON r.idremito=rd.idremito 
        INNER JOIN empresas e ON r.idproveedor=e.idempresa 
        INNER JOIN insumos i ON rd.idinsumo=i.idinsumo
        WHERE r.idremito=" . $idremito;
        return $this->bd->sql($sql);
    }

    public function eliminar($idremito,$idEmpresaActiva)
    {
        $sql="SELECT idempresa,idproveedor FROM remitos WHERE idremito=".$idremito;
        $datos=$this->bd->sql($sql);
        $idempresa=$datos[0]["idempresa"];
        $idproveedor=$datos[0]["idproveedor"];
        $sql = "SELECT * FROM depositos WHERE idempresa=" . $idempresa . " and idproveedor=" . $idproveedor;
        $deposito = $this->bd->sql($sql);
        $iddeposito=$deposito[0]["iddeposito"];

        $sql = "SELECT * FROM depositos WHERE idempresa=" . $idEmpresaActiva . " and idproveedor=" . $idEmpresaActiva;
        $deposito = $this->bd->sql($sql);
        $iddepositoPrincipal=$deposito[0]["iddeposito"];

        $sql="SELECT * FROM remitos_descripcion WHERE idremito=".$idremito;
        $remitosDesc=$this->bd->sql($sql);
        foreach ($remitosDesc as $row) {
            $sql = "SELECT * FROM depositos_insumos WHERE iddeposito=" . $iddeposito . " and idinsumo=" . $row["idinsumo"];
            $deposito_insumo = $this->bd->sql($sql);
            $stock=$deposito_insumo[0]["stock"];
            $iddeposito_insumo=$deposito_insumo[0]["iddeposito_insumo"];
            $stock+=$row["cantidad"];
            $sql = "UPDATE `depositos_insumos` SET `stock`=" . $stock . " WHERE iddeposito_insumo=" . $iddeposito_insumo;
            $this->bd->modificar($sql);

            $sql = "SELECT * FROM depositos_insumos WHERE iddeposito=" . $iddepositoPrincipal . " and idinsumo=" . $row["idinsumo"];
            $deposito_insumo = $this->bd->sql($sql);
            $stock=$deposito_insumo[0]["stock"];
            $iddeposito_insumo=$deposito_insumo[0]["iddeposito_insumo"];
            $stock-=$row["cantidad"];
            $sql="UPDATE `depositos_insumos` SET `stock`=" . $stock . " WHERE iddeposito_insumo=" . $iddeposito_insumo;
            $this->bd->modificar($sql);
        }
        
        $sql = "DELETE FROM remitos WHERE idremito=" . $idremito;
        return $this->bd->eliminar($sql);
    }
}
