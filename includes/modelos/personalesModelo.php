<?php
include_once($raiz."conexion/BaseDatos.php");
include_once($raiz . "includes/funciones.php");

class personalesModel 
{
    private $bd;
    
    public function __construct()
    {
        $this->bd = new BaseDatos();
    }

    public function listarPersonales($idempresa) //retorna todos los campos en un array asociativo
    {
        $sql="SELECT * FROM personales WHERE idempresa=".$idempresa." order by personal ASC";
        return $this->bd->sql($sql);
    }

    public function cantidadPersonales()
    {
        return $this->bd->cantidadRegistros();
    }

    public function personalById($idpersonal,$idempresa)  //returno un array asociativo con el usuario pasado por id
    {
        $sql="SELECT * FROM personales WHERE idpersonal = ".$idpersonal. " and idempresa=".$idempresa;
        return $this->bd->sql($sql);
    }

    public function insertar($personal,$cuil,$precioHa,$idempresa)
    {
        $sql="INSERT INTO `personales`(`personal`,`cuil`,`precioHa`,`idempresa`) VALUES ('".$personal."','".$cuil."',".$precioHa.",".$idempresa.")";
        return $this->bd->insertar($sql);
    }

    public function modificarPersonal($personal,$idpersonal,$precioHa,$cuil)
    {
        $sql="UPDATE `personales` SET `personal`='".$personal."',`cuil`='".$cuil."',`precioHa`=".$precioHa." WHERE idpersonal=".$idpersonal;
        return $this->bd->modificar($sql);
    }

    public function borrarPersonal($idpersonal)
    {
        $sql="DELETE FROM `personales` WHERE idpersonal=".$idpersonal;
        return $this->bd->eliminar($sql);
    }

    public function actividadesPersonales($fechaDesde,$fechaHasta,$idpersonal)
    {
        $fechaDesde = fecha_a_mysql($fechaDesde);
        $fechaHasta = fecha_a_mysql($fechaHasta);
        $subsql = " and fecha>='" . $fechaDesde . "' and fecha <='" . $fechaHasta . "'";
        $sql="SELECT DATE_FORMAT(fecha, '%d/%m/%Y') as fecha ,CONCAT(l.labor,' - ',c.campo,' - ',lo.lote) as descripcion,al.superficie, al.superficie*ap.precioHa as importe 
        FROM actividades_lotes al 
        INNER JOIN lotescampanas lc ON al.idloteCampana=lc.idloteCampana
        INNER JOIN lotes lo ON lc.idlote=lo.idlote
        INNER JOIN campos c ON lo.idcampo=c.idcampo INNER JOIN labores l ON al.idlabor=l.idlabor INNER JOIN actividades_personales ap ON al.idactividad=ap.idactividad WHERE ap.idpersonal=".$idpersonal.$subsql. "ORDER BY fecha";
        return $this->bd->sql($sql);
    }
}
?>