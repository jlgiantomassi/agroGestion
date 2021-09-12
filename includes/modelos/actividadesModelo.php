<?php
include_once($raiz . "conexion/BaseDatos.php");
include_once($raiz . "includes/funciones.php");


class actividadesModel
{
    private $bd;
    public function __construct()
    {
        $this->bd = new BaseDatos();
    }

    public function insertarActividades($idlotecampana, $idlabor, $fecha, $superficie, $precioha)
    {
        //$sql=$idlotecampana+$idlabor+$fecha+$superficie+$precioha;
        //echo $sql;
        $sql = "INSERT INTO `actividades_lotes`(`idloteCampana`, `idlabor`, `fecha`, `superficie`, `precioha`,`observaciones`) VALUES ('" . $idlotecampana . "','" . $idlabor . "','" . fecha_a_mysql($fecha) . "','" . $superficie . "','" . $precioha . "','')";
        return $this->bd->insertar($sql);
    }

    public function cargarActividades($idlotecampana)
    {
        $sql = "SELECT idactividad, DATE_FORMAT(fecha, '%d/%m/%Y') as fechaDMY,labor,precioha,superficie,observaciones FROM actividades_lotes INNER JOIN labores on actividades_lotes.idlabor=labores.idlabor WHERE idloteCampana=" . $idlotecampana . " order by fecha ASC";
        return $this->bd->sql($sql);
    }

    public function cargarInsumos($idactividad)
    {
        $sql = "SELECT a.idactividad,a.idactividad_insumo,a.idinsumo,i.insumo,a.cantidadHa,a.precio,a.cantidadTotal FROM actividades_insumos a INNER JOIN insumos i on a.idinsumo=i.idinsumo WHERE idactividad=" . $idactividad . " ORDER BY i.insumo";
        return $this->bd->sql($sql);
    }

    public function borrarActividades($idactividad)
    {
        $sql = "DELETE FROM `actividades_lotes` WHERE idactividad=" . $idactividad;
        $resultado = $this->bd->eliminar($sql);
        if ($resultado) {
            return 1;
        } else {
            return 0;
        }
    }

    public function modificarActividades($idactividad, $fecha, $precioHa, $superficie)
    {
        $sql = "UPDATE `actividades_lotes` SET `fecha`='" . fecha_a_mysql($fecha) . "',`superficie`=" . $superficie . ",`precioha`=" . $precioHa . " WHERE idactividad=" . $idactividad;
        return $this->bd->modificar($sql);
    }

    public function insertarActividadInsumo($idactividad, $idinsumo, $precio, $cantidadha, $cantidadTotal)
    {
        $sql = "INSERT INTO `actividades_insumos`(`idactividad`, `idinsumo`, `cantidadHa`, `precio`, `cantidadTotal`) VALUES ('" . $idactividad . "','" . $idinsumo . "','" . $cantidadha . "','" . $precio . "','" . $cantidadTotal . "')";
        return $this->bd->insertar($sql);
    }

    public function salidaDepositoPrimario($idEmpresa,$idactividad_insumo,$cantidad)
    {
        //buscamos el id de insumo
        $sql="SELECT idinsumo FROM actividades_insumos WHERE idactividad_insumo=".$idactividad_insumo;
        $datos=$this->bd->sql($sql);
        $idinsumo=$datos[0]["idinsumo"];
        $sql="SELECT stock,iddeposito_insumo FROM depositos d INNER JOIN depositos_insumos di ON d.iddeposito=di.iddeposito WHERE d.idempresa=".$idEmpresa." and d.idproveedor=".$idEmpresa." and di.idinsumo=".$idinsumo;
        $datos= $this->bd->sql($sql);
        $iddeposito=0;
        if($datos)
        {
            // 'se actualiza el stock en depositos insumos';
            $stock=$datos[0]["stock"]-$cantidad;
            $id=$datos[0]["iddeposito_insumo"];
            $sql="UPDATE  depositos_insumos SET stock=".$stock." WHERE iddeposito_insumo=".$id;
            $this->bd->modificar($sql);
        }else{
            // "se busca si existe el deposito principal para esta empresa";
            $sql="SELECT iddeposito FROM depositos WHERE idempresa=".$idEmpresa." and idproveedor=".$idEmpresa;
            $datos=$this->bd->sql($sql);
            if($datos)
            {
                // "se encontro un deposito principal";
                $iddeposito=$datos[0]["iddeposito"];
            }else
            {
                // "se va a crear un deposito principal";
                $sql="INSERT INTO depositos (`deposito`,`idempresa`,`idproveedor`) VALUES ('Deposito Principal',".$idEmpresa.",".$idEmpresa.")";
                // "<br>".$sql."<br>";
                $iddeposito=$this->bd->insertar($sql);
            }
            // "se va a crear un stock nuevo para este insumo";
            $sql="INSERT INTO depositos_insumos (`iddeposito`,`idinsumo`,`stock`) VALUES (".$iddeposito.",".$idinsumo.",".-$cantidad.")";
            $this->bd->insertar($sql);
        }
    }

    public function borrarActividadInsumo($id)
    {
        //se van a actualizar los stock de las empresas
        $sql="SELECT * FROM `insumos_empresas` WHERE idactividad_insumo=".$id;
        $datos=$this->bd->sql($sql);
        foreach ($datos as $dato) {
            $cantidadBorrar=$dato["cantidad"];
            $idempresa=$dato["idempresa"];
            $idactividad_insumo=$dato["idactividad_insumo"];
            $this->salidaDepositoPrimario($idempresa,$idactividad_insumo,-$cantidadBorrar);
        }

        $sql = "DELETE FROM `actividades_insumos` WHERE idactividad_insumo=" . $id;
        $resultado = $this->bd->eliminar($sql);
        if ($resultado) {
            return 1;
        } else {
            return 0;
        }
    }

    public function modificarActividadInsumo($id, $precio, $cantidadHa, $cantidadTotal)
    {
        $sql = "UPDATE `actividades_insumos` SET `cantidadHa`=" . $cantidadHa . ",`precio`=" . $precio . ",`cantidadTotal`=" . $cantidadTotal . " WHERE idactividad_insumo=" . $id;
        return $this->bd->modificar($sql);
    }

    public function modificarInsumosDeActividad($id, $superficie)
    {
        $sql = "UPDATE `actividades_insumos` SET `cantidadTotal`=cantidadHa*" . $superficie . " WHERE idactividad=" . $id;
        return $this->bd->modificar($sql);
    }

    public function actividadMaquinaria($id) //devuelve el valor del tipo de maquinaria, si es contratada o propia
    {
        $sql = "SELECT maquinaria FROM actividades_lotes WHERE idactividad=" . $id;
        return $this->bd->sql($sql);
    }

    public function guardarActividadMaquinaria($id, $tipo)
    {
        $sql = "UPDATE `actividades_lotes` SET `maquinaria`=" . $tipo . " WHERE idactividad=" . $id;
        return $this->bd->modificar($sql);
    }

    public function borrarActividadesPersonales($id) //borra todos los personales que existen para esa actividad (cero, uno o varios registros)
    {
        $sql = "DELETE FROM `actividades_personales` WHERE idactividad=" . $id;
        $resultado = $this->bd->eliminar($sql);
        if ($resultado) {
            return 1;
        } else {
            return 0;
        }
    }

    public function borrarActividadesTerceros($id) //borra todos los terceros que existen para esa actividad(cero, uno o varios registros) 
    {
        $sql = "DELETE FROM `actividades_terceros` WHERE idactividad=" . $id;
        $resultado = $this->bd->eliminar($sql);
        if ($resultado) {
            return 1;
        } else {
            return 0;
        }
    }

    public function guardarActividadPersonal($idactividad, $idpersonal, $precioHa)
    {
        $sql = "INSERT INTO `actividades_personales`(`idactividad`, `idpersonal`, `precioHa`) VALUES (" . $idactividad . "," . $idpersonal . "," . $precioHa . ")";
        return $this->bd->insertar($sql);
    }

    public function guardarActividadTercero($idactividad, $idtercero, $precioHa)
    {
        $sql = "INSERT INTO `actividades_terceros`(`idactividad`, `idempresa`, `precioHa`) VALUES (" . $idactividad . "," . $idtercero . "," . $precioHa . ")";
        return $this->bd->insertar($sql);
    }

    public function listarPersonales($idactividad)
    {
        $sql = "SELECT a.idactividad_personal,p.personal,p.idpersonal,a.precioHa FROM actividades_personales a INNER JOIN personales p ON a.idpersonal=p.idpersonal WHERE idactividad=" . $idactividad;
        return $this->bd->sql($sql);
    }

    public function listarTerceros($idactividad)
    {
        $sql = "SELECT a.idactividad_tercero,e.empresa as tercero,a.precioHa FROM actividades_terceros a INNER JOIN empresas e ON a.idempresa=e.idempresa WHERE idactividad=" . $idactividad;
        return $this->bd->sql($sql);
    }

    public function borrarPersonales($id) //borra todos el personal de la lista de actividades (un solo registro)
    {
        $sql = "DELETE FROM `actividades_personales` WHERE idactividad_personal=" . $id;
        $resultado = $this->bd->eliminar($sql);
        if ($resultado) {
            return 1;
        } else {
            return 0;
        }
    }

    public function borrarTerceros($id) //borra todos el personal de la lista de actividades (un solo registro)
    {
        $sql = "DELETE FROM `actividades_terceros` WHERE idactividad_tercero=" . $id;
        $resultado = $this->bd->eliminar($sql);
        if ($resultado) {
            return 1;
        } else {
            return 0;
        }
    }

    public function modificarPersonales($id, $precioHa)
    {
        $sql = "UPDATE `actividades_personales` SET `precioHa`=" . $precioHa . " WHERE idactividad_personal=" . $id;
        return $this->bd->modificar($sql);
    }

    public function modificarTerceros($id, $precioHa)
    {
        $sql = "UPDATE `actividades_terceros` SET `precioHa`=" . $precioHa . " WHERE idactividad_tercero=" . $id;
        return $this->bd->modificar($sql);
    }

    public function guardarObservaciones($id, $observaciones)
    {
        $sql = "UPDATE `actividades_lotes` SET `observaciones`='" . $observaciones . "' WHERE idactividad=" . $id;
        return $this->bd->modificar($sql);
    }

    public function importeInsumos($id)
    {
        $sql = "SELECT SUM(i.cantidadTotal*i.precio) as importe FROM `lotescampanas` l INNER JOIN actividades_lotes a ON l.idloteCampana=a.idloteCampana INNER JOIN actividades_insumos i on a.idactividad=i.idactividad WHERE l.idloteCampana=" . $id;
        return $this->bd->sql($sql);
    }

    public function importeInsumosPorLote($idloteCampana)
    {
        //devuelve cantidad, insumo, importe de cada insumo por lote
        $sql = "SELECT SUM(ai.cantidadTotal) as cantidad,i.insumo,SUM(ai.cantidadTotal*ai.precio) as importe FROM `actividades_lotes` al INNER JOIN `actividades_insumos` ai ON al.idactividad=ai.idactividad INNER JOIN insumos i ON ai.idinsumo=i.idinsumo WHERE al.idloteCampana=" . $idloteCampana . " GROUP BY i.idinsumo";
        return $this->bd->sql($sql);
    }

    public function guardarProductorActividad($idactividad, $idempresa, $total)
    {
        $sql = "INSERT INTO `actividades_empresas`(`idactividad`, `idempresa`, `total`) VALUES (" . $idactividad . "," . $idempresa . "," . $total . ")";
        return $this->bd->insertar($sql);
    }
    public function guardarProductorInsumo($idactividad_insumo, $idempresa, $total,$cantidad)
    {
        $sql = "INSERT INTO `insumos_empresas`(`idactividad_insumo`, `idempresa`, `total`,`cantidad`) VALUES (" . $idactividad_insumo . "," . $idempresa . "," . $total . "," . $cantidad . ")";
        return $this->bd->insertar($sql);
    }
    public function ProductorActividad($idactividad)
    {
        $sql = "SELECT ae.idactividad_empresa,ae.idactividad,e.idempresa,e.empresa,ae.total FROM actividades_empresas ae INNER JOIN empresas e ON ae.idempresa=e.idempresa WHERE idactividad=" . $idactividad;
        return $this->bd->sql($sql);
    }

    public function ProductorInsumo($idactividad_insumo)
    {
        $sql = "SELECT ie.idinsumo_empresa,ie.idactividad_insumo,e.idempresa,e.empresa,ie.total,ie.cantidad FROM insumos_empresas ie INNER JOIN empresas e ON ie.idempresa=e.idempresa WHERE idactividad_insumo=" . $idactividad_insumo;
        return $this->bd->sql($sql);
    }

    public function participacionProductores($idloteCampana)
    {

        $sql = "SELECT tem.idempresa, tem.empresa, sum(tem.total) as total
        From (
        SELECT e.empresa,ae.total,e.idempresa  FROM `actividades_lotes` al INNER JOIN actividades_empresas ae on al.idactividad=ae.idactividad INNER JOIN empresas e ON ae.idempresa=e.idempresa WHERE al.idloteCampana=".$idloteCampana." 
        UNION ALL
        SELECT e.empresa,ie.total,e.idempresa  
        FROM `actividades_lotes` al INNER JOIN actividades_insumos ai on al.idactividad=ai.idactividad INNER JOIN `insumos_empresas` ie ON ai.idactividad_insumo=ie.idactividad_insumo INNER JOIN empresas e ON ie.idempresa=e.idempresa WHERE al.idloteCampana=".$idloteCampana." 
        ) as tem
        GROUP BY tem.idempresa";
        return $this->bd->sql($sql);
        
    }

    public function borrarProductorActividad($idactividad_empresa)
    {
        $sql="DELETE FROM actividades_empresas WHERE idactividad_empresa=".$idactividad_empresa;
        //echo $sql;
        return $this->bd->eliminar($sql);
    }

    public function modificarProductorActividad($idactividad_empresa,$total)
    {
        $sql="UPDATE actividades_empresas SET total=".$total." WHERE idactividad_empresa=".$idactividad_empresa;
        return $this->bd->modificar($sql);
    }

    public function borrarProductorInsumo($idinsumo_empresa)
    {
        //buscamos la cantidad que tiene la empresa aportada
        $sql="SELECT * FROM insumos_empresas WHERE idinsumo_empresa=".$idinsumo_empresa;
        $datos=$this->bd->sql($sql);
        $cantidadBorrar=$datos[0]["cantidad"];
        $idempresa=$datos[0]["idempresa"];
        $idactividad_insumo=$datos[0]["idactividad_insumo"];
        //echo $sql;
        $this->salidaDepositoPrimario($idempresa,$idactividad_insumo,-$cantidadBorrar);
        $sql="DELETE FROM insumos_empresas WHERE idinsumo_empresa=".$idinsumo_empresa;
        return $this->bd->eliminar($sql);
    }

    public function modificarProductorInsumo($idinsumo_empresa,$total,$cantidadTotal)
    {
        $sql="SELECT * FROM insumos_empresas WHERE idinsumo_empresa=".$idinsumo_empresa;
        $datos=$this->bd->sql($sql);
        $idempresa=$datos[0]["idempresa"];
        $cantidadOld=$datos[0]["cantidad"];
        $idactividad_insumo=$datos[0]["idactividad_insumo"];
        $this->salidaDepositoPrimario($idempresa,$idactividad_insumo,$cantidadTotal-$cantidadOld);
        
        $sql="UPDATE insumos_empresas SET `total`=".$total.",`cantidad`=".$cantidadTotal." WHERE idinsumo_empresa=".$idinsumo_empresa;
        return $this->bd->modificar($sql);
        
    }
}
