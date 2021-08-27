<?php
$raiz = "";
include_once("./includes/controlLogin.php");
include_once("./includes/modelos/ordenesModelo.php");

ini_set("memory_limit", "1024M");
$idordentrabajo = $_GET["idorden"];
$oOrden = new ordenesModel();
$ordenes = $oOrden->verOrden($idordentrabajo);

$productores = $oOrden->verOrdenProductores($idordentrabajo);
$cantProductores = $oOrden->cantidadRegistros();

$campos = $oOrden->verOrdenLotes($idordentrabajo);
$cantCampos = $oOrden->cantidadRegistros();

$insumos = $oOrden->verOrdenInsumos($idordentrabajo);
$cantInsumos = $oOrden->cantidadRegistros();


/*
include "conexion/conexion.php";
$query_orden = mysqli_query($con, "select o.fecha,l.labor,o.precio,o.observaciones,o.superficie from ordentrabajos as o inner join labores as l on o.idlabor=l.idlabor where o.idordentrabajo=" . $idordentrabajo);
$row = mysqli_fetch_array($query_orden);

$query_productor = mysqli_query($con, "select o.superficie,p.usuario as productor from orden_productores o inner join usuarios p on o.idproductor=p.idusuario where o.idordentrabajo=" . $idordentrabajo);
$rowProductor = mysqli_fetch_array($query_productor);
$cantProductores = mysqli_affected_rows($con);

$query_campo = mysqli_query($con, "select o.superficie,c.campo,l.lote from orden_lotes o inner join lotes l on o.idlote=l.idlote inner join campos c on l.idcampo=c.idcampo where o.idordentrabajo=" . $idordentrabajo);
$rowCampo = mysqli_fetch_array($query_campo);
$cantCampos = mysqli_affected_rows($con);

$query_insumo = mysqli_query($con, "select o.cantidadHa,o.precioUn,o.cantidadTotal,o.precioTotal,i.insumo,u.unidad from orden_insumos o inner join insumos i on o.idinsumo=i.idinsumo inner join unidades u on i.idunidad=u.idunidad where o.idordentrabajo=" . $idordentrabajo);
$rowInsumo = mysqli_fetch_array($query_insumo);
$cantInsumos = mysqli_affected_rows($con);
*/
$totalInsumos = 0;

/*
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

ob_start();
*/
?>

<html lang='es'>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilos.css" />

    <title>Orden de Trabajo</title>
</head>


<body>
    <div class="container col-5 mt-2">
        <div class="card mb-2 shadow">
            <h4 class="text-center">Orden de Trabajo - Informe Productor</h4>
        </div>
        <div class="card p-3 shadow">
            <div class="row ">
                <div class="col-md-12">
                    <table class="table table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Labor</th>
                                <th class="text-right">Precio/ha</th>
                                <th class="text-right">Superficie</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $ordenes[0]['fecha']; ?></td>
                                <td><?php echo $ordenes[0]['labor']; ?></td>
                                <td class="text-right"><?php echo $ordenes[0]['precio']; ?></td>
                                <td class="text-right"><?php echo $ordenes[0]['superficie']; ?></td>
                                <td class="text-right"><?php echo $ordenes[0]['superficie'] * $ordenes[0]['precio']; ?></td>
                            </tr>
                            <?php if ($ordenes[0]['observaciones'] != '') {
                                echo "<tr>
                                    <td>Observaciones</td>
                                    <td colspan='4' style='border: 1px solid;'>" . $ordenes[0]['observaciones'] . "</td>
                                    </tr>";
                            } ?>
                        </tbody>
                    </table>

                </div>
            </div>

            <?php if ($cantProductores > 0) { ?>
                <div class="row mt-2">
                    <div class="col-md-12 ml-3">
                        <strong>Lista de Productores</strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-sm" id="tblproductores">
                            <thead class="thead-light">
                                <tr>
                                    <th>Productor</th>
                                    <th class="text-right">Participacion</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($productores as $rowProductor) { ?>
                                    <tr>
                                        <td><?php echo $rowProductor['productor'] ?></td>
                                        <td class="text-right"><?php echo $rowProductor['superficie'] ?></td>
                                    </tr>
                                <?php }  ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } ?>

            <?php if ($cantCampos > 0) { ?>
                <div class="row mt-2">
                    <div class="col-md-12 ml-3">
                        <strong>Lista de Campos/Lotes</strong>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-sm" id="tblcampos">
                            <thead class="thead-light">
                                <tr>
                                    <th>Campo</th>
                                    <th>Lote</th>
                                    <th class="text-right">Superficie</th>
                                    <th class="text-right">Total Labor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($campos as $rowCampo) { ?>
                                    <tr>
                                        <td><?php echo $rowCampo['campo']; ?></td>
                                        <td><?php echo $rowCampo['lote']; ?></td>
                                        <td class="text-right"><?php echo $rowCampo['superficie']; ?></td>
                                        <td class="text-right"><?php echo $rowCampo['superficie'] * $ordenes[0]['precio']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            <?php } ?>

            <?php if ($cantInsumos > 0) { ?>
                <div class="row mt-2">
                    <div class="col-md-12 ml-3">
                        <strong>Lista de Insumos</strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-sm" id="tblinsumos">
                            <thead class="thead-light">
                                <tr>
                                    <th>Insumo</th>
                                    <th class="text-right">Cant/ha</th>
                                    <th class="text-right">Unidad</th>
                                    <th class="text-right">Total</th>
                                    <th class="text-right">Precio Un.</th>
                                    <th class="text-right">Precio Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($insumos as $rowInsumo) { ?>
                                    <tr>
                                        <td><?php echo $rowInsumo['insumo']; ?></td>
                                        <td class="text-right"><?php echo $rowInsumo['cantidadHa']; ?></td>
                                        <td class="text-right"><?php echo $rowInsumo['unidad']; ?></td>
                                        <td class="text-right"><?php echo $rowInsumo['cantidadTotal']; ?></td>
                                        <td class="text-right"><?php echo $rowInsumo['precioUn']; ?></td>
                                        <td class="text-right"><?php echo $rowInsumo['precioTotal']; ?></td>
                                    </tr>
                                    <?php $totalInsumos += $rowInsumo['precioTotal']; ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } ?>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th colspan="2">Resumen de la Orden de Trabajo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Superficie Total (has)</td>
                                <td id="tdSupTotal" class="text-right"><?php echo $ordenes[0]['superficie']; ?></td>
                            </tr>
                            <tr>
                                <td>Total Labores (U$S)</td>
                                <td id="tdTotalLabores" class="text-right"><?php echo $ordenes[0]['superficie'] * $ordenes[0]['precio']; ?></td>
                            </tr>
                            <tr>
                                <td>Total Insumos (U$S)</td>
                                <td id="tdTotalInsumos" class="text-right"><?php echo $totalInsumos; ?></td>
                            </tr>
                            <tr>

                                <td><strong>Total (U$S)</strong></td>
                                <td class="text-right"><strong id="tdTotal"><?php echo $totalInsumos + ($ordenes[0]['superficie'] * $ordenes[0]['precio']); ?></strong></td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</body>

</html>
<?php
/*
$html = ob_get_clean();
$dompdf = new Dompdf();

$dompdf->loadHtml($html);
$dompdf->setPaper("A4", "portrait");
$dompdf->render();
$dompdf->stream();
*/
?>