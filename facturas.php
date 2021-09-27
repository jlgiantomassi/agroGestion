<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php include 'includes/header.php'; ?>
    <title>AgroGestion</title>
</head>

<body>
    <?php
    include_once 'includes/menu.php';
    include_once "includes/modelos/facturasModelo.php";
    include_once "includes/modelos/empresasModelo.php";

    $oEmpresas = new empresasModel();
    $empresas = $oEmpresas->listarEmpresasRubros(0, 0, 1, 0, $idUsuarioActivo);

    if (isset($_POST["enviar"])) {
        $fechaDesde = $_POST["fechaDesde"];
        $fechaHasta = $_POST["fechaHasta"];
        $idempresa = $_POST["sltempresas"];
    } else {
        $fechaDesde = date("01/m/Y");
        $fechaHasta = date("d/m/Y");
        $idempresa = 0;
    }
    $oFacturas = new facturasModel();
    $facturas = $oFacturas->listarFacturas($fechaDesde, $fechaHasta, $idempresa, $idEmpresaActiva);
    
    ?>
    <div class="container border bg-white col-8">
        <div id="alerta"></div>
        <div id="formFacturas">
            <div class="row">
                <div class="shadow p-3 mb-3 bg-white rounded col-md-12 ">
                    <h5>Sistema de Facturacion</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-2 ml-4 mb-2">
                    <a href="facturaAgregar.php" class="btn btn-primary btn-sm" id="btnAgregarFactura">Agregar Factura</a>
                </div>
            </div>

            <form action="facturas.php" method="POST" class="p-2">
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
                        <label class="m-0 ml-2" for="sltEmpresa">Empresa</label>
                        <select class="form-control col-md-12" id="sltempresas" name="sltempresas">
                            <option value="0"></option>
                            <?php foreach ($empresas as $empresa) { ?>
                                <option value="<?php echo $empresa["idempresa"]; ?>" <?php echo $idempresa == $empresa["idempresa"] ? "selected" : ""; ?>><?php echo $empresa["empresa"]; ?></option>
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
                            <th class="d-none"></th>
                            <th>Fecha</th>
                            <th>Vencimiento</th>
                            <th>Empresas</th>
                            <th class="text-right">Importe</th>
                            <th class="text-right">IVA</th>
                            <th class="text-right">Total</th>
                            <th class="text-center">Acciones</th>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($facturas as $factura) { ?>
                                <tr>
                                    <td class="d-none"><?php echo $factura["idfactura"]; ?></td>
                                    <td><?php echo $factura["fecha"]; ?></td>
                                    <td><?php echo $factura["vencimiento"]; ?></td>
                                    <td><?php echo $factura["empresa"]; ?></td>
                                    <td class="text-right"><?php echo $factura["importe"]; ?></td>
                                    <td class="text-right"><?php echo $factura["iva"]; ?></td>
                                    <td class="text-right"><?php echo $factura["total"]; ?></td>
                                    <td class="text-center">
                                        <a href='facturaVer.php?idfactura=<?php echo $factura["idfactura"]; ?>' ><i class='material-icons'>info</i></a>
                                        <a href='facturaBorrar.php?idfactura=<?php echo $factura["idfactura"]; ?>'  onclick="return confirm('Desea Borrar esta factura?')"><i class='material-icons'>clear</i></a>
                                    </td>
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
        if (comparaFechasdmY($('#fechaDesde').val(),$('#fechaHasta').val())==true)
            $('#fechaHasta').val($('#fechaDesde').val());
    });

    $('#fechaHasta').change(function() {
        if (comparaFechasdmY( $('#fechaDesde').val() , $('#fechaHasta').val() )==true)
            $('#fechaDesde').val($('#fechaHasta').val());
    });
</script>