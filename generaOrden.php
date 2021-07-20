<?php
session_start();
if(isset($_SESSION["idusuario"]))
{   
    
    $idCampanaActiva = $_SESSION["idcampana"];
    $idUsuarioActivo = $_SESSION["idusuario"];
}
else{
    echo "El usuario no esta logeado";
    session_destroy();
    exit();
}

ini_set("memory_limit", "1024M");
$idordentrabajo = $_GET["idorden"];
include "conexion/conexion.php";
$query_orden = mysqli_query($con, "select o.fecha,l.labor,o.precio,o.observaciones,o.superficie from ordentrabajos as o inner join labores as l on o.idlabor=l.idlabor where o.idordentrabajo=" . $idordentrabajo);
$row = mysqli_fetch_array($query_orden);

$query_productor = mysqli_query($con, "select o.superficie,p.usuario as productor from orden_productores o inner join usuarios p on o.idproductor=p.idusuario where o.idordentrabajo=" . $idordentrabajo);
$rowProductor = mysqli_fetch_array($query_productor);
$cantProductores = mysqli_affected_rows($con);

$query_campo = mysqli_query($con, "select o.superficie,c.campo,l.lote from orden_lotes o inner join lotes l on o.idlote=l.idlote inner join campos c on l.idcampo=c.idcampo where o.idordentrabajo=" . $idordentrabajo);
$rowCampo = mysqli_fetch_array($query_campo);
$cantCampos = mysqli_affected_rows($con);

$query_insumo = mysqli_query($con, "select o.cantidadHa,o.cantidadTotal,i.insumo,u.unidad from orden_insumos o inner join insumos i on o.idinsumo=i.idinsumo inner join unidades u on i.idunidad=u.idunidad where o.idordentrabajo=" . $idordentrabajo);
$rowInsumo = mysqli_fetch_array($query_insumo);
$cantInsumos = mysqli_affected_rows($con);


require_once 'dompdf/autoload.inc.php';

//use Dompdf\Dompdf;

//ob_start();

?>

<html lang='en'>
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/estilos.css"  />
        
        <title>Orden de Trabajo</title>
    </head>
    <body>
        <h1 style="font-size: 45px; text-align: center;">Orden de Trabajo</h1>
        <div class="container border bg-white">
            <div class="row">
                <div class="col-md-9">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Labor</th>
                                <th class="text-right">Superficie Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $row['fecha']; ?></td>
                                <td><?php echo $row['labor']; ?></td>
                                <td class="text-right"><?php echo $row['superficie']; ?></td>
                            </tr>
                            <?php if($row['observaciones']!='')
                            {
                            echo "<tr>
                                <td>Observaciones</td>
                                <td colspan='2' style='border: 1px solid;'>". $row['observaciones']. "</td>
                                </tr>";
                            } ?>
                        </tbody>
                    </table>

                </div>
            </div>

            <?php if ($cantProductores > 0) { ?>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <strong>Lista de Productores</strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <table class="table" id="tblproductores">
                            <thead class="thead-light">
                                <tr>
                                    <th>Productor</th>
                                    <th class="text-right">Participacion</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php do { ?>
                                    <tr>
                                        <td><?php echo $rowProductor['productor'] ?></td>
                                        <td class="text-right"><?php echo $rowProductor['superficie'] ?></td>
                                    </tr>
                                <?php } while ($rowProductor = mysqli_fetch_array($query_productor)); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } ?>

            <?php if ($cantCampos > 0) { ?>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <strong>Lista de Campos/Lotes</strong>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-9">
                        <table class="table" id="tblcampos">
                            <thead class="thead-light">
                                <tr>
                                    <th>Campo</th>
                                    <th>Lote</th>
                                    <th class="text-right">Superficie</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php do { ?>
                                    <tr>
                                        <td><?php echo $rowCampo['campo'] ?></td>
                                        <td><?php echo $rowCampo['lote'] ?></td>
                                        <td class="text-right"><?php echo $rowCampo['superficie'] ?></td>
                                    </tr>
                                <?php } while ($rowCampo = mysqli_fetch_array($query_campo)); ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            <?php } ?>

            <?php if ($cantInsumos > 0) { ?>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <strong>Lista de Insumos</strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <table class="table" id="tblinsumos">
                            <thead class="thead-light">
                                <tr>
                                    <th>Insumo</th>
                                    <th class="text-right">Cant/ha</th>
                                    <th class="text-right">Unidad</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php do { ?>
                                    <tr>
                                        <td><?php echo $rowInsumo['insumo'] ?></td>
                                        <td class="text-right"><?php echo $rowInsumo['cantidadHa'] ?></td>
                                        <td class="text-right"><?php echo $rowInsumo['unidad'] ?></td>
                                        <td class="text-right"><?php echo $rowInsumo['cantidadTotal'] ?></td>
                                    </tr>
                                <?php } while ($rowInsumo = mysqli_fetch_array($query_insumo)); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } ?>

        </div>
    </body>
</html>
<?php

/*$html = ob_get_clean();
$dompdf = new Dompdf();

$dompdf->loadHtml($html);
$dompdf->setPaper("A4", "portrait");
$dompdf->render();
$dompdf->stream();
*/
?>