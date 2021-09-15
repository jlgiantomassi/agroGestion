<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>

    <?php include 'includes/header.php'; ?>

    <title>AgroGestion</title>
</head>

<body>
    <?php
    include 'includes/menu.php';
    include 'includes/modelos/insumosModelo.php';
    $oInsumos = new insumosModel();
    $insumos = $oInsumos->listarInsumos($idUsuarioActivo);
    if ($oInsumos->cantidadInsumos() > 0)
        $primerPrecio = $insumos[0]["precio"];
    else
        $primerPrecio = "";
    $empresas = $oEmpesas->listarEmpresasRubros(0, 0, 1, 0, $idUsuarioActivo);

    ?>

    <script src="jquery/facturas.js?version=<?php echo rand(1, 10000); ?>"></script>
    <div class="container border bg-white col-8">
        <div id="alerta"></div>
        <form id="formAddFactura">
            <!-- Campos y lotes-->
            <div>
                <div class="row">
                    <div class="shadow p-3 mb-3 bg-white rounded col-md-12 ">
                        <h5>Agregar Factura</h5>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body col-12">
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="fecha" class="m-0 ml-2">Fecha</label>
                            <input type="text" class="form-control col-9" id="fecha" name="fecha" value="<?php echo date("d/m/Y"); ?>">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="fecha" class="m-0 ml-2">Fecha Vencimiento</label>
                            <input type="text" class="form-control col-9" id="fechaVencimiento" name="fechaVencimiento" value="<?php echo date("d/m/Y"); ?>">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="nroFactura" class="m-0 ml-2">Nro Factura</label>
                            <input type="text" class="form-control col-9" id="nroFactura" name="nroFactura" value="">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="txtempresa" class="m-0 ml-2">Empresa</label>
                            <select id="sltempresas" class="form-control col-10">
                                <?php foreach ($empresas as $empresa) { ?>
                                    <option value="<?php echo $empresa["idempresa"]; ?>"><?php echo $empresa["empresa"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card">
                <div class="card-body col-12">
                    <h6 class="">Agregar Insumos</h6>
                    <div class="form-row">

                        <div class="form-group col-md-3">
                            <label for="txtempresa" class="m-0 ml-2 ">Insumos</label>
                            <select id="sltinsumos" class="form-control">
                                <?php foreach ($insumos as $insumo) { ?>
                                    <option value="<?php echo $insumo["idinsumo"]; ?>" data-precio="<?php echo $insumo["precio"]; ?>"><?php echo $insumo["insumo"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-1">
                            <label for="precioUn" class="m-0 ml-2">Precio Un.</label>
                            <input type="number" class="form-control" id="precioUn" name="precioUn" value="<?php echo $primerPrecio; ?>">
                        </div>
                        <div class="form-group col-md-1">
                            <label for="txtiva" class="m-0 ml-2">IVA (%)</label>
                            <input type="number" class="form-control" id="txtiva" name="txtiva" value="21">
                        </div>
                        <div class="form-group col-md-1">
                            <label for="cantidadInsumo" class="m-0 ml-2">Cantidad</label>
                            <input type="number" class="form-control" id="cantidadInsumo" name="cantidadInsumo" value="">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="btnAgregar" class="m-0 ml-2">Agregar a la lista </label>
                            <button class="form-control btn btn-success col-md-8" id="btnAgregar" name="btnAgregar">Agregar</button>
                        </div>
                    </div>

                    <h6 class="">Agregar Detalle</h6>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="txtdetalle" class="m-0 ml-2 ">Detalle</label>
                            <input type="text" class="form-control" id="txtdetalle" name="txtdetalle" value="">
                        </div>
                        <div class="form-group col-md-1">
                            <label for="precioDetalle" class="m-0 ml-2">Precio Un.</label>
                            <input type="number" class="form-control" id="precioDetalle" name="precioDetalle" value="">
                        </div>
                        <div class="form-group col-md-1">
                            <label for="ivaDetalle" class="m-0 ml-2">IVA (%)</label>
                            <input type="number" class="form-control" id="ivaDetalle" name="ivaDetalle" value="21">
                        </div>
                        <div class="form-group col-md-1">
                            <label for="cantidadDetalle" class="m-0 ml-2">Cantidad</label>
                            <input type="number" class="form-control" id="cantidadDetalle" name="cantidadDetalle" value="">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="btnAgregarDetalle" class="m-0 ml-2">Agregar a la lista </label>
                            <button class="form-control btn btn-success col-md-8" id="btnAgregarDetalle" name="btnAgregarDetalle">Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body col-12">
                    <h6 class="">Lista de Insumos</h6>
                    <table class="table table-sm" id="tblinsumos">
                        <thead>
                            <th class="d-none">id</th>
                            <th>Insumos</th>
                            <th class='text-right'>Precio Un.</th>
                            <th class='text-right'>Cantidad</th>
                            <th class='text-right'>Importe</th>
                            <th class='text-right'>IVA</th>
                            <th class='text-right'>Total</th>
                            <th class='text-center'>Acciones</th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <hr />
                    <div class="row col-10">
                        <div class="col-10 text-right p-0">
                            <strong>Subtotal</strong>
                        </div>
                        <div class="col-2 text-right p-0">
                            <strong id="resSubtotal"></strong>
                        </div>
                    </div>
                    <div class="row col-10">
                        <div class="col-10 text-right p-0">
                            <strong>IVA</strong>
                        </div>
                        <div class="col-2 text-right p-0">
                            <strong id="resIva"></strong>
                        </div>
                    </div>
                    <div class="row col-10">
                        <div class="col-10 text-right p-0">
                            <strong>Total</strong>
                        </div>
                        <div class="col-2 text-right p-0">
                            <strong id="resTotal"></strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body col-12 text-center">
                    <button class="btn btn-success col-1" id="btnGuardarFactura">Guardar</button>
                    <a href="facturas.php" class="btn btn-primary col-1" id="btnVolverFactura">Volver</a>
                </div>
            </div>
        </form>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>

</html>