<?php
include_once($raiz."conexion/BaseDatos.php");

class unidadesModel 
{
    private $bd;
    
    public function __construct()
    {
        $this->bd = new BaseDatos();
    
    }

    public function listarUnidades() //retorna todos los campos en un array asociativo
    {
        $sql="select * from unidades ORDER BY unidad asc";
        return $this->bd->sql($sql);
    }

    public function cantidadUnidades()
    {
        return $this->bd->cantidadRegistros();
    }

    public function unidadById($id)  //returno un array asociativo con el usuario pasado por id
    {
        $sql="SELECT * FROM unidades WHERE idunidad = ".$id;
        return $this->bd->sql($sql);

    }

}
?>