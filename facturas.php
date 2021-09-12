<?php
?>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php include 'includes/header.php'; ?>

    <title>AgroGestion</title>
</head>

<body>
    <?php include 'includes/menu.php'; ?>
    <div class="container border bg-white col-8">
        <div id="alerta"></div>
        <form id="formFacturas">
            <!-- Campos y lotes-->
            <div>
                <div class="row">
                    <div class="shadow p-3 mb-3 bg-white rounded col-md-12 ">
                        <h5>Sistema de Facturacion</h5>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-2 ml-4 mb-2">
                    <a href="agregarFactura.php" class="btn btn-primary btn-sm" id="btnAgregarFactura">Agregar Factura</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body col-12">
                    <table class="table table-sm" id="tblempresas">
                        <thead>
                            <th class="d-none"></th>
                            <th>Fecha</th>
                            <th>Empresas</th>
                            <th>Importe</th>
                            <th class="text-center">Acciones</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

        </form>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>

</html>