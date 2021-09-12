<?php
include_once($raiz . "conexion/BaseDatos.php");
include_once($raiz . "includes/modelos/actividadesModelo.php");

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
        $sql1 = "";
        if ($realizado == 1) {
            $sql1 .= " and (realizado=1";
            if ($noRealizado == 1) {
                $sql1 .= " or realizado=0";
            }
        } else {
            if ($noRealizado == 1) {
                $sql1 .= " and (realizado=0";
            }
        }
        $sql1 .= ")";
        $sql = "select DATE_FORMAT(o.fecha,'%d/%m/%Y') as fecha,l.labor,o.superficie,o.idordentrabajo,o.realizado from ordentrabajos as o inner join labores as l on o.idlabor=l.idlabor where o.idusuario=" . $idusuario . " and idcampana=" . $idcampana . " and fecha>='" . $fechaDesde . "' and fecha<='" . $fechaHasta . "'" . $sql1;
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

    public function realizarOrden($idorden)
    {
        $sql = "UPDATE ordentrabajos SET realizado=1 WHERE idordentrabajo =" . $idorden;
        $this->bd->modificar($sql);
    }

    public function agregarActividades($idordentrabajo)
    {
        $oActividad=new actividadesModel();
        /*$sql="SELECT ot.idusuario,ot.idcampana,ot.precio,ot.labor,op.idproductor as idempresa,op.superficie as supProductor,ol.idlote,ol.superficie as supLote,oi.idinsumo,oi.cantidadHa as cantidadHaInsumo,oi.precioUn as precoUnInsumo,oi.cantidadTotal as cantTotalInsumo,oi.precioTotal as precioTotalInsumo FROM ordentrabajos ot 
        INNER JOIN orden_productores op on ot.idordentrabajo=op.idordentrabajo 
        INNER JOIN orden_lotes ol ON ot.idordentrabajo=ol.idordentrabajo 
        INNER JOIN orden_insumos oi on ot.idordentrabajo=oi.idordentrabajo
        WHERE ot.idordentrabajo=".$idordentrabajo;
        */
        $sql = "SELECT ot.fecha,ot.idusuario,ot.idcampana,ot.precio,ot.idlabor,ol.idlote,ol.superficie as supLote
        FROM ordentrabajos ot 
        INNER JOIN orden_lotes ol ON ot.idordentrabajo=ol.idordentrabajo 
        WHERE ot.idordentrabajo=" . $idordentrabajo;
        $datosOrdenTrabajo = $this->bd->sql($sql);

        foreach ($datosOrdenTrabajo as $row) {
            $fecha = $row["fecha"];
            $idlote = $row["idlote"];
            $idcampana = $row["idcampana"];
            $idusuario = $row["idusuario"];
            $idlabor = $row["idlabor"];
            $precio = $row["precio"];
            $supLote = $row["supLote"];
            $sql = "SELECT * FROM lotescampanas WHERE idlote=" . $idlote . " and idcampana=" . $idcampana . " and idusuario=" . $idusuario;
            $datosLotesCampanas = $this->bd->sql($sql);

            if ($datosLotesCampanas) //hay definido un lote para la campana y el usuario. se continua con la carga de las actividades 
            {
                $idLoteCampana = $datosLotesCampanas[0]["idloteCampana"];
            } else //no hay definido una campana ni un lote para el usuario
            {
                $sql = "INSERT INTO `lotescampanas`(`idlote`,`idcampana`,`idcultivo`,`idusuario`) VALUES (" . $idlote . "," . $idcampana . ",1," . $idusuario . ") "; //idcultivo = 1 es sin asignar
                $idLoteCampana = $this->bd->insertar($sql);
            }
            $sql = "INSERT INTO `actividades_lotes`(`idloteCampana`,`idlabor`,`fecha`,`superficie`,`precioha`) VALUES (" . $idLoteCampana . "," . $idlabor . ",'" . $fecha . "'," . $supLote . "," . $precio . ")";
            $idActividad = $this->bd->insertar($sql);

            //buscar en ordentrabajo inner join orden_productores el id de cada productor y el porcentaje aportado donde idordentrabajo coincida con $idordentrabajo
            $sql = "SELECT (SELECT SUM(superficie) from orden_productores WHERE idordentrabajo=" . $idordentrabajo . ") as supTotal,idproductor,superficie FROM orden_productores WHERE idordentrabajo=" . $idordentrabajo;
            $datosProductores = $this->bd->sql($sql);
            //insertar participacion de empresas en actividades
            foreach ($datosProductores as $Productor) {
                $porcentaje = $Productor["superficie"] / $Productor["supTotal"];
                $idempresa = $Productor["idproductor"];
                $sql = "INSERT INTO `actividades_empresas` (`idactividad`,`idempresa`,`total`) VALUES (" . $idActividad . "," . $idempresa . "," . $supLote * $porcentaje*$precio . ")";
                $this->bd->insertar($sql);
            }

            //buscamos los insumos de la orden para agregarlos a la actividad
            $sql = "SELECT idinsumo,cantidadHa,precioUn FROM orden_insumos WHERE idordentrabajo=" . $idordentrabajo;
            $datosInsumos = $this->bd->sql($sql);
            //agregamos los insumos a la actividad
            foreach ($datosInsumos as $Insumo) {
                $idinsumo = $Insumo["idinsumo"];
                $cantidadHa = $Insumo["cantidadHa"];
                $precio = $Insumo["precioUn"];
                $sql = "INSERT INTO `actividades_insumos` (`idactividad`,`idinsumo`,`cantidadHa`,`precio`,`cantidadTotal`) VALUES (" . $idActividad . "," . $idinsumo . "," . $cantidadHa . "," . $precio . "," . $cantidadHa * $supLote . ")";
                $idActividadInsumo = $this->bd->insertar($sql);
                foreach ($datosProductores as $Productor) {
                    $porcentaje = $Productor["superficie"] / $Productor["supTotal"];
                    $idempresa = $Productor["idproductor"];
                    $cantidadProductorInsumo = $cantidadHa * $supLote * $porcentaje;
                    $importeProductorInsumo = $cantidadProductorInsumo * $precio;
                    $sql = "INSERT INTO `insumos_empresas` (`idactividad_insumo`,`idempresa`,`total`,`cantidad`) VALUES (" . $idActividadInsumo . "," . $idempresa . "," . $importeProductorInsumo . "," . $cantidadProductorInsumo . ")";
                    $this->bd->insertar($sql);
                    $oActividad->salidaDepositoPrimario($idempresa,$idActividadInsumo,$cantidadProductorInsumo);
                }
            }
            //buscamos los personales asignados a la orden para agregarlos a la actividad
            $sql = "SELECT idpersonal,precioHa FROM orden_personales WHERE idordentrabajo=" . $idordentrabajo;
            $datosPersonales = $this->bd->sql($sql);
            
            if ($datosPersonales) //si hay personales actualizamos la actividad del lote
            {
                $sql = "UPDATE `actividades_lotes` SET `maquinaria`=2 WHERE idactividad=" . $idActividad;
                $this->bd->modificar($sql);
                //agregamos los personales a la actividad
                foreach ($datosPersonales as $Personal) {
                    $idpersonal = $Personal["idpersonal"];
                    $precioHa = $Personal["precioHa"];

                    $sql = "INSERT INTO `actividades_personales` (`idactividad`,`idpersonal`,`precioHa`) VALUES (" . $idActividad . "," . $idpersonal . "," . $precioHa . ")";
                    $this->bd->insertar($sql);
                }
            }


            //buscamos los terceros asignados a la orden para agregarlos a la actividad
            $sql = "SELECT idtercero,precioHa FROM orden_terceros WHERE idordentrabajo=" . $idordentrabajo;
            $datosTerceros = $this->bd->sql($sql);
            if ($datosTerceros) //si hay personales actualizamos la actividad del lote
            {
                $sql = "UPDATE `actividades_lotes` SET `maquinaria`=1 WHERE idactividad=" . $idActividad;
                $this->bd->modificar($sql);
                //agregamos los terceros a la actividad
                foreach ($datosTerceros as $Tercero) {
                    $idtercero = $Tercero["idtercero"];
                    $precioHa = $Tercero["precioHa"];

                    $sql = "INSERT INTO `actividades_terceros` (`idactividad`,`idempresa`,`precioHa`) VALUES (" . $idActividad . "," . $idtercero . "," . $precioHa . ")";
                    $this->bd->insertar($sql);
                }
            }
        } //fin de foreach

    }
}
