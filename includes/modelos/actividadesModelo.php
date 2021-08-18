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
        $sql = "SELECT idactividad, DATE_FORMAT(fecha, '%d/%m/%Y') as fecha,labor,precioha,superficie FROM actividades_lotes INNER JOIN labores on actividades_lotes.idlabor=labores.idlabor WHERE idloteCampana=".$idlotecampana." order by fecha";
        return $this->bd->sql($sql);
    }

    public function cargarInsumos($idactividad)
    {
        $sql="SELECT a.idactividad,a.idactividad_insumo,a.idinsumo,i.insumo,a.cantidadHa,a.precio,a.cantidadTotal FROM actividades_insumos a INNER JOIN insumos i on a.idinsumo=i.idinsumo WHERE idactividad=".$idactividad." ORDER BY i.insumo";
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

    public function modificarInsumosDeActividad($id,$superficie)
    {
        $sql="UPDATE `actividades_insumos` SET `cantidadTotal`=cantidadHa*".$superficie." WHERE idactividad=".$id;
        return $this->bd->modificar($sql);
    }

    public function actividadMaquinaria($id) //devuelve el valor del tipo de maquinaria, si es contratada o propia
    {
        $sql="SELECT maquinaria FROM actividades_lotes WHERE idactividad=".$id;
        return $this->bd->sql($sql);
    }

    public function guardarActividadMaquinaria($id,$tipo)
    {
        $sql="UPDATE `actividades_lotes` SET `maquinaria`=".$tipo." WHERE idactividad=".$id;
        return $this->bd->modificar($sql);
    }

    public function borrarActividadesPersonales($id) //borra todos los personales que existen para esa actividad (cero, uno o varios registros)
    {
        $sql="DELETE FROM `actividades_personales` WHERE idactividad=".$id;
        $resultado=$this->bd->eliminar($sql);
        if($resultado){
            return 1;
        }else{
            return 0;
        }
    }
    
    public function borrarActividadesTerceros($id) //borra todos los terceros que existen para esa actividad(cero, uno o varios registros) 
    {
        $sql="DELETE FROM `actividades_terceros` WHERE idactividad=".$id;
        $resultado=$this->bd->eliminar($sql);
        if($resultado){
            return 1;
        }else{
            return 0;
        }
    }

    public function guardarActividadPersonal($idactividad,$idpersonal,$precioHa)
    {
        $sql="INSERT INTO `actividades_personales`(`idactividad`, `idpersonal`, `precioHa`) VALUES (".$idactividad.",".$idpersonal.",".$precioHa.")";
        return $this->bd->insertar($sql);
    }

    public function listarPersonales($idactividad)
    {
        $sql="SELECT a.idactividad_personal,p.personal,a.precioHa FROM actividades_personales a INNER JOIN personales p ON a.idpersonal=p.idpersonal WHERE idactividad=".$idactividad;
        return $this->bd->sql($sql);
    }

    public function borrarPersonales($id) //borra todos el personal de la lista de actividades (un solo registro)
    {
        $sql="DELETE FROM `actividades_personales` WHERE idactividad_personal=".$id;
        $resultado=$this->bd->eliminar($sql);
        if($resultado){
            return 1;
        }else{
            return 0;
        }
    }

    public function modificarPersonales($id,$precioHa)
    {
        $sql="UPDATE `actividades_personales` SET `precioHa`=".$precioHa." WHERE idactividad_personal=".$id;
        return $this->bd->modificar($sql);
    }
}
?>