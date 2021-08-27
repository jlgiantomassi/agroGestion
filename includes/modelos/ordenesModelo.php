<?php
include_once($raiz . "conexion/BaseDatos.php");

class ordenesModel
{
    private $bd;

    public function __construct()
    {
        $this->bd = new BaseDatos();
    }

    public function listarOrdenes($idusuario) //retorna todos los campos en un array asociativo
    {
        $sql = "SELECT * FROM ordenes WHERE idusuario=" . $idusuario;
        return $this->bd->sql($sql);
    }

    public function idLaborUltimaOrden($idusuario) //devuelve el id de la ultima labor realizada en la orden
    {
        $sql = "SELECT idlabor from ordentrabajos where idordentrabajo = (select max(idordentrabajo) from ordentrabajos) and idusuario=" . $idusuario;
        $row = $this->bd->sql($sql);
        if ($this->bd->cantidadRegistros() > 0)
            return $row[0]["idlabor"];
    }

    public function cantidadRegistros()
    {
        return $this->bd->cantidadRegistros();
    }

    public function verOrden($idordentrabajo)
    {
        $sql = "select DATE_FORMAT(o.fecha,'%d/%m/%Y') as fecha,l.labor,o.precio,o.observaciones,o.superficie from ordentrabajos as o inner join labores as l on o.idlabor=l.idlabor where o.idordentrabajo=" . $idordentrabajo;
        return $this->bd->sql($sql);
    }

    public function verOrdenes($idusuario, $idcampana, $fechaDesde, $fechaHasta, $realizado, $noRealizado)
    {
        $fechaDesde = fecha_a_mysql($fechaDesde);
        $fechaHasta = fecha_a_mysql($fechaHasta);
        $sql1="";
        if ($realizado == 1) 
        {
            $sql1 .= " and (realizado=1";
            if ($noRealizado == 1) {
                $sql1 .= " or realizado=0";
            }
        }
        else
        {
            if ($noRealizado == 1) 
            {
                $sql1 .= " and (realizado=0";
            }
        }
        $sql1.=")";
        $sql = "select DATE_FORMAT(o.fecha,'%d/%m/%Y') as fecha,l.labor,o.superficie,o.idordentrabajo from ordentrabajos as o inner join labores as l on o.idlabor=l.idlabor where o.idusuario=" . $idusuario . " and idcampana=" . $idcampana . " and fecha>='" . $fechaDesde . "' and fecha<='" . $fechaHasta . "'".$sql1;
        return $this->bd->sql($sql);
    }

    public function verOrdenProductores($idordentrabajo)
    {
        $sql = "select o.superficie,p.empresa as productor from orden_productores o inner join empresas p on o.idproductor=p.idempresa where o.idordentrabajo=" . $idordentrabajo;
        return $this->bd->sql($sql);
    }

    public function verOrdenLotes($idordentrabajo)
    {
        $sql = "select o.superficie,c.campo,l.lote from orden_lotes o inner join lotes l on o.idlote=l.idlote inner join campos c on l.idcampo=c.idcampo where o.idordentrabajo=" . $idordentrabajo;
        return $this->bd->sql($sql);
    }

    public function verOrdenInsumos($idordentrabajo)
    {
        $sql = "select o.cantidadHa,o.cantidadTotal,i.insumo,u.unidad,o.precioUn,o.precioTotal from orden_insumos o inner join insumos i on o.idinsumo=i.idinsumo inner join unidades u on i.idunidad=u.idunidad where o.idordentrabajo=" . $idordentrabajo;
        return $this->bd->sql($sql);
    }

    public function borrarOrden($id)
    {
        $sql = "DELETE FROM ordentrabajos WHERE idordentrabajo=" . $id;
        $this->bd->eliminar($sql);
    }
}
