<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php include_once 'includes/header.php'; ?>
    
</head>

<body>
    <?php
    $raiz = "";
    include_once 'includes/menu.php';
    include_once 'includes/funciones.php';
    include_once "includes/modelos/ordenesModelo.php";
    $realizado = 0;
    $noRealizado = 0;
    $datosOrdenes = array();
    if (isset($_POST["enviar"])) {
        $fechaDesde = $_POST["fechaDesde"];
        $fechaHasta = $_POST["fechaHasta"];
        if (isset($_POST["chkRealizado"])) {
            $realizado = 1;
        } else {
            $realizado = 0;
        }
        if (isset($_POST["chkNoRealizado"])) {
            $noRealizado = 1;
        } else {
            $noRealizado = 0;
        }
    } else {
        $fechaDesde = date("01/m/Y");
        $fechaHasta = date("d/m/Y");
    }
    if ($realizado != 0 or $noRealizado != 0) {
        
        $oOrdenes = new ordenesModel();
        $datosOrdenes = $oOrdenes->verOrdenes($idUsuarioActivo, $idCampanaActiva, $fechaDesde, $fechaHasta, $realizado, $noRealizado);
    }
    ?>

    <div class="container border bg-white">

        <div class="row">
            <div class="shadow p-3 mb-3 bg-white rounded col-md-12 ">
                <h5>Ordenes de Trabajo</h5>
            </div>
        </div>

        <form action="verOrdenes.php" method="POST">
            <div class="shadow p-3 mb-3 bg-white rounded row ">
                <div class="col-3 p-2">
                    <div class="form-check ">
                        <input class="form-check-input " type="checkbox" id="chkRealizado" name="chkRealizado" <?php echo $realizado == 1 ? "checked" : "" ?>><label class="form-check-label ">Ordenes Realizadas</label>
                    </div>
                    <div class="form-check ">
                        <input class="form-check-input " type="checkbox" id="chkNoRealizado" name="chkNoRealizado" <?php echo $noRealizado == 1 ? "checked" : "" ?>><label class="form-check-label">Ordenes No Realizadas</label>
                    </div>
                </div>
                <div class="col-2 form-group">
                    <label class="m-0" for="fecha">Fecha Desde</label>
                    <input class=" col-md-10" type="text" value="<?php echo isset($_POST["fechaDesde"]) ? $fechaDesde : date('01/m/Y'); ?>" id="fechaDesde" name="fechaDesde">
                </div>
                <div class="col-2 form-group ">
                    <label class="m-0" for="fecha">Fecha Hasta</label>
                    <input class=" col-md-10" type="text" value="<?php echo isset($_POST["fechaHasta"]) ? $fechaHasta : date('d/m/Y'); ?>" id="fechaHasta" name="fechaHasta">
                </div>
                <div class="col-1 form-group d-flex align-items-center p-0 m-0 mt-1">
                    <input class="col-10" type="submit" value="Filtrar" name="enviar">
                </div>
            </div>

        </form>
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th class="d-none" scope="col">ID</th>
                    <th class="col-1" scope="col">Fecha</th>
                    <th class="col-1" scope="col">Labores</th>
                    <th class="col-3" scope="col">Campos</th>
                    <th class="col-1" scope="col">Superf.</th>
                    <th class="col-3"scope="col">Productores</th> 
                    <th class="text-center col-3"scope="col" >Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($datosOrdenes as $row) { ?>
                    <tr>
                        <td class="d-none" scope="row"><?php echo $row["idordentrabajo"]; ?></td>
                        <td><?php echo $row["fecha"]; ?></td>
                        <td class="pl-1"><?php echo $row["labor"] ?></td>
                        <?php 
                            $campos="";
                            $lotes=$oOrdenes->verOrdenLotes($row["idordentrabajo"]);
                            foreach ($lotes as $key => $lote) {
                                $campos.=$lote["campo"]."-".$lote["lote"]." ";
                            }
                        ?>
                        <td class="pl-1"><?php echo $campos; ?></td>
                        <td><?php echo $row["superficie"] ?></td>
                        <?php 
                            $productores="";
                            $prods=$oOrdenes->verOrdenProductores($row["idordentrabajo"]);
                            foreach ($prods as $prod) {
                                $productores.=$prod["productor"]." ";
                            }
                        ?>
                        <td class="pl-1"><?php echo $productores; ?></td> 
                        <td class="text-center">
                            <button type="button" class="btn btn-primary btn-sm btn-xxs" onclick="window.open('generaOrden.php?idorden=<?php echo $row['idordentrabajo'] ?> ')">Ver Orden</button>
                            <button type="button" class="btn btn-primary btn-sm btn-xxs" onclick="window.open('generaInformeProductor.php?idorden=<?php echo $row['idordentrabajo'] ?> ')">Ver Informe</button>
                            <?php if ($row["realizado"]==0){ ?>
                            <button type="button" class="btn btn-danger btn-sm btn-xxs" data-toggle="modal" data-target="#menuEliminar" onclick="idOrden=<?php echo $row['idordentrabajo'] ?>;">Borrar</button>
                            <button type="button" class="btn btn-success btn-sm btn-xxs" onclick="realizar(<?php echo $row['idordentrabajo'] ?>)">Realizado</button>
                            <?php }?>
                        </td>
                        <?php //href="generaOrden.php?idorden=<?php echo $row['idordentrabajo'] 
                        ?>
                    </tr>
                <?php  } ?>
            </tbody>
        </table>

    </div>

    <?php
    include 'includes/footer.php';
    ?>

    <div class="modal fade" id="menuEliminar" role="dialog" aria-labelledby="menu1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="menu1">Eliminar Orden</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    Desea Eliminar esta Orden?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" onclick="window.location='includes/basedatos/borrarOrden.php?idorden='+idOrden">Borrar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#fechaDesde').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd/mm/yyyy',
            locale: 'es-es'

        });
        $('#fechaHasta').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd/mm/yyyy',
            locale: 'es-es'

        });
        function realizar(idorden){
            if(confirm("Desea agregar esta orden a la gestion de datos?"))
            {
                window.open("includes/basedatos/realizarOrden.php?idorden="+idorden+"&accion=agregar");
            }else
            {
                window.open("includes/basedatos/realizarOrden.php?idorden="+idorden+"&accion=descartar");
            }
        }
    </script>
</body>

</html>