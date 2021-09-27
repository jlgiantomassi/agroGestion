<?php
require_once("includes/modelos/CamposModelo.php");
$oCampos=new camposModel();
$campos=$oCampos->listarCampos($idUsuarioActivo);
$cantCampos=$oCampos->cantidadCampos();

if($cantCampos>0)
{
    $idPrimerCampo=$campos[0]["idcampo"];
    $lotes=$oCampos->listarLotes($idPrimerCampo);
    $cantLotes=$oCampos->cantidadLotes();
    
    $primerSuperficie=$cantLotes==0?"":$lotes[0]["superficie"];
}


?>
<div class="modal fade" id="modalCampo" tabindex="-1" role="dialog" aria-labelledby="lbltitulo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbltitulo">Agregar Campos a la Lista</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> </div>
            <div class="modal-body">
                <form>

                    <div class="form-group">
                        <label for="sltcampos" class="col-form-label">Campo:</label>
                        <button type="button" class="btn btn-sm p-0 m-0" data-toggle="modal" data-target="#modalInsertarCampo" data-whatever="" id="btnInsCampoModal"><i class="material-icons">add_box</i></button>
                        <select id="sltcampos" name="sltcampos" class="form-control">
                            <?php
                            if ($cantCampos > 0) {
                                foreach ($campos as $campo)
                                {
                                    ?>
                                    <option value="<?php echo $campo['idcampo']; ?>"><?php echo $campo['campo']; ?></option>
                                    <?php
                                } 
                            }
                            ?>
                        </select>


                    </div>

                    <div class="form-group">
                        <label for="sltlotes" class="col-form-label">Lote:</label>
                        <button type="button" class="btn btn-sm p-0 m-0" data-toggle="modal" data-target="#modalInsertarLote" data-whatever="" id="btnInsLoteModal"><i class="material-icons">add_box</i></button>
                        <select id="sltlotes" name="sltlotes" class="form-control">
                            <?php
                            if ($cantLotes > 0) {
                                foreach($lotes as $lote) 
                                {
                                    ?>
                                    <option value="<?php echo $lote['idlote']; ?>"><?php echo $lote['lote']; ?></option>
                                    <?php
                                } 
                            }
                            ?>

                        </select>

                    </div>

                    <div class="form-group">
                        <label for="txtsuperficie" class="col-form-label">Superficie:</label>
                        <input type="number" class="form-control" id="txtsuperficie" name="txtsuperficie" value="<?php echo $primerSuperficie; ?>">

                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnAgregarCampo">Agregar</button>
            </div>
        </div>
    </div>
</div>



<!-- modal para insertar un nuevo lote en la base de datos y en el select del campo -->
<div class="modal fade" id="modalInsertarLote" tabindex="-1" role="dialog" aria-labelledby="lbltitulo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbltitulo">Agregar Lote a <span class="nombreCampo"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> </div>
            <div class="modal-body">
                <form id="frmAgregarLote">
                    <div class="form-group">
                        <label for="txtInsLote" class="col-form-label">Lote:</label>
                        <input type="text" class="form-control" id="txtInsLote" name="txtInsLote" value="">
                    </div>

                    <div class="form-group">
                        <label for="txtInsSupLote" class="col-form-label">Superficie Lote:</label>
                        <input type="number" class="form-control" id="txtInsSupLote" name="txtInsSupLote" value="">

                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnInsertarLote">Agregar</button>
            </div>
        </div>
    </div>
</div>

<!-- modal para modificar un lote en la base de datos y en el select del campo -->
<div class="modal fade" id="modalModificarLote" tabindex="-1" role="dialog" aria-labelledby="lbltitulo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbltitulo">Modificar Lote <span class="nombreCampo"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> </div>
            <div class="modal-body">
                <form id="frmModificarLote">
                    <div class="form-group">
                        <label for="txtModificarLote" class="col-form-label">Lote:</label>
                        <input type="text" class="form-control" id="txtModificarLote" name="txtModificarLote" value="">
                    </div>

                    <div class="form-group">
                        <label for="txtModificarSupLote" class="col-form-label">Superficie Lote:</label>
                        <input type="number" class="form-control" id="txtModificarSupLote" name="txtModificarSupLote" value="">

                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnModificarLote">Modificar</button>
            </div>
        </div>
    </div>
</div>


<!-- modal para insertar un nuevo campo en la base de datos y en el select del campo -->
<div class="modal fade" id="modalInsertarCampo" tabindex="-1" role="dialog" aria-labelledby="lbltitulo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbltitulo">Agregar nuevo Campo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> </div>
            <div class="modal-body">
                <form id="frmAgregarCampo">
                    <div class="form-group">
                        <label for="txtInsCampo" class="col-form-label">Campo:</label>
                        <input type="text" class="form-control" id="txtInsCampo" name="txtInsCampo" value="">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnInsertarCampo">Agregar</button>
            </div>
        </div>
    </div>
</div>

<!-- modal para modificar un nuevo campo en la base de datos y en el select del campo -->
<div class="modal fade" id="modalModificarCampo" tabindex="-1" role="dialog" aria-labelledby="lbltitulo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbltitulo">Modificar Campo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> </div>
            <div class="modal-body">
                <form id="frmModificarCampo">
                    <div class="form-group">
                        <label for="txtModificarCampo" class="col-form-label">Campo:</label>
                        <input type="text" class="form-control" id="txtModificarCampo" name="txtModificarCampo" value="">
                        <input type="hidden" id="idcampo" name="idcampo" value="">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnModificarCampo">Modificar</button>
            </div>
        </div>
    </div>
</div>