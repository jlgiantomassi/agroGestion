<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php include 'includes/header.php'; ?>
    <title>AgroGestion</title>
</head>

<body>
    <?php
    include_once 'includes/menu.php';
    include_once "includes/modelos/personalesModelo.php";
    //include_once "includes/modelos/empresasModelo.php";

    $oPersonales = new personalesModel();
    $personales = $oPersonales->listarPersonales($idempresaActiva);

    if (isset($_POST["enviar"])) {
        $fechaDesde = $_POST["fechaDesde"];
        $fechaHasta = $_POST["fechaHasta"];
        $idpersonal = $_POST["sltpersonales"];
        $detalles = $oPersonales->actividadesPersonales($fechaDesde,$fechaHasta,$idpersonal);
    } else {
        $fechaDesde = date("01/m/Y");
        $fechaHasta = date("d/m/Y");
        $idpersonal = 0;
        $detalles=[];
    }
    ?>
    <div class="container border bg-white col-8">
        <div id="alerta"></div>
        <div id="formFacturas">
            <div class="row">
                <div class="shadow p-3 mb-3 bg-white rounded col-md-12 ">
                    <h5>Saldos de Personales</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-2 ml-4 mb-2">
                    <a href="personalesPagos.php" class="btn btn-primary btn-sm" id="btnAgregarFactura">Agregar Pago</a>
                </div>
            </div>

            <form action="personalesSaldos.php" method="POST" class="p-2">
                <div class="shadow p-3 bg-white rounded row ">
                    <div class="col-2 form-group">
                        <label class="m-0 ml-2" for="fecha">Fecha Desde</label>
                        <input class=" col-md-10" type="text" value="<?php echo isset($_POST["fechaDesde"]) ? $fechaDesde : date('01/m/Y'); ?>" id="fechaDesde" name="fechaDesde">
                    </div>
                    <div class="col-2 form-group ">
                        <label class="m-0 ml-2" for="fecha">Fecha Hasta</label>
                        <input class=" col-md-10" type="text" value="<?php echo isset($_POST["fechaHasta"]) ? $fechaHasta : date('d/m/Y'); ?>" id="fechaHasta" name="fechaHasta">
                    </div>
                    <div class="col-3 form-group ">
                        <label class="m-0 ml-2" for="sltpersonales">Personal</label>
                        <select class="form-control col-md-12" id="sltpersonales" name="sltpersonales">
                            <option value="0"></option>
                            <?php foreach ($personales as $personal) { ?>
                                <option value="<?php echo $personal["idpersonal"]; ?>" <?php echo $idpersonal == $personal["idpersonal"] ? "selected" : ""; ?>><?php echo $personal["personal"]; ?></option>
                            <?php } ?>

                        </select>
                    </div>
                    <div class="col-1 form-group d-flex align-items-center p-0 m-0 mt-0">
                        <input class="col-10 btn btn-success" type="submit" value="Filtrar" name="enviar">
                    </div>
                </div>

            </form>
            <div class="card">
                <div class="card-body col-9">
                    <table class="table table-sm" id="tblfacturas">
                        <thead>
                            <th>Fecha</th>
                            <th>Descripcion</th>
                            <th class="text-right">Cantidad</th>
                            <th class="text-right">Importe</th>
                            <th class="text-right">Saldo</th>
                        </thead>
                        <tbody>
                            <?php
                            $saldo=0;
                            foreach ($detalles as $detalle) { 
                                $saldo+=$detalle["importe"];
                                ?>
                                <tr>
                                    <th><?php echo $detalle["fecha"] ?></th>
                                    <th><?php echo $detalle["descripcion"] ?></th>
                                    <th class="text-right"><?php echo number_format($detalle["superficie"],2); ?></th>
                                    <th class="text-right"><?php echo number_format($detalle["importe"],2); ?></th>
                                    <th class="text-right"><?php echo number_format($saldo,2); ?></th>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>

</html>
<script src="jquery/funciones.js"></script>
<script>
    $('#fechaDesde').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'dd/mm/yyyy',
        locale: 'es-es'
    });

    $('#fechaHasta').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'dd/mm/yyyy',
        locale: 'es-es'
    });

    $('#fechaDesde').change(function() {
        if (comparaFechasdmY($('#fechaDesde').val(), $('#fechaHasta').val()) == true)
            $('#fechaHasta').val($('#fechaDesde').val());
    });

    $('#fechaHasta').change(function() {
        if (comparaFechasdmY($('#fechaDesde').val(), $('#fechaHasta').val()) == true)
            $('#fechaDesde').val($('#fechaHasta').val());
    });
</script>