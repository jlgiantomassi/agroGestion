<?php
include_once($raiz."conexion/BaseDatos.php");

class empresasModel 
{
    private $bd;
    public function __construct()
    {
        $this->bd = new BaseDatos();
    }

    public function empresaById($id)  //returno un array asociativo con el usuario pasado por id
    {
        $sql="SELECT * FROM empresas WHERE idempresa = ".$id;
        return $this->bd->sql($sql);
    }
    public function listarEmpresas($idusuario)
    {
        $sql="SELECT * FROM empresas WHERE idusuario=".$idusuario." ORDER BY empresa ASC";
        return $this->bd->sql($sql);
    }

    public function listarProductores($idusuario)
    {
        $sql="SELECT * FROM empresas WHERE productor=1 and idusuario=".$idusuario." ORDER BY empresa ASC";
        return $this->bd->sql($sql);
    }

    public function listarTerceros($idusuario)
    {
        $sql="SELECT * FROM empresas WHERE contratista=1 and idusuario=".$idusuario." ORDER BY empresa ASC";
        return $this->bd->sql($sql);
    }

    public function cantidadEmpresas()
    {
        return $this->bd->cantidadRegistros();
    }
                    
    public function insertar($empresa,$cuit,$direccion,$productor,$contratista,$proveedor,$otro,$idusuario)
    {
        $sql="INSERT INTO `empresas`(`empresa`, `cuit`, `direccion`, `productor`, `contratista`, `proveedor`, `otro`, `idusuario`) VALUES ('".$empresa."','".$cuit."','".$direccion."',".$productor.",".$contratista.",".$proveedor.",".$otro.",".$idusuario.")";
        return $this->bd->insertar($sql);
    }

    public function modificar($cuit, $direccion, $productor, $contratista, $proveedor, $otro, $idempresa){
        $sql="UPDATE `empresas` SET `cuit`='".$cuit."',`direccion`='".$direccion."',`productor`=".$productor.",`contratista`=".$contratista.",`proveedor`=".$proveedor.",`otro`=".$otro." WHERE idempresa=".$idempresa;
        return $this->bd->modificar($sql);
    }

    public function borrarEmpresa($idempresa)
    {
        $sql="DELETE FROM `empresas` WHERE idempresa=".$idempresa;
        return $this->bd->eliminar($sql);
    }
}
?>