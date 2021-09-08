<?php
require_once("includes/modelos/insumosModelo.php");
require_once("includes/modelos/unidadesModelo.php");
$oInsumos=new insumosModel();
$rowsInsumos = $oInsumos->listarInsumos($idUsuarioActivo);
$cantInsumos = $oInsumos->cantidadInsumos();
$primerPrecio = ($cantInsumos > 0) ? $rowsInsumos[0]['precio'] : 0;
$primerUnidad = ($cantInsumos > 0) ? $rowsInsumos[0]['unidad'] : 0;

$oUnidades=new unidadesModel();
$rowsUnidades = $oUnidades->listarUnidades();
$cantUnidad = $oUnidades->cantidadUnidades();
?>

<!-- modal para agregar un insumo en la lista -->
<div class="modal fade" id="modalInsumo" tabindex="-1" role="dialog" aria-labelledby="lbltitulo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbltitulo">Agregar Insumos a la Orden</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> </div>
            <div class="modal-body">
                <form id="frmInsertarInsumo">
                    
                    <div class="form-group">
                        <label for="sltinsumos" class="col-form-label">Insumo:</label>
                        <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalInsertarInsumo" data-whatever="" id="btnModalInsertarInsumo"><i class="material-icons">add_box</i></button>
                        <select id="sltinsumos" name="sltinsumos" class="form-control">
                            <?php
                            if ($cantInsumos > 0) {
                                foreach ($rowsInsumos as $rowInsumo) {  ?>
                                    <option value="<?php echo $rowInsumo['idinsumo']; ?>"><?php echo $rowInsumo['insumo']; ?></option>
                                    <?php
                                } 
                            } ?>
                        </select>

                    </div>

                    <div class="form-group">
                        <label for="txtprecio" class="col-form-label">Precio (Unidad):</label>
                        <input type="number" class="form-control" id="txtprecio" name="txtprecio" value="<?php echo $primerPrecio; ?>">

                    </div>

                    <div class="form-group">
                        <label for="txtcantidadInsumo" class="col-form-label">Cantidad/Ha:</label>
                        <input type="number" class="form-control" id="txtcantidadInsumo" name="txtcantidadInsumo" value="">

                    </div>

                    <div class="form-group">
                        <label for="txtunidad" class="col-form-label">Unidad:</label>
                        <input type="text" class="form-control " disabled id="txtunidad" name="txtunidad" value="<?php echo $primerUnidad; ?>">

                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnAgregarInsumo">Agregar</button>
            </div>
        </div>
    </div>
</div>


<!-- modal para insertar un nuevo insumo en la base de datos y en la lista -->
<div class="modal fade" id="modalInsertarInsumo" tabindex="-1" role="dialog" aria-labelledby="lbltitulo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbltitulo">Agregar Insumos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> </div>
            <div class="modal-body">
                <form id="frmAgregarInsumo">
                    <div class="form-row">
                        <div class="form-group col-md-9">
                            <label for="txtInsInsumo" class="col-form-label">Insumo:</label>
                            <input type="text" class="form-control" id="txtInsInsumo" name="txtInsInsumo" value="">
                        </div>


                    </div>
                    <div class="form-group">
                        <label for="txtInsPrecio" class="col-form-label">Precio (Unidad):</label>
                        <input type="text" class="form-control" id="txtInsPrecio" name="txtInsPrecio" value="">

                    </div>

                    <!-- <div class="form-group">
                        <label for="txtInsCantidadInsumo" class="col-form-label">Cantidad/Ha:</label>
                        <input type="text" class="form-control" id="txtInsCantidadInsumo" name="txtInsCantidadInsumo" value="">

                    </div> -->

                    <div class="form-group">
                        <label for="sltunidad" class="col-form-label">Unidad:</label>
                        <select id="sltunidad" name="sltunidad" class="form-control">
                            <?php
                            if ($cantUnidad > 0) {
                                foreach ($rowsUnidades as $rowUnidad) { ?>
                                    <option value="<?php echo $rowUnidad['idunidad']; ?>"><?php echo $rowUnidad['unidad']; ?></option>
                                    <?php
                                } 
                            } ?>
                        </select>

                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnInsertarInsumo">Agregar</button>
            </div>
        </div>
    </div>
</div>

<!-- modal para modificar un insumo en la base de datos  -->
<div class="modal fade" id="modalModificarInsumo" tabindex="-1" role="dialog" aria-labelledby="lbltitulo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbltitulo">Modificar Insumo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> </div>
            <div class="modal-body">
                <form id="frmModificarInsumo">
                    <div class="form-row">
                        <div class="form-group col-md-9">
                            <label for="txtModificarInsumo" class="col-form-label">Insumo:</label>
                            <input type="text" class="form-control" id="txtModificarInsumo" name="txtModificarInsumo" value="">
                        </div>


                    </div>
                    <div class="form-group">
                        <label for="txtModificarPrecio" class="col-form-label">Precio (Unidad):</label>
                        <input type="text" class="form-control" id="txtModificarPrecio" name="txtModificarPrecio" value="">

                    </div>

                    <!-- <div class="form-group">
                        <label for="txtInsCantidadInsumo" class="col-form-label">Cantidad/Ha:</label>
                        <input type="text" class="form-control" id="txtInsCantidadInsumo" name="txtInsCantidadInsumo" value="">

                    </div> -->

                    <div class="form-group">
                        <label for="sltModifcarUnidad" class="col-form-label">Unidad:</label>
                        <select id="sltModifcarUnidad" name="sltModifcarUnidad" class="form-control">
                            <?php
                            if ($cantUnidad > 0) {
                                foreach ($rowsUnidades as $rowUnidad) { ?>
                                    <option value="<?php echo $rowUnidad['idunidad']; ?>"><?php echo $rowUnidad['unidad']; ?></option>
                                    <?php
                                } 
                            } ?>
                        </select>

                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnModificarInsumo">Modificar</button>
            </div>
        </div>
    </div>
</div>


<!-- modificar un insumo en la lista de actividades -->
<div class="modal fade" id="modalInsumoActividad" tabindex="-1" role="dialog" aria-labelledby="lbltitulo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbltitulo">Modificar Insumos en la actividad</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> </div>
            <div class="modal-body">
                <form id="frmInsertarInsumo">
                    
                    <div class="form-group">
                        <label for="txtinsumoactividad" class="col-form-label">Insumo:</label>
                        <input type="text" disabled class="form-control" id="txtinsumoactividad" name="txtinsumoactividad" value="">
                    </div>

                    <div class="form-group">
                        <label for="txtprecioInsumoActividad" class="col-form-label">Precio (Unidad):</label>
                        <input type="number" class="form-control" id="txtprecioInsumoActividad" name="txtprecioInsumoActividad" value="">
                    </div>

                    <div class="form-group">
                        <label for="txtcantidadInsumoActividad" class="col-form-label">Cantidad/Ha:</label>
                        <input type="number" class="form-control" id="txtcantidadInsumoActividad" name="txtcantidadInsumoActividad" value="">
                    </div>

                    <div class="form-group">
                        <label for="txtcantidadInsumoTotal" class="col-form-label">Cantidad Total</label>
                        <input type="number" class="form-control" id="txtcantidadInsumoTotal" name="txtcantidadInsumoTotal" value="">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnModificarInsumoActividad">Modificar</button>
            </div>
        </div>
    </div>
</div>