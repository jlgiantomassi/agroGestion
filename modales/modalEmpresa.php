<?php
require_once $raiz . 'includes/modelos/empresasModelo.php';
$oEmpresa = new empresasModel();
$empresas = $oEmpresa->listarEmpresas($idUsuarioActivo);
$cantEmpresas = $oEmpresa->cantidadEmpresas();
$rowEmpresaActiva = $oEmpresa->empresaById($idEmpresaActiva);
if ($cantEmpresas > 0) {
    $primerCuit = $rowEmpresaActiva[0]['cuit'];
    $primerDireccion = $rowEmpresaActiva[0]['direccion'];
}
?>
<!-- modal para agregar un Productor a la base de datos y actualizar la lista -->
<div class="modal fade" id="modalEmpresa" tabindex="-1" role="dialog" aria-labelledby="lbltitulo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbltitulo">Agregar Empresas a la Lista</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmempesas">

                    <div class="form-group">
                        <label for="sltempresas" class="col-form-label">Empresa:</label>
                        <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalInsEmpresa" data-whatever="" id="btnAbrirNuevaEmpresa"><i class="material-icons">add_box</i></button>
                        <select name="sltempresas" id="sltempresas" class="form-control">
                            <?php
                            if ($cantEmpresas > 0) {
                                foreach ($empresas as $empresa) { ?>
                                    <option value="<?php echo $empresa['idempresa']; ?>" <?php echo $empresa['idempresa'] == $idEmpresaActiva ? 'SELECTED' : '' ?>><?php echo $empresa['empresa']; ?></option>
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
<div class="modal fade" id="modalInsEmpresa" tabindex="-1" role="dialog" aria-labelledby="lbltitulo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbltitulo">Agregar Empresas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmAgregarEmpresa">

                    <div class="form-group">
                        <label for="txtInsEmpresa" class="col-form-label">Empresa:</label>
                        <input type="text" class="form-control" id="txtInsEmpresa" name="txtInsEmpresa" value="">
                    </div>

                    <div class="form-group">
                        <label for="txtInsCuitEmpresa" class="col-form-label">CUIT:</label>
                        <input type="text" class="form-control" id="txtInsCuitEmpresa" name="txtInsCuitEmpresa" value="">
                    </div>

                    <div class="form-group">
                        <label for="txtInsDireccionEmpresa" class="col-form-label">Direccion:</label>
                        <input type="text" class="form-control" id="txtInsDireccionEmpresa" name="txtInsDireccionEmpresa" value="">
                    </div>
                    <div class="col align-self-center mb-2">
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" id="chkproductor" name="chkproductor" value="productor">
                            <label class="form-check-label" for="chkproductor">Productor</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" id="chkcontratista" name="chkcontratista" value="contratista">
                            <label class="form-check-label" for="chkcontratista">Contratista</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" id="chkproveedor" name="chkproveedor" value="proveedor">
                            <label class="form-check-label" for="chkproveedor">Proveedor</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" id="chkotro" name="chkotro" value="otro">
                            <label class="form-check-label" for="chkotro">Otro</label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="btnInsertarEmpresa">Agregar</button>
                    </div>


                </form>
            </div>

        </div>
    </div>
</div>

<!-- modal para agregar una labor a la base de datos y actualizar la lista -->
<div class="modal fade" id="modalModificarEmpresa" tabindex="-1" role="dialog" aria-labelledby="lbltitulo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbltitulo">Modificar Empresas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmModificarEmpresa">

                    <div class="form-group">
                        <label for="txtModificarEmpresa" class="col-form-label">Empresa:</label>
                        <input type="text" class="form-control" id="txtModificarEmpresa" name="txtModificarEmpresa" value="">
                    </div>

                    <div class="form-group">
                        <label for="txtModificarCuitEmpresa" class="col-form-label">CUIT:</label>
                        <input type="text" class="form-control" id="txtModificarCuitEmpresa" name="txtModificarCuitEmpresa" value="">
                    </div>

                    <div class="form-group">
                        <label for="txtModificarDireccionEmpresa" class="col-form-label">Direccion:</label>
                        <input type="text" class="form-control" id="txtModificarDireccionEmpresa" name="txtModificarDireccionEmpresa" value="">
                    </div>
                    <div class="col align-self-center mb-2">
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" id="chkModificarproductor" name="chkModificarproductor" value="productor">
                            <label class="form-check-label" for="chkproductor">Productor</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" id="chkModificarcontratista" name="chkModificarcontratista" value="contratista">
                            <label class="form-check-label" for="chkcontratista">Contratista</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" id="chkModificarproveedor" name="chkModificarproveedor" value="proveedor">
                            <label class="form-check-label" for="chkproveedor">Proveedor</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" id="chkModificarotro" name="chkModificarotro" value="otro">
                            <label class="form-check-label" for="chkotro">Otro</label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="btnModificarEmpresa">Modificar</button>
                    </div>


                </form>
            </div>

        </div>
    </div>
</div>