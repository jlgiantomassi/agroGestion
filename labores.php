<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php include 'includes/header.php'; ?>

    <title>AgroGestion</title>
</head>

<body>
    <?php
    $raiz = "";
    include_once 'includes/menu.php';
    include_once 'includes/modelos/laboresModelo.php';
    $oLabor = new laboresModel();
    $labores = $oLabor->listarLabores($idUsuarioActivo);
    
    ?>
    <script src="./jquery/labores.js?version=<?php echo rand(1, 10000); ?>"></script>
    <div class="container border bg-white">
        <div id="alerta"></div>
        <form id="formlabores">
            <!-- Campos y lotes-->
            <div>
                <div class="row">
                    <div class="shadow p-3 mb-3 bg-white rounded col-md-12 ">
                        <h5>Labores</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 ml-4 mb-2">
                        <a href="#" class="btn btn-primary btn-sm" id="btnAgregarLabor" data-toggle="modal" data-target="#modalLabor" data-whatever="" >Agregar Labor</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body col-8">
                        <table class="table table-sm" id="tbllabores">
                            <thead>
                                <th class="d-none"></th>
                                <th>Labores</th>
                                <th class="text-right">Precio Ha</th>
                                <th class="text-center">Accion</th>
                            </thead>
                            <tbody>
                                <?php foreach ($labores as $labor) { ?>
                                    <tr >
                                        <td class="d-none"><?php echo $labor["idlabor"]; ?></td>
                                        <td class="insumo"><?php echo $labor["labor"]; ?></td>
                                        <td class="text-right"><?php echo $labor["precio"]; ?></td>
                                        <td class="text-center">
                                            <a class="btn btn-success btn-sm btn-xxs"  data-toggle="modal" data-target="#modalModificarLabor" data-whatever="" onclick="modificarLabor(<?php echo $labor['idlabor']; ?>)">Modificar</a>
                                            <button class="btn btn-danger btn-sm btn-xxs btnEliminarLabor"  value="<?php echo $labor["idlabor"]; ?>">Eliminar</button>
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
    include 'modales/modalLabores.php';
    ?>
    <?php include 'includes/footer.php'; ?>
</body>

</html>