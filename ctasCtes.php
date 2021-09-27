<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php include 'includes/header.php'; ?>
    <title>AgroGestion</title>
</head>

<body>
    <?php
    include_once 'includes/menu.php';
    include_once "includes/modelos/facturasModelo.php";
    include_once "includes/modelos/empresasModelo.php";

    $oEmpresas = new empresasModel();
    $empresas = $oEmpresas->listarEmpresasRubros(0, 0, 1, 0, $idUsuarioActivo);
    $oFacturas=new facturasModel();
    
    if (isset($_POST["enviar"])) {
        $fechaDesde = $_POST["fechaDesde"];
        $fechaHasta = $_POST["fechaHasta"];
        $idproveedor = $_POST["sltempresas"];
        $saldo=$oFacturas->saldoProveedor($fechaDesde,$idproveedor,$idEmpresaActiva)[0]['saldo'];
        $saldo = is_null($saldo)?0:$saldo;
    } else {
        $fechaDesde = date("01/m/Y");
        $fechaHasta = date("d/m/Y");
        $idproveedor = 0;
        $saldo=0;
    }
    $facturas = $oFacturas->listarFacturas($fechaDesde, $fechaHasta, $idproveedor, $idEmpresaActiva);
    
    ?>
    <script src="jquery/funciones.js"></script>
    <script src="jquery/ctasCtes.js?version=<?php echo rand(1, 10000); ?>"></script>
    <div class="container border bg-white col-8">
        <div id="alerta"></div>
        <div id="formFacturas">
            <div class="row">
                <div class="shadow p-3 mb-3 bg-white rounded col-md-12 ">
                    <h5>Cuentas corrientes Proveedores</h5>
                </div>
            </div>
            
            <form action="ctasCtes.php" method="POST" class="p-2">
                <div class="shadow p-3 bg-white rounded row ">
                    <div class="col-2 form-group">
                        <label class="m-0 ml-2" for="fecha">Fecha Desde</label>
                        <input class=" col-md-10" type="text" value="<?php echo isset($_POST["fechaDesde"]) ? $fechaDesde : date('01/m/Y'); ?>" id="fechaDesde" name="fechaDesde">
                    </div>
                    <div class="col-2 form-group ">
                        <label class="m-0 ml-2" for="fecha">Fecha Hasta</label>
                        <input class=" col-md-10" type="text" value="<?php echo isset($_POST["fechaHasta"]) ? $fechaHasta : date('d/m/Y'); ?>" id="fechaHasta" name="fechaHasta">
                    </div>
                    <div class="col-3 form-group ">
                        <label class="m-0 ml-2" for="sltEmpresa">Empresa</label>
                        <select class="form-control col-md-12" id="sltempresas" name="sltempresas">
                            <option value="0"></option>
                            <?php foreach ($empresas as $empresa) { ?>
                                <option value="<?php echo $empresa["idempresa"]; ?>" <?php echo $idproveedor == $empresa["idempresa"] ? "selected" : ""; ?>><?php echo $empresa["empresa"]; ?></option>
                            <?php } ?>

                        </select>
                    </div>
                    <div class="col-1 form-group d-flex align-items-center p-0 m-0 mt-1">
                        <input class="col-10 btn btn-success" type="submit" value="Filtrar" name="enviar">
                    </div>
                </div>
            </form>
            <div class="card">
                <div class="card-body col-9">
                    <table class="table table-sm">
                        <thead>
                            <th>Fecha</th>
                            <th>Vencimiento</th>
                            <th>Empresa</th>
                            <th>Nro Factura</th>
                            <th class="text-center">Importe</th>
                        </thead>
                        <tbody>
                            <?php 
                                $saldoTotal=$saldo;
                                if($idproveedor>0) { ?>
                                    <tr class="bg-light">
                                        <td colspan="4"><strong>Saldo Anterior</strong></td>
                                        <td class="text-right"><strong><?php echo $saldo; ?></strong></td>
                                    </tr>
                                <?php } 
                                foreach ($facturas as $factura) { 
                                    $saldoTotal+=$factura["total"];
                                    ?>
                                    <tr>
                                        <td><?php echo $factura["fecha"]; ?></td>
                                        <td><?php echo $factura["vencimiento"]; ?></td>
                                        <td><?php echo $factura["empresa"]; ?></td>
                                        <td><?php echo $factura["numero"]; ?></td>
                                        <td class="text-right"><?php echo $factura["total"]; ?></td>
                                        
                                    </tr>
                                <?php } 
                                if($idproveedor>0) { ?>
                                    <tr class="bg-light">
                                        <td colspan="4"><strong>Saldo Total</strong></td>
                                        <td class="text-right"><strong><?php echo $saldoTotal; ?></strong></td>
                                    </tr>
                                <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>