<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php include 'includes/header.php'; ?>

    <title>AgroGestion</title>
</head>

<body>
    <?php
    $raiz = "";
    include_once 'includes/menu.php';
    include_once 'includes/modelos/camposModelo.php';
    $idcampo=$_GET["idcampo"];
    $oLotes = new camposModel();
    $lotes = $oLotes->listarLotes($idcampo);
    
    ?>
    <script src="./jquery/campos.js?version=<?php echo rand(1, 10000); ?>"></script>
    <div class="container border bg-white">
        <div id="alerta"></div>
        <form id="formcampos">
            <!-- Campos y lotes-->
            <div>
                <div class="row">
                    <div class="shadow p-3 mb-3 bg-white rounded col-md-12 ">
                        <h5>Lotes de <?php echo $_GET["campo"]; ?></h5>
                        <input type="hidden" id="idcampo" name="idcampo" value="<?php echo $_GET["idcampo"]; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 ml-4 mb-2">
                        <a href="#" class="btn btn-primary btn-sm" id="btnAgregarLote" data-toggle="modal" data-target="#modalInsertarLote" data-whatever="" >Agregar Lote</a>
                        <a href="campos.php" class="btn btn-secondary btn-sm">Volver</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body col-8">
                        <table class="table table-sm" id="tbllotes">
                            <thead>
                                <th class="d-none"></th>
                                <th>Lotes</th>
                                <th class="text-right">Superficie</th>
                                <th class="text-center">Accion</th>
                            </thead>
                            <tbody>
                                <?php foreach ($lotes as $lote) { ?>
                                    <tr >
                                        <td class="d-none"><?php echo $lote["idlote"]; ?></td>
                                        <td class="lote"><?php echo $lote["lote"]; ?></td>
                                        <td class="text-right"><?php echo $lote["superficie"]; ?></td>
                                        <td class="text-center">
                                            <a class="btn btn-success btn-sm btn-xxs"  data-toggle="modal" data-target="#modalModificarLote" data-whatever="" onclick="modificarLote('<?php echo $lote['lote']?>',<?php echo $lote['idlote'].','.$lote['superficie']; ?>)">Modificar</a>
                                            <button class="btn btn-danger btn-sm btn-xxs btnEliminarLote"  value="<?php echo $lote["idlote"]; ?>">Eliminar</button>
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
    include 'modales/modalCampos.php';
    ?>
    <?php include 'includes/footer.php'; ?>
</body>

</html>