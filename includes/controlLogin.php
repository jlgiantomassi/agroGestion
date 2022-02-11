<?php
session_start();


if (isset($_SESSION["idusuario"])) {

    $idCampanaActiva = $_SESSION["idcampana"];
    $idUsuarioActivo = $_SESSION["idusuario"];
    $idEmpresaActiva = $_SESSION["idempresa"];
    $usuarioActivo = "Jose L Giantomassi";
    $campanaActiva = "21-22";
} else {
    echo "El usuario no esta logeado";
    session_destroy();
    exit();
}
if (isset($_GET["idcampana"])) {
    $idCampanaActiva = $_GET["idcampana"];
    $campanaActiva = $_GET["campana"];
    $_SESSION["idcampana"] = $idCampanaActiva;
}

if (isset($_GET["MenuIdempresa"])) {
    $raiz = "../";
    include_once("modelos/usuariosModelo.php");
    $oUsuario = new usuariosModel();
    $idEmpresaActiva = $_GET["MenuIdempresa"];
    $empresaActiva = $_GET["MenuEmpresa"];
    echo $idEmpresaActiva;
    echo $empresaActiva;
    $_SESSION["idempresa"] = $idEmpresaActiva;
    $oUsuario->modificarUltimoIdEmpresa($idUsuarioActivo,$idEmpresaActiva);
}
