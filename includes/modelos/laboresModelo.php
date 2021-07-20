<?php
include_once($raiz."conexion/BaseDatos.php");

class laboresModel 
{
    private $bd;
    
    public function __construct()
    {
        $this->bd = new BaseDatos();
    }

    public function listarLabores() //retorna todos los campos en un array asociativo
    {
        $sql="SELECT * FROM labores order by labor ASC";
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

    public function insertar($labor,$precio)
    {
        $sql="INSERT INTO `labores`(`labor`,`precio`) VALUES('".$labor."',".$precio.")";
        $id=$this->bd->insertar($sql);
        if($id==0)
            return 0;
        else
            return $id;
    }

}
?>