<?php
include_once($raiz."conexion/BaseDatos.php");
include_once ($raiz."includes/funciones.php");


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
        $sql="INSERT INTO `actividades_lotes`(`idloteCampana`, `idlabor`, `fecha`, `superficie`, `precioha`,`observaciones`) VALUES ('".$idlotecampana."','".$idlabor."','".fecha_a_mysql($fecha)."','".$superficie."','".$precioha."','')";
        return $this->bd->insertar($sql);
    }

    public function cargarActividades($idlotecampana)
    {
        $sql = "SELECT idactividad, DATE_FORMAT(fecha, '%d/%m/%Y') as fechaDMY,labor,precioha,superficie,observaciones FROM actividades_lotes INNER JOIN labores on actividades_lotes.idlabor=labores.idlabor WHERE idloteCampana=".$idlotecampana." order by fecha ASC";
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

    public function guardarActividadTercero($idactividad,$idtercero,$precioHa)
    {
        $sql="INSERT INTO `actividades_terceros`(`idactividad`, `idempresa`, `precioHa`) VALUES (".$idactividad.",".$idtercero.",".$precioHa.")";
        return $this->bd->insertar($sql);
    }

    public function listarPersonales($idactividad)
    {
        $sql="SELECT a.idactividad_personal,p.personal,a.precioHa FROM actividades_personales a INNER JOIN personales p ON a.idpersonal=p.idpersonal WHERE idactividad=".$idactividad;
        return $this->bd->sql($sql);
    }

    public function listarTerceros($idactividad)
    {
        $sql="SELECT a.idactividad_tercero,e.empresa as tercero,a.precioHa FROM actividades_terceros a INNER JOIN empresas e ON a.idempresa=e.idempresa WHERE idactividad=".$idactividad;
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

    public function borrarTerceros($id) //borra todos el personal de la lista de actividades (un solo registro)
    {
        $sql="DELETE FROM `actividades_terceros` WHERE idactividad_tercero=".$id;
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

    public function modificarTerceros($id,$precioHa)
    {
        $sql="UPDATE `actividades_terceros` SET `precioHa`=".$precioHa." WHERE idactividad_tercero=".$id;
        return $this->bd->modificar($sql);
    }

    public function guardarObservaciones($id,$observaciones)
    {
        $sql="UPDATE `actividades_lotes` SET `observaciones`='".$observaciones."' WHERE idactividad=".$id;
        return $this->bd->modificar($sql);
    }

    public function importeInsumos($id)
    {
        $sql="SELECT SUM(i.cantidadTotal*i.precio) as importe FROM `lotescampanas` l INNER JOIN actividades_lotes a ON l.idloteCampana=a.idloteCampana INNER JOIN actividades_insumos i on a.idactividad=i.idactividad WHERE l.idloteCampana=".$id;
        return $this->bd->sql($sql);
    }

    public function importeInsumosPorLote($idloteCampana)
    {
        //devuelve cantidad, insumo, importe de cada insumo por lote
        $sql="SELECT SUM(ai.cantidadTotal) as cantidad,i.insumo,SUM(ai.cantidadTotal*ai.precio) as importe FROM `actividades_lotes` al INNER JOIN `actividades_insumos` ai ON al.idactividad=ai.idactividad INNER JOIN insumos i ON ai.idinsumo=i.idinsumo WHERE al.idloteCampana=".$idloteCampana." GROUP BY i.idinsumo";
        return $this->bd->sql($sql);
    }

    public function guardarProductorActividad($idactividad,$idempresa,$total)
    {
        $sql="INSERT INTO `actividades_empresas`(`idactividad`, `idempresa`, `total`) VALUES (".$idactividad.",".$idempresa.",".$total.")";
        return $this->bd->insertar($sql);
    }

    public function ProductorActividad($idactividad)
    {
        $sql="SELECT * FROM actividades_empresas ae INNER JOIN empresas e ON ae.idempresa=e.idempresa WHERE idactividad=".$idactividad;
        return $this->bd->sql($sql);
    }
}
?>