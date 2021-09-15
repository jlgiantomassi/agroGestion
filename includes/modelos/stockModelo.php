<?php
include_once($raiz."conexion/BaseDatos.php");


class stockModel 
{
    private $bd;
    public function __construct()
    {
        $this->bd = new BaseDatos();
    }

    public function depositos($idempresa)  //returno un array asociativo con el usuario pasado por id
    {
        $sql="SELECT * FROM depositos WHERE idempresa = ".$idempresa;
        return $this->bd->sql($sql);
    }

    public function depositoPorProveedor($idempresa,$idproveedor)
    {
        $sql="SELECT * FROM depositos WHERE idempresa = ".$idempresa." and idproveedor=".$idproveedor;
        return $this->bd->sql($sql);
    }

    public function insumoPorDeposito($iddeposito)
    {
        $sql="SELECT i.insumo,di.stock FROM depositos_insumos di INNER JOIN insumos i ON di.idinsumo=i.idinsumo WHERE iddeposito = ".$iddeposito." and di.stock<>0";
        return $this->bd->sql($sql);
    }
}
