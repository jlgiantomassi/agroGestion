<?php
    require_once("includes/modelos/personalesModelo.php");
    $oPersonales=new personalesModel();
    $rowsPersonales = $oPersonales->listarPersonales();
    $cantPersonales = $oPersonales->cantidadPersonales();
    $primerPrecioHa = ($cantPersonales > 0) ? $rowsPersonales[0]['precioHa'] : "";
    $primerCuil = ($cantPersonales > 0) ? $rowsPersonales[0]['cuil'] : "";
?>
<!-- modal para agregar un personal a la base de datos y actualizar la lista -->
<div class="modal fade" id="modalPersonal" tabindex="-1" role="dialog" aria-labelledby="lbltitulo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbltitulo">Agregar Personal a la Lista</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>
            <div class="modal-body">
                <form id="frmpersonales">

                    <div class="form-group">
                        <label for="sltpersonales" class="col-form-label">Personal:</label>
                        <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalInsPersonal" data-whatever="" id="btnAbrirNuevoPersonal"><i class="material-icons">add_box</i></button>
                        <select name="sltpersonales" id="sltpersonales" class="form-control">
                            <?php
                            if ($cantPersonales > 0) {
                                foreach ($rowsPersonales as $rowPersonal) {    ?>
                                    <option value="<?php echo $rowPersonal['idpersonal']; ?>"><?php echo $rowPersonal['personal']; ?></option>
                                <?php } 
                            } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="txtCuil" class="col-form-label">CUIL:</label>
                        <input type="text" class="form-control" id="txtCuil" name="txtCuil" value="<?php echo $primerCuil; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="txtPrecioHa" class="col-form-label">Precio por Ha:</label>
                        <input type="text" class="form-control" id="txtPrecioHa" name="txtPrecioHa" value="<?php echo $primerPrecioHa; ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="btnAgregarPersonal" >Agregar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


<!-- modal para agregar un personal a la base de datos y actualizar la lista -->
<div class="modal fade" id="modalInsPersonal" tabindex="-1" role="dialog" aria-labelledby="lbltitulo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbltitulo">Agregar Personales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>
            <div class="modal-body">
                <form id="frmAgregarPersonal" >

                    <div class="form-group">
                        <label for="txtInsPersonal" class="col-form-label">Personal:</label>
                        <input type="text" class="form-control" id="txtInsPersonal" name="txtInsPersonal" value="">

                    </div>


                    <div class="form-group">
                        <label for="txtInsCuil" class="col-form-label">CUIL:</label>
                        <input type="text" class="form-control" id="txtInsCuil" name="txtInsCuil" value="">
                    </div>
                    
                    <div class="form-group">
                        <label for="txtPrecioHa" class="col-form-label">precio Ha:</label>
                        <input type="text" class="form-control" id="txtInsPrecioHa" name="txtPrecioHa" value="">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="btnInsertarPersonal">Agregar</button>
                    </div>


                </form>
            </div>

        </div>
    </div>
</div>

<!-- modal para modificar los datos de un personal en la lista -->
<div class="modal fade" id="modalModificarPersonal" tabindex="-1" role="dialog" aria-labelledby="lbltitulo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbltitulo">Modificar Datos de Personal en la Lista</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>
            <div class="modal-body">
                <form id="frmpersonales">

                    <div class="form-group">
                        <label for="txtPersonal" class="col-form-label">Personal:</label>
                        <input type="text" disabled class="form-control" id="txtPersonal" name="txtPersonal" value="">
                    </div>

                    <div class="form-group">
                        <label for="txtPrecioHa" class="col-form-label">Precio por Ha:</label>
                        <input type="text" class="form-control" id="txtModificarPrecioHaPersonal" name="txtModificarPrecioHaPersonal" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="btnModificarPersonal" >Agregar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>