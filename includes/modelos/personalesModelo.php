<?php
include_once($raiz."conexion/BaseDatos.php");

class personalesModel 
{
    private $bd;
    
    public function __construct()
    {
        $this->bd = new BaseDatos();
    }

    public function listarPersonales() //retorna todos los campos en un array asociativo
    {
        $sql="SELECT * FROM personales order by personal ASC";
        return $this->bd->sql($sql);
    }

    public function cantidadPersonales()
    {
        return $this->bd->cantidadRegistros();
    }

    public function personalById($id)  //returno un array asociativo con el usuario pasado por id
    {
        $sql="SELECT * FROM personales WHERE idpersonal = ".$id;
        return $this->bd->sql($sql);
    }

    public function insertar($personal,$cuil,$precioHa)
    {
        $sql="INSERT INTO `personales`(`personal`,`cuil`,`precioHa`) VALUES ('".$personal."','".$cuil."',".$precioHa.")";
        return $this->bd->insertar($sql);
    }

}
?>