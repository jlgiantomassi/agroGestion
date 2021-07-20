<?php
include_once($raiz."conexion/BaseDatos.php");

class insumosModel 
{
    private $bd;
    
    public function __construct()
    {
        $this->bd = new BaseDatos();
    }

    public function listarInsumos() //retorna todos los campos en un array asociativo
    {
        $sql="select * from insumos inner join unidades on insumos.idunidad=unidades.idunidad order by insumo asc";
        return $this->bd->sql($sql);
    }

    public function cantidadInsumos()
    {
        return $this->bd->cantidadRegistros();
    }

    public function insumoById($id)  //returno un array asociativo con el usuario pasado por id
    {
        $sql="SELECT * FROM insumos inner join unidades on insumos.idunidad=unidades.idunidad WHERE idinsumo = ".$id." order by insumo";
        return $this->bd->sql($sql);
    }

    public function insertar($insumo,$precio,$idunidad)
    {
        $sql="INSERT INTO `insumos`(`insumo`, `precio`, `idunidad`) VALUES ('".$insumo."',".$precio.",".$idunidad.")";
        $id=$this->bd->insertar($sql);
        if($id==0)   
            return 0;
        else
            return  $id;
    }

}
?>