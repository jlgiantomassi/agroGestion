<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php include 'includes/header.php'; ?>

    <title>AgroGestion</title>
</head>

<body>
    <?php

    include_once 'includes/menu.php';
    include_once 'includes/modelos/stockModelo.php';
    include_once 'includes/modelos/empresasModelo.php';
    $oStock = new stockModel();
    if (isset($_POST["sltempresas"])) {
        if ($_POST["sltempresas"] > 0) {
            $depositos = $oStock->depositoPorProveedor($idEmpresaActiva, $_POST["sltempresas"]);
            $idempresa = $_POST["sltempresas"];
        } 
        elseif($_POST["sltempresas"] == -1) //deposito principal
        {
            $depositos = $oStock->depositoPorProveedor($idEmpresaActiva,$idEmpresaActiva);
            $idempresa = $idEmpresaActiva;
        }
        else {
            $depositos = $oStock->depositos($idEmpresaActiva);
            $idempresa = 0;
        }
    } else {
        $depositos = $oStock->depositos($idEmpresaActiva);
        $idempresa = 0;
    }

    $oEmpesa = new empresasModel();
    $empresas = $oEmpesas->listarEmpresasRubros(0, 0, 1, 0, $idUsuarioActivo);

    ?>
    <div class="container border bg-white col-8">
        <div id="alerta"></div>
        <form action="stockInsumos.php" method="POST" id="formVerStock">
            <!-- Campos y lotes-->
            <div>
                <div class="row">
                    <div class="shadow p-3 mb-3 bg-white rounded col-md-12 ">
                        <h5>Stock por Depositos</h5>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body col-12">
                    <div class="row">
                        <div class="col-3 form-group ">
                            <label class="m-0 ml-2" for="sltEmpresa">Empresa</label>
                            <select class="form-control col-md-12" id="sltempresas" name="sltempresas">
                                <option value="0"></option>
                                <option value="-1">Deposito Principal</option>
                                <?php foreach ($empresas as $empresa) { ?>
                                    <option value="<?php echo $empresa["idempresa"]; ?>" <?php echo $idempresa == $empresa["idempresa"] ? "selected" : ""; ?>><?php echo $empresa["empresa"]; ?></option>
                                <?php } ?>

                            </select>

                        </div>
                        <div class="col-1 form-group d-flex align-items-center p-0 m-0 mt-1">
                           
                            <input class="btn btn-success" type="submit" name="enviar" id="enviar" value="Filtrar">
                        </div>
                    </div>
                </div>

            </div>
            <div class="card">
                <div class="card-body col-3">
                    <h5 class=""><strong>Lista de Insumos</strong></h5>
                    <?php foreach ($depositos as $deposito) { ?>
                        <div class="mt-3 ml-3">
                            <h6><?php echo $deposito["deposito"]; ?></h6>

                        </div>
                        <table class="table table-sm" id="tblinsumos">

                            <thead>
                                <th class="ml-3">Insumo</th>
                                <th class='text-right'>Cantidad</th>
                            </thead>
                            <tbody>
                                <?php
                                $DepInsumos = $oStock->insumoPorDeposito($deposito["iddeposito"]);
                                foreach ($DepInsumos as $insumo) { ?>
                                    <tr>
                                        <td><?php echo $insumo["insumo"]; ?></td>
                                        <td class='text-right'><?php echo $insumo["stock"]; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>


                        </table>
                    <?php } ?>
                </div>
            </div>
        </form>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>

</html>