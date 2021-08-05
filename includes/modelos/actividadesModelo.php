<?php
include_once($raiz."conexion/BaseDatos.php");
include_once ('../funciones.php');


class actividadesModel 
{
    private $bd;
    public function __construct()
    {
        $this->bd = new BaseDatos();
    }

    public function insertarActividades($idlotecampana,$idlabor,$fecha,$superficie,$precioha)
    {
        //$sql=$idlotecampana+$idlabor+$fecha+$superficie+$precioha;
        //echo $sql;
        $sql="INSERT INTO `actividades_lotes`(`idloteCampana`, `idlabor`, `fecha`, `superficie`, `precioha`) VALUES ('".$idlotecampana."','".$idlabor."','".fecha_a_mysql($fecha)."','".$superficie."','".$precioha."')";
        return $this->bd->insertar($sql);
    }

    public function cargarActividades($idlotecampana)
    {
        $sql = "SELECT * FROM actividades_lotes INNER JOIN labores on actividades_lotes.idlabor=labores.idlabor WHERE idloteCampana=".$idlotecampana;
        return $this->bd->sql($sql);
    }
}
?>