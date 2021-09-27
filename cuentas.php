<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php include 'includes/header.php'; ?>
    <title>AgroGestion</title>
</head>

<body>
    <?php
    $raiz = "";
    include_once 'includes/menu.php';
    
    include 'includes/modelos/cuentasModelo.php';
    $oCuentas = new cuentasModel();
    $tipos = $oCuentas->tipoCuentas($idEmpresaActiva);

    ?>
    <div class="container border bg-white col-8">
        <div id="alerta"></div>
        <div id="formFacturas">
            <div class="row">
                <div class="shadow p-3 mb-3 bg-white rounded col-md-12 ">
                    <h5>Cuentas Financieras</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-2 ml-4 mb-2">
                    <a href="cuentaAgregar.php" class="btn btn-primary btn-sm" id="btnAgregarFactura">Agregar Cuenta</a>
                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-body col-9">
                <table class="table table-sm" id="tblcuentas">
                    <?php foreach ($tipos as $tipo) { ?>
                        <thead>
                            <th>
                                <?php echo $tipo["tipo"];
                                $idtipo = $tipo["idtipocuenta"];
                                ?>
                            </th>
                        </thead>
                        <tbody>
                            <?php
                            $cuentas = $oCuentas->listarCuentasPorTipo($idtipo, $idEmpresaActiva);
                            foreach ($cuentas as $cuenta) { ?>
                                <tr>
                                    <td class="pl-2"><a href="movimientos.php?idcuenta=<?php echo $cuenta["idcuenta"];?>"><?php echo $cuenta["cuenta"]; ?> </a></td>
                                </tr>
                        <?php }
                        } ?>
                        </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>

</html>