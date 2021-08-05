<?php
    $idusuario=26;
    $idcampana=1;
?>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include 'includes/header.php';?>
        
        <title>AgroGestion - Login</title>
    </head>
    <body>
        <?php// include 'includes/menu.php';?>
        <!-- Login -->
        <?php
            if (!isset($_SESSION)) {
                session_start();
                require_once("includes/modelos/usuariosModelo.php");
                require_once("includes/modelos/campanasModelo.php");
                $oUsuario=new usuariosModel();
                $row=$oUsuario->usuarioById($idusuario);
                $_SESSION['idusuario']=$row[0]["idusuario"];
                $_SESSION['usuario']=$row[0]["usuario"];
                
                $oCampana=new campanasModel();
                $row=$oCampana->campanaById($idcampana);
                $_SESSION['idcampana']=$row[0]["idcampana"];
                $_SESSION['campana']=$row[0]["campana"];
                header("Location:home.php");
            }
        ?>
        <?php include 'includes/footer.php';?>
    </body>
</html>
