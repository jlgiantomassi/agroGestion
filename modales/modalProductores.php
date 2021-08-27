<?php
    require_once $raiz.'includes/modelos/empresasModelo.php';
    $oProductor=new empresasModel();
    $rowsProductores = $oProductor->listarProductores($idUsuarioActivo);
    $cantProductores = $oProductor->cantidadEmpresas();
    $rowProdActivo=$oProductor->empresaById($idEmpresaActiva);
    if($cantProductores>0)
    {
        $primerCuit = $rowProdActivo[0]['cuit'];
        $primerDireccion = $rowProdActivo[0]['direccion'];
    }else{
        $primerCuit = "";
        $primerDireccion ="";
    }
?>
<!-- modal para agregar un Productor a la base de datos y actualizar la lista -->
<div class="modal fade" id="modalProductor" tabindex="-1" role="dialog" aria-labelledby="lbltitulo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbltitulo">Agregar Productores a la Orden</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>
            <div class="modal-body">
                <form id="frmproductores">

                    <div class="form-group">
                        <label for="sltproductores" class="col-form-label">Productor:</label>
                        <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalInsProductor" data-whatever="" id="btnAbrirNuevoProductor"><i class="material-icons">add_box</i></button>
                        <select name="sltproductores" id="sltproductores" class="form-control">
                            <?php
                            if ($cantProductores > 0) {
                                foreach ($rowsProductores as $rowProductor) { ?>
                                    <option value="<?php echo $rowProductor['idempresa']; ?>" <?php echo $rowProductor['idempresa']==$idEmpresaActiva?'SELECTED':'' ?>><?php echo $rowProductor['empresa']; ?></option>
                                    <?php
                                } 
                            } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="txtCuit" class="col-form-label">CUIT:</label>
                        <input type="text" class="form-control" id="txtCuit" name="txtCuit" value="<?php echo $primerCuit; ?>">
                    </div>

                    <div class="form-group">
                        <label for="txtDireccion" class="col-form-label">Direccion:</label>
                        <input type="text" class="form-control" id="txtDireccion" name="txtDireccion" value="<?php echo $primerDireccion; ?>">
                    </div>

                    <div class="form-group">
                        <label for="txtParticipacion" class="col-form-label">Porcentaje participacion:</label>
                        <input type="text" class="form-control" id="txtParticipacion" name="txtParticipacion" value="100">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="btnAgregarProductor">Agregar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


<!-- modal para agregar una labor a la base de datos y actualizar la lista -->
<div class="modal fade" id="modalInsProductor" tabindex="-1" role="dialog" aria-labelledby="lbltitulo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbltitulo">Agregar Productores</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>
            <div class="modal-body">
                <form id="frmAgregarProductor" >

                    <div class="form-group">
                        <label for="txtInsProductor" class="col-form-label">Productor:</label>
                        <input type="text" class="form-control" id="txtInsProductor" name="txtInsProductor" value="">

                    </div>


                    <div class="form-group">
                        <label for="txtInsCuit" class="col-form-label">CUIT:</label>
                        <input type="text" class="form-control" id="txtInsCuit" name="txtInsCuit" value="">
                    </div>

                    <div class="form-group">
                        <label for="txtInsDireccion" class="col-form-label">Direccion:</label>
                        <input type="text" class="form-control" id="txtInsDireccion" name="txtInsDireccion" value="">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="btnInsertarProductor">Agregar</button>
                    </div>


                </form>
            </div>

        </div>
    </div>
</div>