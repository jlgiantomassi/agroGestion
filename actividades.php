<?php
$raiz = "";
require_once("includes/modelos/camposModelo.php");
require_once("includes/modelos/cultivosModelo.php");

$oCampos = new CamposModel();
$campos = $oCampos->listarCampos();
$oCultivos = new cultivosModel();
$cultivos = $oCultivos->listarCultivos();
?>

<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php include 'includes/header.php'; ?>
</head>

<body>
    <?php include 'includes/menu.php'; ?>

    <script src="./jquery/actividades.js?version=<?php echo rand(1, 10000); ?>"></script>
    <div class="container border bg-white">
        <div id="alerta"></div>
        <form id="formactividades">
            <!-- Campos y lotes-->
            <div>
                <div class="row">
                    <div class="shadow p-3 mb-3 bg-white rounded col-md-12 ">
                        <h5>Actividades</h5>
                    </div>
                </div>

                <div class="row mb-1">
                    <!-- Campos -->
                    <div class="form-group col-3 ">

                        <label for="sltcampos" class="col-form-label">Campo</label>
                        <button type="button" class="btn btn-sm p-0 m-0" data-toggle="modal" data-target="#modalInsertarCampo" data-whatever="" id="btnInsCampoModal"><i class="material-icons shadow">add_box</i></button>
                        <select class="form-control " name="sltcampos" id="sltcampos">
                            <option value="0"></option>
                            <?php foreach ($campos as $campo) { ?>
                                <option value="<?php echo $campo['idcampo']; ?>">
                                    <?php echo $campo['campo']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Lotes -->
                    <div class="form-group col-3 ">
                        <label for="sltlotes" class="col-form-label">Lote</label>
                        <button type="button" class="btn btn-sm p-0 m-0" data-toggle="modal" data-target="#modalInsertarLote" data-whatever="" id="btnInsLoteModal"><i class="material-icons shadow">add_box</i></button>
                        <select class="form-control " name="sltlotes" id="sltlotes">
                        </select>
                    </div>

                    <!-- cultivos -->
                    <div class="form-group col-2 ">
                        <label for="sltcultivos" class="col-form-label">Cultivo</label>
                        <select class="form-control " name="sltcultivos" id="sltcultivos">
                            <option value="0"></option>
                            <?php foreach ($cultivos as $cultivo) { ?>
                                <option value="<?php echo $cultivo['idcultivo']; ?>">
                                    <?php echo $cultivo['cultivo']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group col-2 ">
                        <label for="supLote" class="col-form-label">Superficie</label>
                        <input type="number" class="form-control " id="supLote" />
                    </div>

                </div>
            </div>

            <!-- Lista de actividades para el lote-->
            <fieldset class="border rounded mb-2 d-none" id="fldActividades">
                <div class="row  p-2">
                    <div class="col-8 pl-3 mr-0">
                        <div class="form-group mb-0 pl-2">
                            <strong><label for="" class="col-form-label">Lista de Actividades</label> </strong>
                            <button type="button" class="btn btn-sm " data-toggle="modal" data-target="#modalAgregarLabor" data-whatever="" id="btnLaborModal"><i class="material-icons shadow">add_box</i></button>
                        </div>
                        <div class="m-0 p-0">
                            <input type="hidden" name="idActividad" id="idActividad" value="0" />
                            <table class="table table-sm table-hover m-0 p-0" id="tblactividades">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="d-none"></th>
                                        <th>Fecha</th>
                                        <th>Actividades</th>
                                        <th class="text-right">Precio Ha</th>
                                        <th class="text-right">Superficie</th>
                                        <th class="text-right">Total</th>
                                        <th class='text-center'>Accion</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-4 p-0 d-none">
                        <div class="form-group mb-0 pl-3">
                            <strong><label for="" class="col-form-label">Asignacion de Productores</label> </strong>
                            <button type="button" class="btn btn-sm " data-toggle="modal" data-target="#modalProductor" data-whatever="" id="btnActProdModal"><i class="material-icons shadow">add_box</i></button>
                        </div>
                        <div class="">
                            <table class="table" id="tblproductores">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Productor</th>
                                        <th class="text-right">Participacion</th>
                                        <th class='text-center'>Accion</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </fieldset>

            <!-- Navegador de insumos, maquinarias, etc-->
            <div class="row d-none" id="navDatos">
                <div class="col">
                    <!-- encabezado del navegador-->
                    <nav class="">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-insumos-tab" data-toggle="tab" href="#nav-insumos" role="tab" aria-controls="nav-insumos" aria-selected="true">Insumos</a>
                            <a class="nav-item nav-link" id="nav-maquinarias-tab" data-toggle="tab" href="#nav-maquinarias" role="tab" aria-controls="nav-maquinarias" aria-selected="false">Maquinaria</a>
                            <a class="nav-item nav-link" id="nav-observaciones-tab" data-toggle="tab" href="#nav-observaciones" role="tab" aria-controls="nav-observaciones" aria-selected="false">Observaciones</a>
                            <a class="nav-item nav-link" id="nav-resumen-tab" data-toggle="tab" href="#nav-resumen" role="tab" aria-controls="nav-resumen" aria-selected="false">Resumen</a>
                        </div>
                    </nav>

                    <!-- navegador TAB-->
                    <div class="col-12">
                        <div class="tab-content" id="nav-tabContent">

                            <!-- Insumos-->
                            <div class="tab-pane show active fade ml-0" id="nav-insumos" role="tabpanel" aria-labelledby="nav-insumos-tab">
                                <div class="row  p-2">
                                    <div class="col-8 pl-0 mr-0">
                                        <div class="form-group mb-0 pl-4">
                                            <strong><label for="" class="col-form-label">Lista de Insumos</label></strong>
                                            <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalInsumo" data-whatever=""><i class="material-icons shadow">add_box</i></button>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <table class="table table-sm m-0 p-0 table-hover " id="tblinsumos">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th class="d-none">idActividadInsumo</th>
                                                            <th class="d-none">idInsumo</th>
                                                            <th>Insumo</th>
                                                            <th class="text-right">Precio unit</th>
                                                            <th class="text-right">Cant. Ha</th>
                                                            <th class="text-right">Cant. Total</th>
                                                            <th class="text-right">Importe Total</th>
                                                            <th class='text-center'>Accion</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-4 pl-0 mr-0 d-none">
                                        <div class="form-group mb-0 pl-4">
                                            <strong><label for="" class="col-form-label">Asignacion de Productores</label> </strong>
                                            <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalProductor" data-whatever="" id="btnInsProdModal"><i class="material-icons shadow">add_box</i></button>
                                        </div>
                                        <table class="table m-0 p-0 table-hover table-sm" id="tblproductores">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Productor</th>
                                                    <th class="text-right">Participacion</th>
                                                    <th class='text-center'>Accion</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- maquinaria-->
                            <div class="tab-pane fade ml-0" id="nav-maquinarias" role="tabpanel" aria-labelledby="nav-maquinarias-tab">
                                <div class="row p-0 ">
                                    <div class="col-8 pl-0 mr-0">
                                        <div class="form-group mb-0 pl-4">
                                            <strong><label for="" class="col-form-label">Asignacion de Maquinaria</label></strong>
                                            <div class="col-md-9" id="optMaquinarias">
                                                <div class="form-check form-check-inline ">
                                                    <input class="form-check-input rb " type="radio" id="maquinariaPropia" name="maquinaria" value="2">
                                                    <label class="form-check-label" for="maquinariaPropia">Propia</label>
                                                </div>
                                                <div class="form-check form-check-inline ">
                                                    <input class="form-check-input rb " type="radio" id="maquinariaContratada" name="maquinaria" value="1">
                                                    <label class="form-check-label" for="maquinariaContratada">Contratada</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--maquinaria Propia -->
                                <div class="row d-none" id="tblMaquinaria">
                                    <div class="col-6">
                                        <div class="form-group mb-0 pl-2">
                                            <strong><label for="" class="col-form-label">Lista de Personal asignado a la labor</label></strong>
                                            <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalPersonal" data-whatever=""><i class="material-icons">add_box</i></button>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <table class="table table-sm mb-2 p-0 table-hover " id="tblpersonales">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th class="d-none">idactividad_personal</th>
                                                            <th>Personal asignado</th>
                                                            <th class="text-right">Labor Precio/ha</th>
                                                            <th class="text-right">Total</th>
                                                            <th class='text-center'>Accion</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--maquinaria Contratada -->
                                <div class="row d-none" id="tblContratistas">
                                    <div class="col-6">
                                        <div class="form-group mb-0 pl-2">
                                            <strong><label for="" class="col-form-label">Lista de Contratistas asignado a la labor</label></strong>
                                            <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalContratistas" data-whatever=""><i class="material-icons">add_box</i></button>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <table class="table table-sm mb-2 p-0 table-hover " id="tblterceros">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th class="d-none">idactividad_tercero</th>
                                                            <th>Maquinaria Contratada</th>
                                                            <th class="text-right">Precio Ha</th>
                                                            <th class="text-right">Superficie</th>
                                                            <th class='text-center'>Accion</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Observaciones -->
                            <div class="tab-pane fade ml-2" id="nav-observaciones" role="tabpanel" aria-labelledby="nav-observaciones-tab">
                                <div class="row mt-2">
                                    <div class="col-md-5">
                                        <strong>Observaciones de la Actividad del Lote</strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-9">
                                        <textarea class="form-control mb-3" name="txtobservaciones" id="txtobservaciones"></textarea>
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-primary" id="btnObservaciones">Guardar</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Resumen de actividades-->
                            <div class="tab-pane fade ml-2" id="nav-resumen" role="tabpanel" aria-labelledby="nav-resumen-tab">
                                <div class="row mt-2" id="resumen">
                                    <h5 class="col-md-12">Resumen de la Actividad del Lote</h5>
                                    <div class="col-md-4">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>Superficie Total (has)</td>
                                                    <td id="tdSupTotal" class="text-right"></td>
                                                </tr>
                                                <tr>
                                                    <td>Total Labores (U$S)</td>
                                                    <td id="tdTotalLabores" class="text-right"></td>
                                                </tr>
                                                <tr>
                                                    <td>Total Insumos (U$S)</td>
                                                    <td id="tdTotalInsumos" class="text-right"></td>
                                                </tr>
                                                <tr>

                                                    <td><strong>Total (U$S)</strong></td>
                                                    <td class="text-right"><strong id="tdTotal"></strong></td>

                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" id="btnInformeCostos" class="btn btn-info form-control mt-2">Informe Costos</button>
                                        <button type="button" id="btnInformeDetallado" class="btn btn-info form-control mt-2">Informe Detallado</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php

    include 'includes/footer.php';
    include 'modales/modalCampos.php';
    include 'modales/modalInsumos.php';
    include 'modales/modalLabores.php';
    include 'modales/modalProductores.php';
    include 'modales/modalPersonal.php';
    include 'modales/modalTerceros.php';
    ?>
    <script>
        $('#fecha').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd/mm/yyyy',
            locale: 'es-es'

        });
    </script>
    <script>
        $('#txtFechaActividadModificar').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd/mm/yyyy',
            locale: 'es-es'

        });
    </script>

</body>

</html>