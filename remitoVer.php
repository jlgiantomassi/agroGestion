<?php
$raiz="";
include_once("includes/modelos/remitosModelo.php");
$idremito = $_GET["idremito"];
$oRemito = new remitosModel();
$remitos = $oRemito->verRemito($idremito);
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
        <form id="formVerRemito">
            <!-- Campos y lotes-->
            <div>
                <div class="row">
                    <div class="shadow p-3 mb-3 bg-white rounded col-md-12 ">
                        <h5>Ver Detalle de Remito</h5>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body col-12">
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="fecha" class="m-0 ml-2">Fecha</label>
                            <input type="text" class="form-control col-10" id="fecha" name="fecha" value="<?php echo $remitos[0]["fecha"]; ?>" disabled>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="txtnroFactura" class="m-0 ml-2">Nro Remito</label>
                            <input type="text" class="form-control col-10" id="txtnroFactura" name="txtnroFactura" value="<?php echo $remitos[0]["numero"]; ?>" disabled>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="fecha" class="m-0 ml-2">Empresa</label>
                            <input type="text" class="form-control col-10" id="fechaVencimiento" name="fechaVencimiento" value="<?php echo $remitos[0]["empresa"]; ?>" disabled>
                        </div>
                    </div>
                </div>

            </div>
            
            <div class="card">
                <div class="card-body col-4">
                    <h6 class="">Lista de Insumos</h6>
                    <table class="table table-sm" id="tblinsumos">
                        <thead>
                            <th>Insumos</th>
                            <th class='text-right'>Cantidad</th>
                        </thead>
                        <tbody>
                            <?php foreach ($remitos as $remito) { ?>
                                <tr>
                                    <td><?php echo $remito["insumo"]; ?></td>
                                    <td class='text-right'><?php echo $remito["cantidad"]; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-body col-12 text-center">
                    <a href="remitos.php" class="btn btn-primary col-1" id="btnVolverRemito">Volver</a>
                </div>
            </div>
        </form>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>

</html>