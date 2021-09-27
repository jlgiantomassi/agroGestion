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
    $idcuenta=$_GET["idcuenta"];
    $oCuentas=new cuentasModel();
    $cuenta=$oCuentas->cuentaById($idcuenta)[0]["cuenta"];
    $movimientos=$oCuentas->movimientos($idcuenta);

    ?>
    <div class="container border bg-white col-8">
        <div id="alerta"></div>
        <div id="formFacturas">
            <div class="row">
                <div class="shadow p-3 mb-3 bg-white rounded col-md-12 ">
                    <h5>Movimientos de la Cuenta <?php echo $cuenta?></h5>
                </div>
            </div>
            <div class="row">
                <div class="col-2 ml-4 mb-2">
                    <a href="movimientoAgregar.php" class="btn btn-primary btn-sm" id="btnAgregarMovimiento">Agregar Movimiento</a>
                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-body col-11">
                <table class="table table-sm" id="tblmovimientos">
                        <thead>
                            <th>Fecha</th>
                            <th>Numero</th>
                            <th>Beneficiario</th>
                            <th>Estado</th>
                            <th class="text-center">Debe</th>
                            <th class="text-center">Haber</th>
                            <th class="text-center">Saldo</th>
                            <th>Descripcion</th>
                            <th>Acciones</th>
                        </thead>
                        <tbody>
                            <?php 
                                $saldo=0;
                                foreach ($movimientos as $movimiento) { 
                                $saldo+=$movimiento["credito"]-$movimiento["debito"];
                            ?>
                                <tr>
                                    <td><?php echo $movimiento["fechaB"]; ?></td>
                                    <td><?php echo $movimiento["numero"]; ?></td>
                                    <td><?php echo $movimiento["beneficiario"]; ?></td>
                                    <td><?php echo $movimiento["estado"]; ?></td>
                                    <td class="text-right"><?php echo number_format($movimiento["debito"],2); ?></td>
                                    <td class="text-right"><?php echo number_format($movimiento["credito"],2); ?></td>
                                    <td class="text-right pr-2"><?php echo number_format($saldo,2); ?></td>
                                    <td><?php echo $movimiento["detalle"]; ?></td>
                                    <td>modificar-borrar</td>
                                </tr>
                        <?php } ?>
                        </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>

</html>