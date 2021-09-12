<?php

$raiz = "";
include_once("./includes/controlLogin.php");
include_once("./includes/modelos/ordenesModelo.php");

$idordentrabajo = $_GET["idorden"];
$oOrden = new ordenesModel();
$ordenes = $oOrden->verOrden($idordentrabajo);

$productores = $oOrden->verOrdenProductores($idordentrabajo);
$cantProductores = $oOrden->cantidadRegistros();

$campos = $oOrden->verOrdenLotes($idordentrabajo);
$cantCampos = $oOrden->cantidadRegistros();

$insumos = $oOrden->verOrdenInsumos($idordentrabajo);
$cantInsumos = $oOrden->cantidadRegistros();


?>

<html lang='es'>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilosOrdenes.css?version=<?php echo rand(1, 10000); ?>" />

    <title>Orden de Trabajo</title>
</head>

<body>
    <div class="container col-8 mt-2">
        <div class="card mb-2 shadow">
            <h4 class="text-center">Orden de Trabajo</h4>
        </div>
        <div class="card p-3 shadow">
            <div class="row ">
                <div class="col-md-12">
                    <table class="table table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Labor</th>
                                <th class="text-right">Superficie Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $ordenes[0]['fecha']; ?></td>
                                <td><?php echo $ordenes[0]['labor']; ?></td>
                                <td class="text-right"><?php echo $ordenes[0]['superficie']; ?></td>
                            </tr>
                            <?php if ($ordenes[0]['observaciones'] != '') {
                                echo "<tr>
                                <td>Observaciones</td>
                                <td colspan='2' style='border: 1px solid;'>" . $ordenes[0]['observaciones'] . "</td>
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
                                <?php } ?>
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
                                    <th class="text-right ">Superficie</th>
                                    <th class="text-right ">Superf. Realizada</th>
                                    <th class="text-right ">Fecha Realizada</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($campos as $rowCampo) { ?>
                                    <tr>
                                        <td><?php echo $rowCampo['campo'] ?></td>
                                        <td><?php echo $rowCampo['lote'] ?></td>
                                        <td class="text-right"><?php echo $rowCampo['superficie'] ?></td>
                                        <td></td>
                                        <td></td>
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
                                    <th class="text-right">Total Usado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($insumos as $rowInsumo) { ?>
                                    <tr>
                                        <td><?php echo $rowInsumo['insumo'] ?></td>
                                        <td class="text-right"><?php echo $rowInsumo['cantidadHa'] ?></td>
                                        <td class="text-right"><?php echo $rowInsumo['unidad'] ?></td>
                                        <td class="text-right"><?php echo $rowInsumo['cantidadTotal'] ?></td>
                                        <td></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-10 ml-5">
            <strong>Observaciones de Operario</strong>
        </div>
        <div class="card">

        </div>
    </div>
</body>

</html>