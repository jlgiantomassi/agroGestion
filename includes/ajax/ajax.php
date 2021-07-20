<?php
$raiz="../../";
include_once($raiz."conexion/BaseDatos.php");
include_once $raiz.'includes/modelos/camposModelo.php';
include_once $raiz.'includes/modelos/campanasModelo.php';
include_once $raiz.'includes/modelos/insumosModelo.php';
include_once $raiz.'includes/modelos/laboresModelo.php';
include_once $raiz.'includes/modelos/personalesModelo.php';
include_once $raiz.'includes/modelos/usuariosModelo.php';
$accion = $_GET['accion'];
switch ($accion) {
    case "todosCampos":
        $oCampos = new camposModel();
        $datos=$oCampos->listarCampos();
        echo json_encode($datos);
        break;
    case "campos":
        $idcampo = $_GET['idcampo'];
        $oCampos = new camposModel();
        $datos=$oCampos->listarLotes($idcampo);
        echo json_encode($datos);
        break;
    case "productores":
        $id = $_GET['idproductor'];
        $oProductores=new usuariosModel();
        $datos=$oProductores->usuarioById($id);
        echo json_encode($datos);
        break;
    case "terceros":
        $id = $_GET['idtercero'];
        $oTerceros=new usuariosModel();
        $datos=$oTerceros->usuarioById($id);
        echo json_encode($datos);
        break;
    case "personales":
        $id = $_GET['idpersonal'];
        $oPersonales=new personalesModel();
        $datos=$oPersonales->personalById($id);
        echo json_encode($datos);
        break;
    case "lotes":
        $id = $_GET['idlote'];
        $oCampos=new camposModel();
        $datos=$oCampos->loteById($id);
        echo json_encode($datos);
        break;
    case "labores":
        $id = $_GET['idlabor'];
        $oLabores=new laboresModel();
        $datos=$oLabores->laborById($id);
        echo json_encode($datos);
        break;
    case "insumos":
        $id = $_GET['idinsumo'];
        $oInsumos=new insumosModel();
        $datos=$oInsumos->insumoById($id);
        echo json_encode($datos);
        break;
    case "insLabor":
        $labor = $_GET['labor'];
        $precioLabor = $_GET['precio'];
        $id = 0;
        $oLabores=new laboresModel();
        $id=$oLabores->insertar($labor,$precioLabor);
        if ($id > 0) {
            echo $id;
        } else {
            echo "false";
        }
        break;
    case "insProductor":
        $productor = $_GET['productor'];
        $cuit = $_GET['cuit'];
        $direccion = $_GET['direccion'];
        $id = 0;
        $oProductores=new usuariosModel();
        $datos=$oProductores->usuarioById($productor);
        $id=$oProductores->insertar($productor,$cuit,$direccion,'true','false','false');
        if ($id > 0) {
            echo $id;
        } else {
            echo "false";
        }
        break;
    case "insTercero":
        $tercero = $_GET['tercero'];
        $cuit = $_GET['cuit'];
        $direccion = $_GET['direccion'];
        $id = 0;
        $oTerceros=new usuariosModel();
        $id=$oTerceros->insertar($tercero,$cuit,$direccion,'false','true','false');
        if ($id > 0) {
            echo $id;
        } else {
            echo "false";
        }
        break;
    case "insPersonal":
        $personal = $_GET['personal'];
        $cuil = $_GET['cuil'];
        $precioHa = $_GET['precioHa'];
        $id = 0;
        $oPersonales=new personalesModel();
        $id=$oPersonales->insertar($personal,$cuil,$precioHa);
        if ($id > 0) {
            echo $id;
        } else {
            echo "false";
        }
        break;
    case "insInsumos":
        $idunidad = $_GET['idunidad'];
        $insumo = $_GET['insumo'];
        $precio = $_GET['precio'];
        $id = 0;
        $oInsumos=new insumosModel();
        $id=$oInsumos->insertar($insumo,$precio,$idunidad);
        if ($id > 0) {
            echo $id;
        } else {
            echo "false";
        }
        break;
    case "insLote":
        $idcampo = $_GET['idcampo'];
        $lote = $_GET['lote'];
        $superficie = $_GET['superficie'];
        $id = 0;
        $oLotes=new camposModel();
        $id=$oLotes->insertarLote($lote,$superficie,$idcampo);
        if ($id > 0) {
            echo $id;
        } else {
            echo "false";
        }
        break;
    case "insCampo":
        $campo = $_GET['campo'];
        $id = 0;
        $oCampos=new camposModel();
        $id=$oCampos->insertarCampo($campo);
        if ($id > 0) {
            echo $id;
        } else {
            echo "false";
        }
        break;
}

?>
