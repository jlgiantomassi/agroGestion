<?php
include_once($raiz."conexion/BaseDatos.php");

class personalesModel 
{
    private $bd;
    
    public function __construct()
    {
        $this->bd = new BaseDatos();
    }

    public function listarPersonales($idusuario) //retorna todos los campos en un array asociativo
    {
        $sql="SELECT * FROM personales WHERE idusuario=".$idusuario." order by personal ASC";
        return $this->bd->sql($sql);
    }

    public function cantidadPersonales()
    {
        return $this->bd->cantidadRegistros();
    }

    public function personalById($idpersonal,$idusuario)  //returno un array asociativo con el usuario pasado por id
    {
        $sql="SELECT * FROM personales WHERE idpersonal = ".$idpersonal. " and idusuario=".$idusuario;
        return $this->bd->sql($sql);
    }

    public function insertar($personal,$cuil,$precioHa,$idusuario)
    {
        $sql="INSERT INTO `personales`(`personal`,`cuil`,`precioHa`,`idusuario`) VALUES ('".$personal."','".$cuil."',".$precioHa.",".$idusuario.")";
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
}
?>