<?php
include_once($raiz."conexion/BaseDatos.php");
include_once ('../funciones.php');


class actividadesModel 
{
    private $bd;
    public function __construct()
    {
        $this->bd = new BaseDatos();
    }

    public function insertarActividades($idlotecampana,$idlabor,$fecha,$superficie,$precioha)
    {
        //$sql=$idlotecampana+$idlabor+$fecha+$superficie+$precioha;
        //echo $sql;
        $sql="INSERT INTO `actividades_lotes`(`idloteCampana`, `idlabor`, `fecha`, `superficie`, `precioha`) VALUES ('".$idlotecampana."','".$idlabor."','".fecha_a_mysql($fecha)."','".$superficie."','".$precioha."')";
        return $this->bd->insertar($sql);
    }

    public function cargarActividades($idlotecampana)
    {
        $sql = "SELECT idactividad, DATE_FORMAT(fecha, '%d/%m/%Y') as fecha,labor,precioha,superficie FROM actividades_lotes INNER JOIN labores on actividades_lotes.idlabor=labores.idlabor WHERE idloteCampana=".$idlotecampana;
        return $this->bd->sql($sql);
    }

    public function cargarInsumos($idactividad)
    {
        $sql="SELECT a.idactividad,a.idactividad_insumo,a.idinsumo,i.insumo,a.cantidadHa,a.precio,a.cantidadTotal FROM actividades_insumos a INNER JOIN insumos i on a.idinsumo=i.idinsumo WHERE idactividad=".$idactividad;
        return $this->bd->sql($sql);
    }

    public function borrarActividades($idactividad)
    {
        $sql="DELETE FROM `actividades_lotes` WHERE idactividad=".$idactividad;
        $resultado= $this->bd->eliminar($sql);
        if($resultado){
            return 1;
        }else{
            return 0;
        }
    }

    public function modificarActividades($idactividad,$fecha,$precioHa,$superficie)
    {
        $sql="UPDATE `actividades_lotes` SET `fecha`='".fecha_a_mysql($fecha)."',`superficie`=".$superficie.",`precioha`=".$precioHa." WHERE idactividad=".$idactividad;
        return $this->bd->modificar($sql);
    }

    public function insertarActividadInsumo($idactividad,$idinsumo,$precio,$cantidadha,$cantidadTotal)
    {
        $sql="INSERT INTO `actividades_insumos`(`idactividad`, `idinsumo`, `cantidadHa`, `precio`, `cantidadTotal`) VALUES ('".$idactividad."','".$idinsumo."','".$cantidadha."','".$precio."','".$cantidadTotal."')";
        return $this->bd->insertar($sql);
    }

    public function borrarActividadInsumo($id)
    {
        $sql="DELETE FROM `actividades_insumos` WHERE idactividad_insumo=".$id;
        $resultado=$this->bd->eliminar($sql);
        if($resultado){
            return 1;
        }else{
            return 0;
        }
    }

    public function modificarActividadInsumo($id,$precio,$cantidadHa,$cantidadTotal)
    {
        $sql="UPDATE `actividades_insumos` SET `cantidadHa`=".$cantidadHa.",`precio`=".$precio.",`cantidadTotal`=".$cantidadTotal." WHERE idactividad_insumo=".$id;
        return $this->bd->modificar($sql);
    }
}
?>