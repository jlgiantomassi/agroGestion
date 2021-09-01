<?php
include_once($raiz."conexion/BaseDatos.php");

class insumosModel 
{
    private $bd;
    
    public function __construct()
    {
        $this->bd = new BaseDatos();
    }

    public function listarInsumos($idusario) //retorna todos los campos en un array asociativo
    {
        $sql="select i.idinsumo,i.insumo,i.precio,u.unidad from insumos i inner join unidades u on i.idunidad=u.idunidad WHERE idusuario=".$idusario." order by i.insumo asc";
        return $this->bd->sql($sql);
    }

    public function cantidadInsumos()
    {
        return $this->bd->cantidadRegistros();
    }

    public function insumoById($id,$idusario)  //returno un array asociativo con el usuario pasado por id
    {
        $sql="SELECT * FROM insumos inner join unidades on insumos.idunidad=unidades.idunidad WHERE idinsumo = ".$id." and idusuario= ".$idusario. " order by insumo";
        return $this->bd->sql($sql);
    }

    public function insertar($insumo,$precio,$idunidad,$idusuario)
    {
        $sql="INSERT INTO `insumos`(`insumo`, `precio`, `idunidad`, `idusuario`) VALUES ('".$insumo."',".$precio.",".$idunidad.",".$idusuario.")";
        $id=$this->bd->insertar($sql);
        if($id==0)   
            return 0;
        else
            return $id;
    }

    public function modificarInsumo($insumo,$idinsumo,$precio,$idunidad)
    {
        $sql="UPDATE `insumos` SET `insumo`='".$insumo."',`precio`=".$precio.", `idunidad`=".$idunidad." WHERE idinsumo=".$idinsumo; //,
        return $this->bd->modificar($sql);
    }

    public function borrarInsumo($idinsumo)
    {
        $sql="DELETE FROM `insumos` WHERE idinsumo=".$idinsumo;
        return $this->bd->eliminar($sql);
    }
}
?>