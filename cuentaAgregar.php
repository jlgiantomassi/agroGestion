<?php
$raiz = "";
include 'includes/modelos/cuentasModelo.php';

$oCuentas = new cuentasModel();
if (isset($_POST["enviar"])) {
    $idtipo = $_POST["sltTipoCuenta"];
    $idmoneda = $_POST["sltMoneda"];
    $cuenta = $_POST["txtCuenta"];
    $numero = $_POST["txtNumeroCuenta"] == "" ? 0 : $_POST["txtNumeroCuenta"] == "";
    $idempresaAct = $_POST["idEmpresaActiva"];
    $oCuentas->agragarCuenta($cuenta, $numero, $idtipo, $idmoneda, $idempresaAct);
    header("Location:cuentas.php");
}

?>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php include 'includes/header.php'; ?>
    <title>AgroGestion</title>
</head>

<body>
    <?php

    include_once 'includes/menu.php';
    include_once 'includes/modelos/personalesModelo.php';
    include_once 'includes/modelos/empresasModelo.php';

    $tipos = $oCuentas->tipoCuentas($idEmpresaActiva);
    $monedas = $oCuentas->monedas($idEmpresaActiva);

    $oPersonales = new personalesModel();
    $personales = $oPersonales->listarPersonales($idEmpresaActiva);

    $oEmp = new empresasModel();
    $Lempresas = $oEmp->listarEmpresasRubros(1,1,1,1, $idUsuarioActivo);
    ?>
    <script src="jquery/cuentas.js?version=<?php echo rand(1, 10000); ?>"></script>
    <div class="container border bg-white col-8">
        <div id="alerta"></div>
        <div id="formFacturas">
            <div class="row">
                <div class="shadow p-3 mb-3 bg-white rounded col-md-12 ">
                    <h5>Agregar una cuenta Financiera</h5>
                </div>
            </div>

        </div>


        <div class="card">
            <div class="card-body col-9">
                <form id="frmAddcuentas" name="frmAddcuentas" method="POST" action="cuentaAgregar.php">

                    <div class="form-group">
                        <label for="txtCuenta" class="col-form-label">Cuenta:</label>
                        <input type="text" class="form-control" id="txtCuenta" name="txtCuenta" value="" required>
                    </div>
                    <div class="form-group">

                        <label for="sltTipoCuenta" class="col-form-label">Tipo Cuenta:</label>
                        <button type="button" class="btn btn-sm" id="btnNuevoTipoCuenta"><i class="material-icons">add_box</i></button>
                        <div class="input-group mb-3 d-none" id="agregarTipoCuenta">
                            <input type="text" id="txtNuevoTipoCuenta" class="form-control" placeholder="Agregar nueva cuenta">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" id="btnAgregarTipoCuenta" type="button">+</button>
                            </div>
                        </div>
                        <select name="sltTipoCuenta" id="sltTipoCuenta" class="form-control">
                            <?php
                            foreach ($tipos as $tipo) { ?>
                                <option value="<?php echo $tipo['idtipocuenta']; ?>"><?php echo $tipo['tipo']; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="sltempresas" class="col-form-label">Moneda:</label>
                        <button type="button" class="btn btn-sm" id="btnNuevaMoneda"><i class="material-icons">add_box</i></button>

                        <div class="input-group mb-3 d-none" id="agregarMoneda">
                            <input type="text" id="txtNuevaMoneda" class="form-control" placeholder="Agregar nueva moneda">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" id="btnAgregarMoneda" type="button">+</button>
                            </div>
                        </div>
                        <select name="sltMoneda" id="sltMoneda" class="form-control">
                            <?php
                            foreach ($monedas as $moneda) { ?>
                                <option value="<?php echo $moneda['idmoneda']; ?>"><?php echo $moneda['moneda']; ?></option>
                            <?php
                            } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="txtNumeroCuenta" class="col-form-label">Numero Cuenta:</label>
                        <input type="number" class="form-control" id="txtNumeroCuenta" name="txtNumeroCuenta" value="">
                    </div>
                    <label for="txtpertenece" class="col-form-label">La cuenta pertenece a:</label>
                    <div class="form-group">

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="propia" name="pertenece" value="propia" checked><label class="form-check-label" for="propia">Propia</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="personales" name="pertenece" value="personales"><label class="form-check-label" for="personales">Personales</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="empresas" name="pertenece" value="empresas"><label class="form-check-label" for="empresas">Empresas</label>
                        </div>
                    </div>
                    <div class="form-group d-none" id="divPersonales">
                        <select name="sltPersonales" id="sltPersonales" class="form-control">
                            <?php
                            foreach ($personales as $personal) { ?>
                                <option value="<?php echo $personal['idpersonal']; ?>"><?php echo $personal['personal']; ?></option>
                            <?php
                            } ?>
                        </select>
                    </div>

                    <div class="form-group d-none" id="divEmpresas">
                        <select name="sltEmpresas" id="sltEmpresas" class="form-control">
                            <?php
                            foreach ($Lempresas as $Lemp) { ?>
                                <option value="<?php echo $Lemp['idempresa']; ?>"><?php echo $Lemp['empresa']; ?></option>
                            <?php
                            } ?>
                        </select>
                    </div>
                    <input type="hidden" name="idEmpresaActiva" value="<?php echo $idEmpresaActiva; ?>" <div class="modal-footer">
                    <a href="cuentas.php" class="btn btn-secondary">Cancelar</a>
                    <input type="submit" class="btn btn-primary" id="enviar" name="enviar" value="Agregar">
            </div>
            </form>
        </div>
    </div>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>

</html>