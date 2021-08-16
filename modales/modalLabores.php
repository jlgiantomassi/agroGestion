<?php
require_once("includes/modelos/laboresModelo.php");
$oLabores=new laboresModel();
$rowsLabores = $oLabores->listarLabores();
$cantLabores = $oLabores->cantidadLabores();
$primerPrecio = ($cantLabores > 0) ? $rowsLabores[0]['precio'] : "";
?>
<!-- modal para agregar una labor a la base de datos y actualizar la lista -->
<div class="modal fade" id="modalAgregarLabor" tabindex="-1" role="dialog" aria-labelledby="lbltitulo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbltitulo">Agregar Labores a la Lista</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>
            <div class="modal-body">
                <form id="frmlabores">
                    <div class="form-group">
                        <label for="txtFecha" class="col-form-label">Fecha:</label>
                        <input class="form-control col-md-3" type="text" value="<?php echo date('d/m/Y'); ?>" id="fecha" name="fecha">
                    </div>
                    <div class="form-group">
                        <label for="sltlabores" class="col-form-label">Labor:</label>
                        <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalLabor" data-whatever="" id="btnAbrirNuevaLabor"><i class="material-icons">add_box</i></button>
                        <select name="sltlabores" id="sltlabores" class="form-control">
                            <?php
                            if ($cantLabores > 0) {
                                foreach ($rowsLabores as $rowLabor) { ?>
                                    <option value="<?php echo $rowLabor['idlabor']; ?>" <?php echo $rowLabor['idlabor']; ?>><?php echo $rowLabor['labor']; ?></option>
                                <?php } 
                            } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="txtPrecio" class="col-form-label">Precio:</label>
                        <input type="number" class="form-control" id="txtPrecioLabor" name="txtPrecioLabor" value="<?php echo $primerPrecio; ?>">
                    </div>

                    <div class="form-group">
                        <label for="txtsupActividad" class="col-form-label">Superficie a aplicar:</label>
                        <input type="number" class="form-control" id="txtsupActividad" name="txtsupActividad" >
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="btnAgregarLabor">Agregar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>




<!-- modal para agregar una labor a la base de datos y actualizar la lista -->
<div class="modal fade" id="modalLabor" tabindex="-1" role="dialog" aria-labelledby="lbltitulo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbltitulo">Agregar Labores</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>
            <div class="modal-body">
                <form id="frmAgregarLabor">

                    <div class="form-group">
                        <label for="txtInsLabor" class="col-form-label">Labor:</label>
                        <input type="number" class="form-control" id="txtInsLabor" name="txtInsLabor" value="">

                    </div>


                    <div class="form-group">
                        <label for="txtInsPrecioLabor" class="col-form-label">Precio /Ha:</label>
                        <input type="number" class="form-control" id="txtInsPrecioLabor" name="txtInsPrecioLabor" value="">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnInsertarLabor">Agregar</button>
            </div>
        </div>
    </div>
</div>

<!-- modal para modificar una labor en la base de datos y actualizar la lista de actividades-->
<div class="modal fade" id="modalModificarLabor" tabindex="-1" role="dialog" aria-labelledby="lbltitulo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbltitulo">Modificar Labores en la Lista</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>
            <div class="modal-body">
                <form id="frmlabores">
                    <div class="form-group">
                        <label for="txtFechaActividadModificar" class="col-form-label">Fecha:</label>
                        <input class="form-control col-md-3" type="text" value="" id="txtFechaActividadModificar" name="txtFechaActividadModificar">
                    </div>
                    <div class="form-group">
                        <label for="txtActividadModificar" class="col-form-label">Labor:</label>
                        <input type="text" disabled class="form-control" id="txtActividadModificar" name="txtActividadModificar" value="">
                    </div>

                    <div class="form-group">
                        <label for="txtPrecioActividadModificar" class="col-form-label">Precio:</label>
                        <input type="text" class="form-control" id="txtPrecioActividadModificar" name="txtPrecioActividadModificar" value="">
                    </div>

                    <div class="form-group">
                        <label for="txtSupActividadModificar" class="col-form-label">Superficie a aplicar:</label>
                        <input type="text" class="form-control" id="txtSupActividadModificar" name="txtSupActividadModificar" >
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="btnModificarActividad">Modificar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>