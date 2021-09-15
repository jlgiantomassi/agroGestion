<?php
$raiz="";
include_once("includes/modelos/facturasModelo.php");
$idfactura = $_GET["idfactura"];
$oFactura = new facturasModel();
$factura = $oFactura->verFactura($idfactura);
$facturasDesc = $oFactura->verDescripcionFactura($idfactura);
$facturasDet = $oFactura->verDetallesFactura($idfactura);
if($facturasDesc)
{
    $empresa=$facturasDesc[0]["empresa"];
}
if($facturasDet)
{
    $empresa=$facturasDet[0]["empresa"];
}
?>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>

    <?php include 'includes/header.php'; ?>

    <title>AgroGestion</title>
</head>

<body>
    <?php
    include 'includes/menu.php';
    ?>
    <div class="container border bg-white col-8">
        <div id="alerta"></div>
        <form id="formAddFactura">
            <!-- Campos y lotes-->
            <div>
                <div class="row">
                    <div class="shadow p-3 mb-3 bg-white rounded col-md-12 ">
                        <h5>Ver Detalle de Factura</h5>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body col-12">
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="fecha" class="m-0 ml-2">Fecha</label>
                            <input type="text" class="form-control col-10" id="fecha" name="fecha" value="<?php echo $factura[0]["fecha"]; ?>" disabled>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="fechaVencimiento" class="m-0 ml-2">Fecha Vencimiento</label>
                            <input type="text" class="form-control col-10" id="fechaVencimiento" name="fechaVencimiento" value="<?php echo $factura[0]["vencimiento"]; ?>" disabled>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="txtnroFactura" class="m-0 ml-2">Nro Factura</label>
                            <input type="text" class="form-control col-10" id="txtnroFactura" name="txtnroFactura" value="<?php echo $factura[0]["numero"]; ?>" disabled>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="fecha" class="m-0 ml-2">Empresa</label>
                            <input type="text" class="form-control col-10" id="fechaVencimiento" name="fechaVencimiento" value="<?php echo $empresa; ?>" disabled>
                        </div>
                    </div>
                </div>

            </div>
            
            <div class="card">
                <div class="card-body col-9">
                    <h6 class="">Lista de Insumos</h6>
                    <table class="table table-sm" id="tblinsumos">
                        <thead>
                            <th>Detalles</th>
                            <th class='text-right'>Precio Un.</th>
                            <th class='text-right'>Cantidad</th>
                            <th class='text-right'>Importe</th>
                            <th class='text-right'>IVA</th>
                            <th class='text-right'>Total</th>
                        </thead>
                        <tbody>
                            <?php 
                                $importe=0;
                                $iva=0;
                                foreach ($facturasDesc as $factura) { 
                                    $importe+=$factura["importe"];
                                    $iva+=$factura["iva"];
                                    ?>
                                <tr>
                                    <td><?php echo $factura["insumo"]; ?></td>
                                    <td class='text-right'><?php echo $factura["precioUn"]; ?></td>
                                    <td class='text-right'><?php echo $factura["cantidad"]; ?></td>
                                    <td class='text-right'><?php echo $factura["importe"]; ?></td>
                                    <td class='text-right'><?php echo $factura["iva"]; ?></td>
                                    <td class='text-right'><?php echo $factura["importeTotal"]; ?></td>
                                </tr>
                            <?php } 
                                foreach ($facturasDet as $factura) { 
                                    $importe+=$factura["importe"];
                                    $iva+=$factura["iva"];
                                    ?>
                                    <tr>
                                        <td><?php echo $factura["insumo"]; ?></td>
                                        <td class='text-right'><?php echo $factura["precioUn"]; ?></td>
                                        <td class='text-right'><?php echo $factura["cantidad"]; ?></td>
                                        <td class='text-right'><?php echo $factura["importe"]; ?></td>
                                        <td class='text-right'><?php echo $factura["iva"]; ?></td>
                                        <td class='text-right'><?php echo $factura["importeTotal"]; ?></td>
                                    </tr>
                                <?php } ?>
                                    <tr>
                                        <th colspan="5" class='text-right'><strong>Subtotal</strong></th>
                                        <th class='text-right'><strong><?php echo $importe; ?></strong></th>
                                    </tr>
                                    <tr>
                                        <th colspan="5" class='text-right'><strong>IVA</strong></th>
                                        <th class='text-right'><strong><?php echo $iva; ?></strong></th>
                                    </tr>
                                    <tr>
                                        <th colspan="5" class='text-right'><strong>Total</strong></th>
                                        <th class='text-right'><strong><?php echo $importe+$iva; ?></strong></th>
                                    </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-body col-12 text-center">
                    <a href="facturas.php" class="btn btn-primary col-1" id="btnVolverFactura">Volver</a>
                </div>
            </div>
        </form>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>

</html>