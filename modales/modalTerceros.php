<?php
require_once 'includes/modelos/empresasModelo.php';
$oTercero = new empresasModel();
$rowsTerceros = $oTercero->listarTerceros($idUsuarioActivo);
$cantTerceros = $oTercero->cantidadEmpresas();
if ($cantTerceros > 0) //solo entramos si hay mas de un usuario. el activo y otro. El usuario activo no se muestra como empresa contratista
{
    if ($rowsTerceros[0]['idempresa'] == $idEmpresaActiva) //si el primer usuario de la lista es el usuario activo
    {
        if ($cantTerceros > 1) {
            $primerCuitTercero = $rowsTerceros[1]['cuit']; //seleccionamos el siguiente usuario
            $primerDireccionTercero = $rowsTerceros[1]['direccion'];
        }
    } else {
        $primerCuitTercero = $rowsTerceros[0]['cuit'];  //si el primer usuario no es el activo
        $primerDireccionTercero = $rowsTerceros[0]['direccion'];
    }
} else {
    $primerCuitTercero = "";
    $primerDireccionTercero = "";
}

?>
<!-- modal para agregar un personal a la base de datos y actualizar la lista -->
<div class="modal fade" id="modalContratistas" tabindex="-1" role="dialog" aria-labelledby="lbltitulo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbltitulo">Agregar Contratistas a la Lista</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmterceros">

                    <div class="form-group">
                        <label for="sltterceros" class="col-form-label">Contratista:</label>
                        <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalInsTercero" data-whatever="" id="btnAbrirNuevoTercero"><i class="material-icons">add_box</i></button>
                        <select name="sltterceros" id="sltterceros" class="form-control">
                            <?php
                            if ($cantTerceros > 0) {
                                foreach ($rowsTerceros as $rowTercero) {
                                    if ($idEmpresaActiva != $rowTercero['idempresa']) {  ?>
                                        <option value="<?php echo $rowTercero['idempresa']; ?>" <?php echo $rowTercero['idempresa'] == $idEmpresaActiva ? 'SELECTED' : '' ?>><?php echo $rowTercero['empresa']; ?></option>
                            <?php
                                    }
                                }
                            } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="txtCuitTercero" class="col-form-label">CUIT:</label>
                        <input type="text" class="form-control" id="txtCuitTercero" name="txtCuitTercero" value="<?php echo $primerCuitTercero; ?>">
                    </div>

                    <div class="form-group">
                        <label for="txtDireccionTercero" class="col-form-label">Direccion:</label>
                        <input type="text" class="form-control" id="txtDireccionTercero" name="txtDireccionTercero" value="<?php echo $primerDireccionTercero; ?>">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="btnAgregarTercero">Agregar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


<!-- modal para agregar un contratista a la base de datos y actualizar la lista -->
<div class="modal fade" id="modalInsTercero" tabindex="-1" role="dialog" aria-labelledby="lbltitulo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbltitulo">Agregar Contratistas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmAgregarTerceros">

                    <div class="form-group">
                        <label for="txtInsTercero" class="col-form-label">Contratista:</label>
                        <input type="text" class="form-control" id="txtInsTercero" name="txtInsTercero" value="">

                    </div>


                    <div class="form-group">
                        <label for="txtInsCuitTercero" class="col-form-label">CUIT:</label>
                        <input type="text" class="form-control" id="txtInsCuitTercero" name="txtInsCuitTercero" value="">
                    </div>

                    <div class="form-group">
                        <label for="txtInsDireccionTercero" class="col-form-label">Direccion:</label>
                        <input type="text" class="form-control" id="txtInsDireccionTercero" name="txtInsDireccionTercero" value="">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="btnInsertarTercero">Agregar</button>
                    </div>


                </form>
            </div>

        </div>
    </div>
</div>

<!-- modal para agregar un personal a la base de datos y actualizar la lista -->
<div class="modal fade" id="modalModificarTercero" tabindex="-1" role="dialog" aria-labelledby="lbltitulo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbltitulo">Modificar Contratistas en la Lista</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmterceros">
                    <div class="form-group">
                        <label for="txtModificarTercero" class="col-form-label">CUIT:</label>
                        <input type="text" disabled class="form-control" id="txtModificarTercero" name="txtModificarTercero" value="">
                    </div>

                    <div class="form-group">
                        <label for="txtModificarPrecioHaTercero" class="col-form-label">Direccion:</label>
                        <input type="text" class="form-control" id="txtModificarPrecioHaTercero" name="txtModificaPrecioHaTercero" value="<?php echo $primerDireccionTercero; ?>">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="btnModificarTercero">Agregar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>