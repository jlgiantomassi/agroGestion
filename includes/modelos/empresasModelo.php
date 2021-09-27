<?php
include_once($raiz . "conexion/BaseDatos.php");


class empresasModel
{
    private $bd;
    public function __construct()
    {
        $this->bd = new BaseDatos();
    }

    public function empresaById($id)  //returno un array asociativo con el usuario pasado por id
    {
        $sql = "SELECT * FROM empresas WHERE idempresa = " . $id;
        return $this->bd->sql($sql);
    }
    public function listarEmpresas($idusuario)
    {
        $sql = "SELECT * FROM empresas WHERE idusuario=" . $idusuario . " ORDER BY empresa ASC";
        return $this->bd->sql($sql);
    }


    public function listarEmpresasRubros($productor, $contratista, $proveedor, $otro, $idUsuario)
    {
        $subsql = "";
        if ($productor == 1)
            $subsql .= " and productor=1";
        if ($contratista == 1)
            $subsql .= " and contratista=1";
        if ($proveedor == 1)
            $subsql .= " and proveedor=1";
        if ($otro == 1)
            $subsql .= " and otro=1";
        $sql = "SELECT * FROM empresas WHERE idusuario=" . $idUsuario . $subsql . " ORDER BY empresa ASC";
        return $this->bd->sql($sql);
    }
    public function listarProductores($idusuario)
    {
        $sql = "SELECT * FROM empresas WHERE productor=1 and idusuario=" . $idusuario . " ORDER BY empresa ASC";
        return $this->bd->sql($sql);
    }

    public function listarTerceros($idusuario)
    {
        $sql = "SELECT * FROM empresas WHERE contratista=1 and idusuario=" . $idusuario . " ORDER BY empresa ASC";
        return $this->bd->sql($sql);
    }

    public function cantidadEmpresas()
    {
        return $this->bd->cantidadRegistros();
    }

    public function insertar($empresa, $cuit, $direccion, $productor, $contratista, $proveedor, $otro, $idusuario)
    {
        $sql = "INSERT INTO `empresas`(`empresa`, `cuit`, `direccion`, `productor`, `contratista`, `proveedor`, `otro`, `idusuario`) VALUES ('" . $empresa . "','" . $cuit . "','" . $direccion . "'," . $productor . "," . $contratista . "," . $proveedor . "," . $otro . "," . $idusuario . ")";
        $idempresa = $this->bd->insertar($sql);

        //al crear la primer empresa debemos ponerla como la ultima activa
        $sql="SELECT * FROM `usuarios` WHERE idusuario=".$idusuario;
        $this->bd->sql($sql);
        if($this->cantidadEmpresas()==1)
            {
                $sql="UPDATE `usuarios` SET idUltimaEmpresa=".$idempresa;
                $this->bd->modificar($sql);
            }
        if ($productor == true) //vamos a crear el deposito de insumo principal para la empresa
        {
            $sql = "INSERT INTO `depositos`(`deposito`,`idempresa`,`idproveedor`) VALUES('Deposito Principal'," . $idempresa . "," . $idempresa . ")";
            $this->bd->insertar($sql);
        }
        return $idempresa;
    }

    public function modificar($cuit, $direccion, $productor, $contratista, $proveedor, $otro, $idempresa)
    {
        $sql = "UPDATE `empresas` SET `cuit`='" . $cuit . "',`direccion`='" . $direccion . "',`productor`=" . $productor . ",`contratista`=" . $contratista . ",`proveedor`=" . $proveedor . ",`otro`=" . $otro . " WHERE idempresa=" . $idempresa;
        return $this->bd->modificar($sql);
    }

    public function borrarEmpresa($idempresa)
    {
        $sql = "DELETE FROM `empresas` WHERE idempresa=" . $idempresa;
        return $this->bd->eliminar($sql);
    }
}
