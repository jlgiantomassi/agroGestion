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
    $oCampo = new camposModel();
    $campos = $oCampo->listarCampos($idUsuarioActivo);
    
    ?>
    <script src="./jquery/campos.js?version=<?php echo rand(1, 10000); ?>"></script>
    <div class="container border bg-white">
        <div id="alerta"></div>
        <form id="formcampos">
            <!-- Campos y lotes-->
            <div>
                <div class="row">
                    <div class="shadow p-3 mb-3 bg-white rounded col-md-12 ">
                        <h5>Campos</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 ml-4 mb-2">
                        <a href="#" class="btn btn-primary btn-sm" id="btnAgregarCampo" data-toggle="modal" data-target="#modalInsertarCampo" data-whatever="" >Agregar Campo</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body col-8">
                        <table class="table table-sm" id="tblcampos">
                            <thead>
                                <th class="d-none"></th>
                                <th>Campos</th>
                                <th class="text-right">Superficie</th>
                                <th class="text-center">Accion</th>
                            </thead>
                            <tbody>
                                <?php foreach ($campos as $campo) { ?>
                                    <tr >
                                        <td class="d-none"><?php echo $campo["idcampo"]; ?></td>
                                        <td class="campo"><?php echo $campo["campo"]; ?></td>
                                        <td class="text-right"><?php 
                                                            $superficie=$oCampo->superficieCampo($campo["idcampo"]);
                                                            echo $superficie; ?>
                                        </td>
                                        <td class="text-center">
                                            <a class="btn btn-primary btn-sm btn-xxs" href="lotes.php?idcampo=<?php echo $campo["idcampo"].'&campo='.$campo["campo"]; ?>">Lotes</a>
                                            <a class="btn btn-success btn-sm btn-xxs"  data-toggle="modal" data-target="#modalModificarCampo" data-whatever="" onclick="modificarCampo('<?php echo $campo['campo']?>',<?php echo $campo['idcampo']; ?>)">Modificar</a>
                                            <button class="btn btn-danger btn-sm btn-xxs btnEliminarCampo"  value="<?php echo $campo["idcampo"]; ?>">Eliminar</button>
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