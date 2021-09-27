<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php include 'includes/header.php'; ?>

    <title>AgroGestion</title>
</head>

<body>
    <?php
    $raiz = "";
    include_once 'includes/menu.php';
    include_once 'includes/modelos/empresasModelo.php';
    $oEmpresa = new empresasModel();
    $empresas = $oEmpresa->listarEmpresas($idUsuarioActivo);
    if($oEmpresa->cantidadEmpresas()==1)
        $idempresaActiva=$empresas[0]["idempresa"];
    ?>
    <script src="./jquery/empresas.js?version=<?php echo rand(1, 10000); ?>"></script>
    <div class="container border bg-white">
        <div id="alerta"></div>
        <form id="formempresas">
            <!-- Campos y lotes-->
            <div>
                <div class="row">
                    <div class="shadow p-3 mb-3 bg-white rounded col-md-12 ">
                        <h5>Empresas</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 ml-4 mb-2">
                        <a href="#" class="btn btn-primary btn-sm" id="btnAgregarEmpresa" data-toggle="modal" data-target="#modalInsEmpresa" data-whatever="" >Agregar Empresa</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body col-12">
                        <table class="table table-sm" id="tblempresas">
                            <thead>
                                <th class="d-none"></th>
                                <th>Empresas</th>
                                <th>CUIT</th>
                                <th>Direccion</th>
                                <th class="text-center">Productor</th>
                                <th class="text-center">Contratista</th>
                                <th class="text-center">Proveedor</th>
                                <th class="text-center">Otro</th>
                                <th class="text-center">Accion</th>
                            </thead>
                            <tbody>
                                <?php foreach ($empresas as $empresa) { ?>
                                    <tr >
                                        <td class="d-none"><?php echo $empresa["idempresa"]; ?></td>
                                        <td class="insumo"><?php echo $empresa["empresa"]; ?></td>
                                        <td><?php echo $empresa["cuit"]; ?></td>
                                        <td><?php echo $empresa["direccion"]; ?></td>
                                        <td class="text-center"><input type="checkbox" <?php if($empresa['productor']==1) echo 'checked'; ?> disabled></td>
                                        <td class="text-center"><input type="checkbox" <?php if($empresa['contratista']==1) echo 'checked'; ?> disabled></td>
                                        <td class="text-center"><input type="checkbox" <?php if($empresa['proveedor']==1) echo 'checked'; ?> disabled></td>
                                        <td class="text-center"><input type="checkbox" <?php if($empresa['otro']==1) echo 'checked'; ?> disabled></td>
                                        <td class="text-center">
                                            <a class="btn btn-success btn-sm btn-xxs"  data-toggle="modal" data-target="#modalModificarEmpresa" data-whatever="" onclick="modificarEmpresa(<?php echo $empresa['idempresa']; ?>)">Modificar</a>
                                            <button class="btn btn-danger btn-sm btn-xxs btnEliminarEmpresa"  value="<?php echo $empresa["idempresa"]; ?>">Eliminar</button>
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
    include 'modales/modalEmpresa.php';
    ?>
    <?php include 'includes/footer.php'; ?>
</body>

</html>