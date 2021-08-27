<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php include 'includes/header.php'; ?>

    <title>AgroGestion</title>
</head>

<body>
    <?php
    $raiz = "";
    include_once 'includes/menu.php';
    include_once 'includes/modelos/insumosModelo.php';
    $oInsumo = new insumosModel();
    $insumos = $oInsumo->listarInsumos($idUsuarioActivo);
    
    ?>
    <script src="./jquery/insumos.js?version=<?php echo rand(1, 10000); ?>"></script>
    <div class="container border bg-white">
        <div id="alerta"></div>
        <form id="forminsumos">
            <!-- Campos y lotes-->
            <div>
                <div class="row">
                    <div class="shadow p-3 mb-3 bg-white rounded col-md-12 ">
                        <h5>Insumos</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 ml-4 mb-2">
                        <a href="#" class="btn btn-primary btn-sm" id="btnAgregarInsumo" data-toggle="modal" data-target="#modalInsertarInsumo" data-whatever="" >Agregar Insumo</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body col-8">
                        <table class="table table-sm" id="tblinsmos">
                            <thead>
                                <th class="d-none"></th>
                                <th>Insumos</th>
                                <th class="text-right">Precio Un.</th>
                                <th class="text-right">Unidad</th>
                                <th class="text-center">Accion</th>
                            </thead>
                            <tbody>
                                <?php foreach ($insumos as $insumo) { ?>
                                    <tr >
                                        <td class="d-none"><?php echo $insumo["idinsumo"]; ?></td>
                                        <td class="insumo"><?php echo $insumo["insumo"]; ?></td>
                                        <td class="text-right"><?php echo $insumo["precio"]; ?></td>
                                        <td class="text-right"><?php echo $insumo["unidad"]; ?></td>
                                        <td class="text-center">
                                            <a class="btn btn-success btn-sm btn-xxs"  data-toggle="modal" data-target="#modalModificarInsumo" data-whatever="" onclick="modificarInsumo(<?php echo $insumo['idinsumo']; ?>)">Modificar</a>
                                            <button class="btn btn-danger btn-sm btn-xxs btnEliminarInsumo"  value="<?php echo $insumo["idinsumo"]; ?>">Eliminar</button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php

    include 'includes/footer.php';
    include 'modales/modalInsumos.php';
    ?>
    <?php include 'includes/footer.php'; ?>
</body>

</html>