<?php
 session_start();
if(isset($_SESSION["idusuario"]))
{   
   
    $idCampanaActiva = $_SESSION["idcampana"];
    $idUsuarioActivo = $_SESSION["idusuario"];
}
else{
    echo "El usuario no esta logeado";
    session_destroy();
    exit();
}
/*
include_once 'conexion/conexion.php';
$queryUsuarioActivo = mysqli_query($con, "select * from usuarios WHERE idusuario=".$idUsuarioActivo);
$rowUsuarioActivo = mysqli_fetch_array($queryUsuarioActivo);
$usuarioActivo = empty($rowUsuarioActivo) ? "sin usuario" : $rowUsuarioActivo['usuario'];

$queryCampanaActiva = mysqli_query($con, "select * from campanas WHERE idcampana=".$idCampanaActiva);
$rowCampanaActiva = mysqli_fetch_array($queryCampanaActiva);
$campanaActiva = empty($rowCampanaActiva) ? "sin campaña" : $rowCampanaActiva['campana'];
  */
 $usuarioActivo="Jose L Giantomassi";
 $campanaActiva="20-21";
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="<?php echo 'index.php' ?>">agroGestion</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>

            

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Datos
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Productores</a>
                    <a class="dropdown-item" href="#">Clientes</a>
                    <!-- <div class="dropdown-divider"></div> -->
                    <a class="dropdown-item" href="#">Maquinaria</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Ordenes
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="actividades.php">Agregar Actividad</a>
                    <a class="dropdown-item" href="prescripciones.php">Agregar Orden</a>
                    <a class="dropdown-item" href="verOrdenes.php">Ver Ordenes</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Reservado</a>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="cerrarsesion.php">Cerrar</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <label class="form-control mr-sm-2" id="usuarioActivo" ><?php echo $usuarioActivo; ?></label>
            <input type="hidden" id="idUsuarioActivo" value="<?php echo $idUsuarioActivo ?>">
            <label class="form-control mr-sm-2" id="campanaActiva"><?php echo $campanaActiva; ?></label>
            <input type="hidden" id="idCampanaActiva" value="<?php echo $idCampanaActiva; ?>">
        </form>
    </div>
</nav>
