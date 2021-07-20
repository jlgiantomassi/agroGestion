<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include_once 'includes/header.php'; ?>
    </head>
    <body>
    
        <?php 
        include_once 'includes/menu.php'; 
        $query = mysqli_query($con, "select ordentrabajos.idordentrabajo as idorden,superficie as sup,fecha,labor from ordentrabajos  INNER JOIN labores on ordentrabajos.idlabor=labores.idlabor   WHERE realizado =0 and idcampana=". $idCampanaActiva ." and idusuario=". $idUsuarioActivo ." order by fecha ASC,ordentrabajos.idordentrabajo "); 
        ?>
       
        <div class="container border bg-white">

            <div class="row">
                <div class="shadow p-3 mb-3 bg-white rounded col-md-12 ">
                    <h5>Ordenes de Trabajo</h5>
                </div>
            </div>
           
                
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Labores</th>
                        <th scope="col">Superficie</th>
                        <th scope="col" class="text-center col-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                        <tr>
                            <td scope="row"><?php echo $row["idorden"] ?></td>
                            <td><?php echo $row["fecha"] ?></td>
                            <td><?php echo $row["labor"] ?></td>
                            <td><?php echo $row["sup"] ?></td> 
                            <td class="text-center col-4">
                                <button type="button" class="btn btn-primary btn-sm" onclick="window.open('generaOrden.php?idorden=<?php echo $row['idorden'] ?> ')">Ver Orden</button>
                                <button type="button" class="btn btn-primary btn-sm" onclick="window.open('generaInformeProductor.php?idorden=<?php echo $row['idorden'] ?> ')">Ver Informe</button>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#menuEliminar" onclick="idOrden=<?php echo $row['idorden'] ?>;">Borrar</button> 
                                <button type="button" class="btn btn-success btn-sm" onclick="window.location='includes/basedatos/realizarOrden.php?idorden=<?php echo $row['idorden'] ?>'">Realizado</button>
                                </td>
                            <?php //href="generaOrden.php?idorden=<?php echo $row['idordentrabajo'] ?> 
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
       
    </body>
</html>