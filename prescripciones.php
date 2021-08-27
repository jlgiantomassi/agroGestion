<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include 'includes/header.php'; ?>
    </head>
    <body>
        <?php include 'includes/menu.php'; ?>
        <script src="jquery/prescripciones.js?version=<?php echo rand(1, 10000); ?>" type="text/javascript"></script>
        <?php
        $raiz="";
        include_once("includes/modelos/laboresModelo.php");
        include_once("includes/modelos/ordenesModelo.php");
        
        //sacaremos el ultimo trabajo realizado para seguir cargando los mismos trabajos
        $oOrdenes=new ordenesModel();
        $ultimoIdLabor=$oOrdenes->idLaborUltimaOrden($idUsuarioActivo);
        
        $oLabor=new laboresModel();
        $rowsLabores = $oLabor->listarLabores($idUsuarioActivo);
        $precio=$rowsLabores[0]["precio"];
        
        ?>
        <div class="container border bg-white">
            <div id="alerta"></div>
            <form id="formprescripciones">
                <div class="row">
                    <div class="shadow p-3 mb-3 bg-white rounded col-md-12 ">
                        <h5>Agregar Ordenes de Trabajo</h5>
                    </div>
                </div>

                <div class="row"> 
                    <div class="form-group col-md-12">
                        <label for="fecha">Fecha</label>
                        <input class="form-control col-md-2" type="text" value="<?php echo date('d/m/Y'); ?>" id="fecha" name="fecha">
                    </div>
                </div>


                <div class="row mb-3">
                    <div class="form-group col-md-4 ">
                        <label for="sltlabores" class="col-md-5">Tipo de Labor</label>
                        <button type="button" class="btn btn-sm p-0 m-0" data-toggle="modal" data-target="#modalLabor" data-whatever="" id="btnAbrirNuevoLabor"><i class="material-icons">add_box</i></button>
                        <select class="form-control " name="sltlabores" id="sltlabores">
                            <?php
                            foreach ($rowsLabores as $rowLabor) {
                                ?>
                                <option value="<?php echo $rowLabor['idlabor']; ?>" 
                                    <?php if($rowLabor['idlabor']==$ultimoIdLabor) 
                                        {   
                                            echo 'SELECTED'; 
                                            $precio=$rowLabor['precio']; 
                                        }?> 
                                    data-foo="<?php echo $rowLabor['precio']; ?>">
                                    <?php echo $rowLabor['labor']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group col-md-1">
                        <label for="txtPrecioLabor" >Precio/ha</label>
                        <input type="text" id="txtPrecioLabor" name="txtPrecioLabor" class="form-control" value="<?php echo $precio; ?>">  
                    </div>      
                </div>


                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-productores-tab" data-toggle="tab" href="#nav-productores" role="tab" aria-controls="nav-productores" aria-selected="true">Productores</a>
                        <a class="nav-item nav-link" id="nav-campos-tab" data-toggle="tab" href="#nav-campos" role="tab" aria-controls="nav-campos" aria-selected="false">Campos</a>
                        <a class="nav-item nav-link" id="nav-insumos-tab" data-toggle="tab" href="#nav-insumos" role="tab" aria-controls="nav-insumos" aria-selected="false">Insumos</a>
                        <a class="nav-item nav-link" id="nav-maquinarias-tab" data-toggle="tab" href="#nav-maquinarias" role="tab" aria-controls="nav-maquinarias" aria-selected="false">Maquinaria</a>
                        <a class="nav-item nav-link" id="nav-observaciones-tab" data-toggle="tab" href="#nav-observaciones" role="tab" aria-controls="nav-observaciones" aria-selected="false">Observaciones</a>
                        <a class="nav-item nav-link" id="nav-resumen-tab" data-toggle="tab" href="#nav-resumen" role="tab" aria-controls="nav-resumen" aria-selected="false">Resumen</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">

                    <div class="tab-pane fade show active ml-2" id="nav-productores" role="tabpanel" aria-labelledby="nav-productores-tab">
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <strong>Lista de Productores</strong>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalProductor" data-whatever="" ><i class="material-icons">add_box</i></button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
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

                    <div class="tab-pane fade ml-2" id="nav-campos" role="tabpanel" aria-labelledby="nav-campos-tab">
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <strong>Lista de Campos/Lotes</strong>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalCampo" data-whatever=""><i class="material-icons">add_box</i></button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <table class="table" id="tblcampos">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="d-none" data-visible="false">idlote</th>
                                            <th>Campo</th>
                                            <th>Lote</th>
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

                    <div class="tab-pane fade ml-2" id="nav-insumos" role="tabpanel" aria-labelledby="nav-insumos-tab">
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <strong>Lista de Insumos</strong>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalInsumo" data-whatever=""><i class="material-icons">add_box</i></button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <table class="table" id="tblinsumos">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Insumo</th>
                                            <th class="text-right">Cant/ha</th>
                                            <th class="text-right">Precio unit.</th>
                                            <th class="text-right">Total/ha</th>
                                            <th class='text-center'>Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <div class="tab-pane fade ml-2" id="nav-maquinarias" role="tabpanel" aria-labelledby="nav-maquinarias-tab">
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <strong>Asignacion de Maquinaria</strong>
                            </div>
                        </div>
                        <div class="row m-2" >
                            <div class="col-md-9" id="optMaquinarias" >
                                <div class="form-check form-check-inline ">
                                    <input class="form-check-input rb "  type="radio" id="maquinariaPropia" name="maquinaria" value="maquinariaPropia" disabled>
                                        <label class="form-check-label" for="maquinariaPropia">Propia</label>
                                </div>
                                <div class="form-check form-check-inline ">
                                    <input class="form-check-input rb "  type="radio" id="maquinariaContratada" name="maquinaria" value="maquinariaContratada" disabled>
                                        <label class="form-check-label" for="maquinariaContratada">Contratada</label>
                                </div>
                            </div>
                        </div>

                        <div class="row d-none" id="tblMaquinaria">
                            <div class="col-md-4">
                                <strong>Lista de Personal asignado a la labor</strong>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalPersonal" data-whatever=""><i class="material-icons">add_box</i></button>
                            </div>
                            <div class="col-md-9">
                                <table class="table" id="tblpersonales">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Personal asignado</th>
                                            <th class="text-right">Labor Precio/ha</th>
                                            <th class='text-center'>Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row  d-none" id="tblContratistas">
                            <div class="col-md-4">
                                <strong>Lista de Contratistas asignado a la labor</strong>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalContratistas" data-whatever=""><i class="material-icons">add_box</i></button>
                            </div>
                            <div class="col-md-9">
                                <table class="table" id="tblterceros" >
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Maquinaria Contratada</th>
                                            <th class="text-right">Precio Ha</th>
                                            <th class="text-right d-none">Superficie</th>
                                            <th class='text-center'>Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane fade ml-2" id="nav-observaciones" role="tabpanel" aria-labelledby="nav-observaciones-tab">
                        <div class="row mt-2">
                            <div class="col-md-5">
                                <strong>Observaciones de la Orden de Trabajo</strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <textarea class="form-control mb-3" name="txtobservaciones" id="txtobservaciones"></textarea>
                            </div>
                        </div>
                    </div>


                    <div class="tab-pane fade ml-2" id="nav-resumen" role="tabpanel" aria-labelledby="nav-resumen-tab">
                        <div class="row mt-2" id="resumenMensaje">
                            <strong>Debe tener asignado al menos un lote y una participacion del 100% de productores para activar el resumen y poder guardar
                                la orden de trabajo</strong>
                        </div>
                        <div class="row mt-2" id="resumen" >
                            <h5 class="col-md-12">Resumen Orden de Trabajo</h5>
                            <div class="col-md-4">
                                <table class="table" >
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
                                            <td class="text-right"><strong id="tdTotal" ></strong></td>

                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                            <div class="col-md-3">
                                <button type="button" id="btnGuardarOrden" class="btn btn-primary form-control">Guardar Orden de Trabajo</button>
                                <button type="button" id="btnOrdenTrabajo" class="btn btn-primary form-control d-none" >Orden de Trabajo</button>
                                <button type="button" id="btnInformeProductor" class="btn btn-info form-control mt-2 d-none">Informe Productor</button>
                                <button type="button" id="btnLimpiarOrden" class="btn btn-light form-control mt-2 d-none">Limpiar Orden</button>
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

    </body>
</html>