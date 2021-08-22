<!DOCTYPE html>
<html lang="en">
<?php
$raiz = "";
$idloteCampana = $_GET["idloteCampana"];
include_once("includes/header.php");
include_once("includes/modelos/camposModelo.php");
include_once("includes/modelos/actividadesModelo.php");
$oLote = new camposModel();
$datos = $oLote->datosByIdCampana($idloteCampana);

$oActividad = new actividadesModel();
$actividades = $oActividad->cargarActividades($idloteCampana);
$totalActividades = 0;

$totalInsumos = 0;
?>

<body>
    <div class="container col-5">
        <div class="card p-1 mb-2 shadow bg-white rounded ">
            <h3 class="text-center ">Informe de Costos Detallado</h3>
        </div>
        <div class="card" id="datos">
            <div class="row">
                <div class="col-3 text-right">
                    Productor
                </div>
                <div class="col-3 text-left">
                    <strong><?php echo $datos[0]["usuario"]; ?></strong>
                </div>
            </div>
            <div class="row">
                <div class="col-3 text-right">
                    Campaña
                </div>
                <div class="col-3 text-left">
                    <strong><?php echo $datos[0]["campana"]; ?></strong>
                </div>
            </div>
            <div class="row">
                <div class="col-3 text-right">
                    Campo
                </div>
                <div class="col-3 text-left">
                    <strong><?php echo $datos[0]["campo"]; ?></strong>
                </div>
            </div>
            <div class="row">
                <div class="col-3 text-right">
                    Lote
                </div>
                <div class="col-3 text-left">
                    <strong><?php echo $datos[0]["lote"]; ?></strong>
                </div>
            </div>
            <div class="row">
                <div class="col-3 text-right">
                    Superficie
                </div>
                <div class="col-3 text-left">
                    <strong><?php echo $datos[0]["superficie"]; ?></strong>
                </div>
            </div>
        </div>

        <div class="card mt-2 p-3" id="actividades">
            <h6>Resumen de Actividades e Insumos</h6>
            <div class="row p-2">
                <table class="table table-sm">
                    <thead>
                        <th>Fecha</th>
                        <th>Detalle</th>
                        <th class="text-right">Cantidad</th>
                        <th class="text-right">Precio (Unit.) </th>
                        <th class="text-right">Importe Total</th>
                    </thead>
                    <tbody>
                        <?php foreach ($actividades as $actividad) {
                            $idactividad = $actividad["idactividad"];
                            $insumos = $oActividad->cargarInsumos($idactividad);
                            $totalActividades += $actividad["superficie"] * $actividad["precioha"];
                        ?>
                            <tr>
                                <td><strong><?php echo $actividad["fechaDMY"]; ?></strong></td>
                                <td><strong><?php echo $actividad["labor"]; ?></strong></td>
                                <td class="text-right"><strong><?php echo $actividad["superficie"]; ?></strong></td>
                                <td class="text-right"><strong><?php echo $actividad["precioha"]; ?></strong></td>
                                <td class="text-right"><strong><?php echo $actividad["superficie"] * $actividad["precioha"]; ?></strong></td>
                                
                            </tr>
                            <?php foreach ($insumos as $insumo) {
                                $totalInsumos += $insumo["cantidadTotal"] * $insumo["precio"];
                            ?>
                                <tr>
                                    <td></td>
                                    <td class="pl-3"><?php echo $insumo["insumo"]; ?></td>
                                    <td class="text-right"><?php echo $insumo["cantidadTotal"]; ?></td>
                                    <td class="text-right"><?php echo $insumo["precio"]; ?></td>
                                    <td class="text-right"><?php echo number_format($insumo["cantidadTotal"] * $insumo["precio"], 2); ?></td>
                                </tr>
                        <?php }
                        } ?>
                        <tr class="bg-light">

                            <td colspan="4" class="text-right"><strong>Total</strong></td>
                            <td class="text-right"><strong><?php echo $totalActividades+$totalInsumos; ?></strong></td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mt-2 p-3" id="Totales">
            <h6>Resumen Total del Lote</h6>
            <div class="row">
                <div class="col-4 text-right">
                    <i>Costo total del Lote</i>
                </div>
                <div class="col-4 text-left">
                    <strong><?php echo $totalInsumos + $totalActividades; ?></strong>
                </div>
            </div>
            <div class="row">
                <div class="col-4 text-right">
                    <i>Costo por Ha del Lote</i>
                </div>
                <div class="col-4 text-left">
                    <strong><?php echo ($totalInsumos + $totalActividades) / $datos[0]["superficie"]; ?></strong>
                </div>
            </div>
        </div>

    </div>
</body>

</html>