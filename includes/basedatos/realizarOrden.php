<?php
    $raiz="../../";
    //include_once($raiz."/includes/controlLogin.php");
    include_once("../modelos/ordenesModelo.php");

    //actualizar ordentrabajos y dejar la orden como realizada
    $id=$_GET["idorden"];
    $accion=$_GET["accion"];
    $oOrden=new ordenesModel();

    if($accion=="agregar") //agregamos la orden a las tablas de actividades
    {
        $oOrden->realizarOrden($id);  
        $oOrden->agregarActividades($id);  
    }
    if($accion=="descartar") //agregamos la orden a las tablas de actividades
    {
        $oOrden->realizarOrden($id);
    }

?>

