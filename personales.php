<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php include 'includes/header.php'; ?>

    <title>AgroGestion</title>
</head>

<body>
    <?php
    $raiz = "";
    include_once 'includes/menu.php';
    include_once 'includes/modelos/personalesModelo.php';
    $oPersonal = new personalesModel();
    $personales = $oPersonal->listarPersonales($idUsuarioActivo);
    
    ?>
    <script src="./jquery/personales.js?version=<?php echo rand(1, 10000); ?>"></script>
    <div class="container border bg-white">
        <div id="alerta"></div>
        <form id="formpersonales">
            <!-- Campos y lotes-->
            <div>
                <div class="row">
                    <div class="shadow p-3 mb-3 bg-white rounded col-md-12 ">
                        <h5>Personales</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 ml-4 mb-2">
                        <a href="#" class="btn btn-primary btn-sm" id="btnAgregarPersonal" data-toggle="modal" data-target="#modalInsPersonal" data-whatever="" >Agregar Personal</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body col-8">
                        <table class="table table-sm" id="tblpersonales">
                            <thead>
                                <th class="d-none"></th>
                                <th>Personales</th>
                                <th class="text-right">CUIL</th>
                                <th class="text-right">Precio Ha</th>
                                <th class="text-center">Accion</th>
                            </thead>
                            <tbody>
                                <?php foreach ($personales as $personal) { ?>
                                    <tr >
                                        <td class="d-none"><?php echo $personal["idpersonal"]; ?></td>
                                        <td class="insumo"><?php echo $personal["personal"]; ?></td>
                                        <td class="text-right"><?php echo $personal["cuil"]; ?></td>
                                        <td class="text-right"><?php echo $personal["precioHa"]; ?></td>
                                        <td class="text-center">
                                            <a class="btn btn-success btn-sm btn-xxs"  data-toggle="modal" data-target="#modalModificarPersonal" data-whatever="" onclick="modificarPersonal(<?php echo $personal['idpersonal']; ?>)">Modificar</a>
                                            <button class="btn btn-danger btn-sm btn-xxs btnEliminarPersonal"  value="<?php echo $personal["idpersonal"]; ?>">Eliminar</button>
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
    include 'modales/modalPersonal.php';
    ?>
    <?php include 'includes/footer.php'; ?>
</body>

</html>