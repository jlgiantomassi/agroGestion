<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php include 'includes/header.php'; ?>

    <title>AgroGestion</title>
</head>

<body>
    <?php
    $raiz = "";

    session_start();


    if (isset($_SESSION["idusuario"])) {

        $idCampanaActiva = $_SESSION["idcampana"];
        $idUsuarioActivo = $_SESSION["idusuario"];
        $idEmpresaActiva = $_SESSION["idempresa"];
        $usuarioActivo = "Jose L Giantomassi";                            //cambiar 
        $campanaActiva = "21-22";                                           //cambiar
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
        $oUsuario->modificarUltimoIdEmpresa($idUsuarioActivo, $idEmpresaActiva);
    }

    include_once("includes/modelos/campanasModelo.php");
    include_once("includes/modelos/empresasModelo.php");
    $oCampanas = new campanasModel();
    $campanas = $oCampanas->listarCampanas();

    $oEmpesas = new empresasModel();
    $empresas = $oEmpesas->empresaById($idEmpresaActiva);
    if ($empresas) {
        $empresaActiva = $empresas[0]["empresa"];
        $idempresaActiva = $empresas[0]["idempresa"];
    } else {
        $empresaActiva = "";
        $idempresaActiva = 0;
    }

    $emp = $oEmpesas->listarEmpresasRubros(1, 0, 0, 0, $idUsuarioActivo);

    ?>
    <script src="jquery/menu.js?version=<?php echo rand(1, 10000); ?>"></script>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="<?php echo 'index.php' ?>">agroGestion</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <!--
            <li class="nav-item active">
                <a class="nav-link" href="#">Home</a>
            </li>
            -->
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
                        Gestion
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                        <a class="dropdown-item" href="prescripciones.php">Agregar Orden</a>
                        <a class="dropdown-item" href="verOrdenes.php">Ver Ordenes</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="actividades.php">Agregar Actividad</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Financiero
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                        <a class="dropdown-item" href="cuentas.php">Cuentas</a>
                        <a class="dropdown-item" href="pagos.php">Pagos</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Otros</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Proveedores
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                        <a class="dropdown-item" href="facturas.php">Facturas</a>
                        <a class="dropdown-item" href="remitos.php">Remitos</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="ctasCtes.php">Cuentas Corrientes</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Stocks
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="stockInsumos.php">Stock de Insumos</a>
                        <a class="dropdown-item" href="stockcereales.php">Stock de Cereales</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Personales
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                        <a class="dropdown-item" href="personalesPagos.php">Pagos</a>
                        <a class="dropdown-item" href="personalesSaldos.php">Saldos</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">reservado</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $usuarioActivo; ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                        <a class="nav-link" href="cerrarsesion.php">Cerrar Sesion</a>

                    </div>
                </li>

            </ul>
            <form class="form-inline my-2 my-lg-0">
                <select class="form-control mr-2" name="sltEmpresaActiva" id="sltEmpresaActiva">
                    <?php
                    foreach ($emp as $row) {
                        if ($row['idempresa'] == $idEmpresaActiva) {
                            $idSel = "selected";
                        } else {
                            $idSel = "";
                        }
                    ?>
                        <option <?php echo $idSel; ?> value="<?php echo $row['idempresa']; ?>"><?php echo $row['empresa']; ?></option>
                    <?php } ?>
                </select>
                <input type="hidden" id="idUsuarioActivo" value="<?php echo $idUsuarioActivo; ?>">
                <input type="hidden" id="idEmpresaActiva" value="<?php echo $idEmpresaActiva; ?>">
                <input type="hidden" id="idCampanaActiva" value="<?php echo $idCampanaActiva; ?>">
                <select class="form-control" name="sltcampanas" id="sltcampanas">
                    <?php
                    foreach ($campanas as $campana) {
                        if ($campana['idcampana'] == $idCampanaActiva) {
                            $idSel = "selected";
                        } else {
                            $idSel = "";
                        }
                    ?>
                        <option <?php echo $idSel; ?> value="<?php echo $campana['idcampana']; ?>"><?php echo $campana['campana']; ?></option>
                    <?php } ?>
                </select>


            </form>
        </div>
    </nav>

    <?php include 'includes/footer.php'; ?>
</body>

</html>