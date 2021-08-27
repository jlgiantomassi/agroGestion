<?php
session_start();
if(isset($_SESSION["idusuario"]))
{   
   
    $idCampanaActiva = $_SESSION["idcampana"];
    $idUsuarioActivo = $_SESSION["idusuario"];
    $idEmpresaActiva = $_SESSION["idempresa"];
    $usuarioActivo="Jose L Giantomassi";
    $campanaActiva="20-21";
}
else{
    echo "El usuario no esta logeado";
    session_destroy();
    exit();
}
