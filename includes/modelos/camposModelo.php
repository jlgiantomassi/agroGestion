<?php
include_once($raiz."conexion/BaseDatos.php");

class camposModel 
{
    private $bdCampos;
    private $bdLotes;
    public function __construct()
    {
        $this->bdCampos = new BaseDatos();
        $this->bdLotes = new BaseDatos();
    }

    public function listarCampos() //retorna todos los campos en un array asociativo
    {
        $sql="SELECT * FROM campos order by campo";
        return $this->bdCampos->sql($sql);
    }

    public function campoById($id)  //returno un array asociativo con el usuario pasado por id
    {
        $sql="SELECT * FROM campos WHERE idcampo = ".$id;
        return $this->bdCampos->sql($sql);
    }

    public function cantidadCampos()
    {
        return $this->bdCampos->cantidadRegistros();
    }
    
    public function insertarCampo($campo)
    {
        $sql="INSERT INTO `campos`(`campo`) VALUES('".$campo."')";
        return $this->bdCampos->insertar($sql);
    }

    //Lotes
    public function listarLotes($idcampo) //retorna todos los lotes de un campo (id) en un array asociativo
    {
        $sql="select * from lotes where idcampo=" . $idcampo . " order by lote asc";
        return $this->bdLotes->sql($sql);
    }
    
    public function cantidadLotes()
    {
        return $this->bdLotes->cantidadRegistros();
    }
    
    public function loteById($id)  //returno un array asociativo con el usuario pasado por id
    {
        $sql="SELECT * FROM lotes inner join campos on campos.idcampo=lotes.idcampo WHERE idlote = ".$id;
        return $this->bdLotes->sql($sql);
    }

    public function insertarLote($lote,$superficie,$idcampo)
    {
        $sql=("INSERT INTO `lotes`(`lote`,`superficie`,`idcampo`) VALUES('".$lote."',".$superficie.",".$idcampo.")");
        return $this->bdLotes->insertar($sql);
    }

    public function datosByIdCampana($idloteCampana)
    {
        $sql="SELECT u.usuario,c.campo,l.lote,l.superficie,ca.campana,cu.cultivo FROM lotescampanas lc INNER JOIN lotes l ON lc.idlote=l.idlote INNER JOIN campos c ON l.idcampo=c.idcampo inner JOIN usuarios u ON lc.idusuario=u.idusuario INNER JOIN campanas ca ON lc.idcampana=ca.idcampana INNER JOIN cultivos cu ON lc.idcultivo=cu.idcultivo WHERE lc.idloteCampana=".$idloteCampana;
        return $this->bdLotes->sql($sql);
    }
}
?>