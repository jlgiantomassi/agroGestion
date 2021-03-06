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


$insumos = $oActividad->importeInsumosPorLote($idloteCampana);
$totalInsumos = 0;

$productores=$oActividad->participacionProductores($idloteCampana);
?>

<body>
    <div class="container col-5">
        <div class="card p-1 mb-2 shadow bg-white rounded ">
            <h3 class="text-center ">Informe de Costos por Lote</h3>
        </div>

        <!-- tarjeta que muestra los datos del lote -->
        <div class="card col-12" id="datos">
            
                <div class="row">
                    <div class="col-3 text-right">
                        Usuario
                    </div>
                    <div class="col-3 text-left">
                        <strong><?php echo $datos[0]["usuario"]; ?></strong>
                    </div>
                    
                    <div class="col-3 text-right">
                        Lote
                    </div>
                    <div class="col-3 text-left">
                        <strong><?php echo $datos[0]["lote"]; ?></strong>
                    
                </div>
                </div>
                <div class="row">
                    <div class="col-3 text-right">
                        Campaña
                    </div>
                    <div class="col-3 text-left">
                        <strong><?php echo $datos[0]["campana"]; ?></strong>
                    </div>
                    <div class="col-3 text-right">
                        Cultivo
                    </div>
                    <div class="col-3 text-left">
                        <strong><?php echo $datos[0]["cultivo"]; ?></strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 text-right">
                        Campo
                    </div>
                    <div class="col-3 text-left">
                        <strong><?php echo $datos[0]["campo"]; ?></strong>
                    </div>
                    <div class="col-3 text-right">
                        Superficie
                    </div>
                    <div class="col-3 text-left">
                        <strong><?php echo $datos[0]["superficie"]; ?></strong>
                    </div>
                </div>
        </div>

        <!-- tarjeta que muestra las actividades del lote -->
        <div class="card mt-2 p-3" id="actividades">
            <h6>Resumen de Actividades</h6>
            <div class="row p-2">
                <table class="table table-sm">
                    <thead>
                        <th>Fecha</th>
                        <th>Actividad</th>
                        <th class="text-right">Superficie</th>
                        <th class="text-right">Precio Ha</th>
                        <th class="text-right">Importe Total</th>
                    </thead>
                    <tbody>
                        <?php foreach ($actividades as $actividad) {
                            $totalActividades += $actividad["superficie"] * $actividad["precioha"];
                        ?>
                            <tr>
                                <td><?php echo $actividad["fechaDMY"]; ?></td>
                                <td><?php echo $actividad["labor"]; ?></td>
                                <td class="text-right"><?php echo $actividad["superficie"]; ?></td>
                                <td class="text-right"><?php echo number_format($actividad["precioha"],2); ?></td>
                                <td class="text-right"><?php echo number_format($actividad["superficie"] * $actividad["precioha"],2); ?></td>
                            </tr>
                        <?php } ?>
                        <tr class="bg-light">

                            <td colspan="4" class="text-right"><strong>Total</strong></td>
                            <td class="text-right"><strong><?php echo number_format($totalActividades,2); ?></strong></td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- tarjeta que muestra los insumos del lote -->
        <div class="card mt-2 p-3" id="insumos">
            <h6>Resumen de Insumos</h6>
            <div class="row p-2">
                <table class="table table-sm">
                    <thead>
                        <th>Insumo</th>
                        <th class="text-right">Cantidad Total</th>
                        <th class="text-right">Importe Total</th>
                    </thead>
                    <tbody>
                        <?php foreach ($insumos as $insumo) {
                            $totalInsumos += $insumo["importe"]; ?>
                            <tr>
                                <td><?php echo $insumo["insumo"]; ?></td>
                                <td class="text-right"><?php echo $insumo["cantidad"]; ?></td>
                                <td class="text-right"><?php echo number_format($insumo["importe"], 2); ?></td>
                            </tr>
                        <?php } ?>
                        <tr class="bg-light">

                            <td colspan="2" class="text-right"><strong>Total</strong></td>
                            <td class="text-right"><strong><?php echo number_format($totalInsumos,2); ?></strong></td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- tarjeta que muestra las participaciones de empresas en el lote -->
        <div class="card mt-2 p-3" id="participaciones">
            <h6>Participaciones de Productores</h6>
            <div class="row p-2">
                <table class="table table-sm">
                    <thead>
                        <th>Productores</th>
                        <th class="text-right">Participacion Total</th>
                        <th class="text-right">Porcentaje aportado</th>
                    </thead>
                    <tbody>
                    <?php 
                        $totalAportes=0;
                        foreach ($productores as $productor) {
                            $totalAportes += $productor["total"]; 
                    }
                            ?>
                        <?php foreach ($productores as $productor) { ?>
                            <tr>
                                <td><?php echo $productor["empresa"]; ?></td>
                                <td class="text-right"><?php echo $productor["total"]; ?></td>
                                <td class="text-right"><?php echo number_format(($productor["total"]/$totalAportes)*100,2); ?></td>
                            </tr>
                        <?php } ?>
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
                    <strong><?php echo number_format($totalInsumos + $totalActividades,2); ?></strong>
                </div>
            </div>
            <div class="row">
                <div class="col-4 text-right">
                    <i>Costo por Ha del Lote</i>
                </div>
                <div class="col-4 text-left">
                    <strong><?php echo number_format(($totalInsumos + $totalActividades) / $datos[0]["superficie"],2); ?></strong>
                </div>
            </div>
        </div>

    </div>
</body>

</html>