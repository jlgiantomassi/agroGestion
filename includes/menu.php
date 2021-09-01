<?php
$raiz = "";
include_once("controlLogin.php");
include_once("includes/modelos/campanasModelo.php");
include_once("includes/modelos/empresasModelo.php");
$oCampanas = new campanasModel();
$campanas = $oCampanas->listarCampanas();

$oEmpesas=new empresasModel();
$empresas=$oEmpesas->empresaById($idEmpresaActiva);
$empresaActiva=$empresas[0]["empresa"];

?>
<script src="jquery/menu.js?version=<?php echo rand(1, 10000); ?>"></script>
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
                    <a class="dropdown-item" href="empresas.php">Empresas</a>
                    <a class="dropdown-item" href="campos.php">Campos</a>
                    <a class="dropdown-item" href="insumos.php">Insumos</a>
                    <a class="dropdown-item" href="labores.php">Labores</a>
                    <a class="dropdown-item" href="personales.php">Personales</a>
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
            <label class="form-control mr-sm-2" id="usuarioActivo"><?php echo $usuarioActivo; ?></label>
            <label class="form-control mr-sm-2" id="empresaActiva"><?php echo $empresaActiva; ?></label>
            <input type="hidden" id="idUsuarioActivo" value="<?php echo $idUsuarioActivo; ?>">
            <input type="hidden" id="idEmpresaActiva" value="<?php echo $idEmpresaActiva; ?>">
            <select class="form-control" name="sltcampanas" id="sltcampanas">
                <?php
                foreach ($campanas as $campana) {
                    if($campana['idcampana']==$idCampanaActiva)
                    {
                        $idSel="selected";
                    }else
                    {
                        $idSel="";
                    }
                ?>
                    <option <?php echo $idSel; ?> value="<?php echo $campana['idcampana']; ?>"><?php echo $campana['campana']; ?></option>
                <?php } ?>
            </select>

            <input type="hidden" id="idCampanaActiva" value="<?php echo $idCampanaActiva; ?>">
        </form>
    </div>
</nav>