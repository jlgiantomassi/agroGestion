<?php
include_once($raiz."conexion/BaseDatos.php");

class ordenesModel 
{
    private $bd;
    
    public function __construct()
    {
        $this->bd = new BaseDatos();
    
    }

    public function listarOrdenes() //retorna todos los campos en un array asociativo
    {
        $sql="SELECT * FROM ordenes";
        return $this->bd->sql($sql);
    }

    public function idLaborUltimaOrden() //devuelve el id de la ultima labor realizada en la orden
    {
        $sql="SELECT idlabor from ordentrabajos where idordentrabajo = (select max(idordentrabajo) from ordentrabajos)";
        $row= $this->bd->sql($sql);
        return $row[0]["idlabor"];
    }
}   

?>