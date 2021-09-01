<?php
include_once($raiz."conexion/BaseDatos.php");

class cultivosModel 
{
    private $bd;
    public function __construct()
    {
        $this->bd = new BaseDatos();
    }

    public function cultivoById($id)  //returno un array asociativo con el usuario pasado por id
    {
        $sql="SELECT * FROM cultivos WHERE idcultivo = ".$id;
        return $this->bd->sql($sql);

    }
    public function listarCultivos()
    {
        $sql="SELECT * FROM cultivos ORDER BY cultivo ASC";
        return $this->bd->sql($sql);
    }
    
    public function cultivoPorCampana($idlote,$idusuario,$idcampana)
    {
        $sql="SELECT * FROM lotescampanas WHERE idlote=".$idlote." and idusuario=".$idusuario." and idcampana=".$idcampana;
        return $this->bd->sql($sql);
    }

    public function insertarCultivoEnCampana($idlote,$idusuario,$idcampana,$idcultivo)
    {
        $sql="INSERT INTO lotescampanas (idlote,idusuario,idcampana,idcultivo) VALUES (".$idlote.",".$idusuario.",".$idcampana.",".$idcultivo.")";
        return $this->bd->insertar($sql);
    }

    public function modificarCultivoEnCampana($idlote,$idusuario,$idcampana,$idcultivo)
    {
        $sql="UPDATE lotescampanas SET idcultivo=".$idcultivo." WHERE idlote= ".$idlote." and idusuario= ".$idusuario."  and idcampana=".$idcampana;
        return $this->bd->sql($sql);
    }

    public function capitalizacion($id,$estado)
    {
        $sql="UPDATE lotescampanas SET capitalizacion=".$estado." WHERE idlotecampana=".$id;
        return $this->bd->modificar($sql);
    }
}   
?>