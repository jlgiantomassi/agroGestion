<?php
$raiz = "../../";
include_once($raiz . "includes/controlLogin.php");
include_once($raiz . "conexion/BaseDatos.php");
include_once $raiz . 'includes/modelos/camposModelo.php';
include_once $raiz . 'includes/modelos/campanasModelo.php';
include_once $raiz . 'includes/modelos/insumosModelo.php';
include_once $raiz . 'includes/modelos/laboresModelo.php';
include_once $raiz . 'includes/modelos/personalesModelo.php';
include_once $raiz . 'includes/modelos/usuariosModelo.php';
include_once $raiz . 'includes/modelos/cultivosModelo.php';
include_once $raiz . 'includes/modelos/empresasModelo.php';
$accion = $_GET['accion'];
switch ($accion) {
    case "todosCampos":
        $oCampos = new camposModel();
        $datos = $oCampos->listarCampos($idUsuarioActivo);
        echo json_encode($datos);
        break;
    case "campos":
        $idcampo = $_GET['idcampo'];
        $oCampos = new camposModel();
        $datos = $oCampos->listarLotes($idcampo);
        echo json_encode($datos);
        break;
    case "productores":
        $id = $_GET['idproductor'];
        $oProductores = new empresasModel();
        $datos = $oProductores->empresaById($id);
        echo json_encode($datos);
        break;
    case "empresas":
        $id = $_GET['idempresa'];
        $oEmpresas = new empresasModel();
        $datos = $oEmpresas->empresaById($id);
        echo json_encode($datos);
        break;
    case "terceros":
        $id = $_GET['idtercero'];
        $oTerceros = new usuariosModel();
        $datos = $oTerceros->usuarioById($id);
        echo json_encode($datos);
        break;
    case "personales":
        $id = $_GET['idpersonal'];
        $oPersonales = new personalesModel();
        $datos = $oPersonales->personalById($id);
        echo json_encode($datos);
        break;
    case "lotes":
        $id = $_GET['idlote'];
        $oCampos = new camposModel();
        $datos = $oCampos->loteById($id);
        echo json_encode($datos);
        break;
    case "loteCultivo":
        $idlote = $_GET['idlote'];
        $idusuario = $_GET['idusuario'];
        $idcampana = $_GET['idcampana'];
        $oCultivos = new cultivosModel();
        $datos = $oCultivos->cultivoPorCampana($idlote, $idusuario, $idcampana);
        echo json_encode($datos);
        break;
    case "loteCultivoGuardar":
        $idlote = $_GET['idlote'];
        $idusuario = $_GET['idusuario'];
        $idcampana = $_GET['idcampana'];
        $idcultivo = $_GET['idcultivo'];
        $oCultivos = new cultivosModel();
        $id = $oCultivos->insertarCultivoEnCampana($idlote, $idusuario, $idcampana, $idcultivo);
        if ($id > 0) {
            echo $id;
        } else {
            echo "false";
        }
        break;
    case "loteCultivoModificar":
        $idlote = $_GET['idlote'];
        $idusuario = $_GET['idusuario'];
        $idcampana = $_GET['idcampana'];
        $idcultivo = $_GET['idcultivo'];
        $oCultivos = new cultivosModel();
        $id = $oCultivos->modificarCultivoEnCampana($idlote, $idusuario, $idcampana, $idcultivo);
        if ($id > 0) {
            echo $id;
        } else {
            echo "false";
        }
        break;
    case "labores":
        $id = $_GET['idlabor'];
        $oLabores = new laboresModel();
        $datos = $oLabores->laborById($id);
        echo json_encode($datos);
        break;
    case "insumos":
        $id = $_GET['idinsumo'];
        $oInsumos = new insumosModel();
        $datos = $oInsumos->insumoById($id);
        echo json_encode($datos);
        break;
    case "insLabor":
        $labor = $_GET['labor'];
        $precioLabor = $_GET['precio'];
        $idusuario = $_GET['idusuario'];
        $id = 0;
        $oLabores = new laboresModel();
        $id = $oLabores->insertar($labor, $precioLabor, $idUsuarioActivo);
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
        $oProductores = new usuariosModel();
        $datos = $oProductores->usuarioById($productor);
        $id = $oProductores->insertar($productor, $cuit, $direccion, 'true', 'false', 'false');
        if ($id > 0) {
            echo $id;
        } else {
            echo "false";
        }
        break;
    case "insEmpresa":
        $empresa = $_GET['empresa'];
        $cuit = $_GET['cuit'];
        $direccion = $_GET['direccion'];
        $productor = $_GET['productor'];
        $contratista = $_GET['contratista'];
        $proveedor = $_GET['proveedor'];
        $otro = $_GET['otro'];
        $idusuario = $_GET['idusuario'];
        $id = 0;
        $oEmpresas = new empresasModel();
        echo $oEmpresas->insertar($empresa, $cuit, $direccion, $productor, $contratista, $proveedor, $otro, $idusuario);
        break;
    case "modificarEmpresa":
        $cuit = $_GET['cuit'];
        $direccion = $_GET['direccion'];
        $productor = $_GET['productor'];
        $contratista = $_GET['contratista'];
        $proveedor = $_GET['proveedor'];
        $otro = $_GET['otro'];
        $idempresa = $_GET['idempresa'];
        $id = 0;
        $oEmpresas = new empresasModel();
        echo $oEmpresas->modificar($cuit, $direccion, $productor, $contratista, $proveedor, $otro, $idempresa);
    break;
    case "insTercero":
        $tercero = $_GET['tercero'];
        $cuit = $_GET['cuit'];
        $direccion = $_GET['direccion'];
        $id = 0;
        $oTerceros = new usuariosModel();
        $id = $oTerceros->insertar($tercero, $cuit, $direccion, 'false', 'true', 'false');
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
        $idusuario = $_GET['idusuario'];
        $id = 0;
        $oPersonales = new personalesModel();
        $id = $oPersonales->insertar($personal, $cuil, $precioHa, $idusuario);
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
        $idusuario = $_GET['idusuario'];
        $id = 0;
        $oInsumos = new insumosModel();
        $id = $oInsumos->insertar($insumo, $precio, $idunidad, $idusuario);
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
        $oLotes = new camposModel();
        $id = $oLotes->insertarLote($lote, $superficie, $idcampo);
        if ($id > 0) {
            echo $id;
        } else {
            echo "false";
        }
        break;
    case "insCampo":
        $campo = $_GET['campo'];
        $idusuario = $_GET['idusuario'];
        $id = 0;
        $oCampos = new camposModel();
        $id = $oCampos->insertarCampo($campo, $idusuario);
        if ($id > 0) {
            echo $id;
        } else {
            echo "false";
        }
        break;
    case "borrarCampo":
        $idcampo = $_GET["idcampo"];
        $oCampos = new camposModel();
        echo $oCampos->borrarCampo($idcampo);
        break;
    case "borrarLote":
        $idlote = $_GET["idlote"];
        $oLotes = new camposModel();
        echo $oLotes->borrarLote($idlote);
        break;
    case "modificarCampo":
        $idcampo = $_GET["idcampo"];
        $campo = $_GET["campo"];
        $oCampos = new camposModel();
        echo $oCampos->modificarCampo($campo, $idcampo);
        break;
    case "modificarLote":
        $idlote = $_GET["idlote"];
        $lote = $_GET["lote"];
        $superficie = $_GET["superficie"];
        $oLotes = new camposModel();
        echo $oLotes->modificarLote($lote, $idlote, $superficie);
        break;
    case "modificarInsumo":
        $idinsumo = $_GET["idinsumo"];
        $insumo = $_GET["insumo"];
        $precio = $_GET["precio"];
        $idunidad = $_GET["idunidad"];
        $oInsumos = new insumosModel();
        echo $oInsumos->modificarInsumo($insumo, $idinsumo, $precio, $idunidad);
        break;
    case "borrarInsumo":
        $idinsumo = $_GET["idinsumo"];
        $oInsumos = new insumosModel();
        echo $oInsumos->borrarInsumo($idinsumo);
        break;
    case "modificarLabor":
        $idlabor = $_GET["idlabor"];
        $labor = $_GET["labor"];
        $precio = $_GET["precio"];
        $oLabores = new laboresModel();
        echo $oLabores->modificarLabor($labor, $idlabor, $precio);
        break;
    case "borrarLabor":
        $idlabor = $_GET["idlabor"];
        $oLabores = new laboresModel();
        echo $oLabores->borrarLabor($idlabor);
        break;
    case "modificarPersonal":
        $idpersonal = $_GET["idpersonal"];
        $personal = $_GET["personal"];
        $precioHa = $_GET["precioHa"];
        $cuil = $_GET["cuil"];
        $oPersonal = new personalesModel();
        echo $oPersonal->modificarPersonal($personal, $idpersonal, $precioHa, $cuil);
        break;
    case "borrarPersonal":
        $idpersonal = $_GET["idpersonal"];
        $oPersonal = new personalesModel();
        echo $oPersonal->borrarPersonal($idpersonal);
    break;
    case "borrarEmpresa":
        $idempresa = $_GET["idempresa"];
        $oEmpresa = new empresasModel();
        echo $oEmpresa->borrarEmpresa($idempresa);
    break;
}
