<?php
include_once($raiz."conexion/BaseDatos.php");

class usuariosModel 
{
    private $bd;
    public function __construct()
    {
        $this->bd = new BaseDatos();
    }

    public function usuarioById($id)  //returno un array asociativo con el usuario pasado por id
    {
        $sql="SELECT * FROM usuarios WHERE idusuario = ".$id;
        return $this->bd->sql($sql);
    }
    public function listarUsuarios()
    {
        $sql="SELECT * FROM usuarios ORDER BY usuario ASC";
        return $this->bd->sql($sql);
    }

    public function listarProductores()
    {
        $sql="SELECT * FROM usuarios WHERE productor=1 ORDER BY usuario ASC";
        return $this->bd->sql($sql);
    }

    public function listarTerceros()
    {
        $sql="SELECT * FROM usuarios WHERE contratista=1 ORDER BY usuario ASC";
        return $this->bd->sql($sql);
    }

    public function cantidadUsuarios()
    {
        return $this->bd->cantidadRegistros();
    }

    public function insertar($usuario,$cuit,$direccion,$productor,$contratista,$proveedor)
    {
        $sql="INSERT INTO `usuarios`(`usuario`, `cuit`, `direccion`, `productor`, `contratista`, `proveedor`) VALUES ('".$usuario."','".$cuit."','".$direccion."',".$productor.",".$contratista.",".$proveedor.")";
        $id=$this->bd->insertar($sql);
        if($id==0)   
            return 0;
        else
            return  $id;
    }

    public function modificarUltimoIdEmpresa($idUsuarioActivo,$idEmpresaActiva)
    {
        $sql="UPDATE `usuarios` SET `idUltimaEmpresa`=".$idEmpresaActiva." WHERE idusuario=".$idUsuarioActivo;
        $this->bd->modificar($sql);
    }
}
?>