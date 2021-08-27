<?php
include_once($raiz."conexion/BaseDatos.php");

class laboresModel 
{
    private $bd;
    
    public function __construct()
    {
        $this->bd = new BaseDatos();
    }

    public function listarLabores($idusuario) //retorna todos los campos en un array asociativo
    {
        $sql="SELECT * FROM labores WHERE idusuario=".$idusuario." order by labor ASC";
        return $this->bd->sql($sql);
    }

    public function cantidadLabores()
    {
        return $this->bd->cantidadRegistros();
    }

    public function laborById($id)  //returno un array asociativo con el usuario pasado por id
    {
        $sql="SELECT * FROM labores WHERE idlabor = ".$id;
        return $this->bd->sql($sql);
    }

    public function insertar($labor,$precio,$idusuario)
    {
        $sql="INSERT INTO `labores`(`labor`,`precio`,`idusuario`) VALUES('".$labor."',".$precio.",".$idusuario.")";
        $id=$this->bd->insertar($sql);
        if($id==0)
            return 0;
        else
            return $id;
    }

    public function modificarLabor($labor,$idlabor,$precio)
    {
        $sql="UPDATE `labores` SET `labor`='".$labor."',`precio`=".$precio." WHERE idlabor=".$idlabor;
        return $this->bd->modificar($sql);
    }

    public function borrarLabor($idlabor)
    {
        $sql="DELETE FROM `labores` WHERE idlabor=".$idlabor;
        return $this->bd->eliminar($sql);
    }
}
?>