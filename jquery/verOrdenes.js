$(document).ready(iniciarEventos());

function iniciarEventos()
{
    
}

function actualizarOrdenes()
{
    $.ajax({
        type: "GET",
        url: "includes/ajax/ajax.php",
        data: "accion=listarOrdenes&realizados="+realizados+"&noRealizados="+noRealizados+"&fechaDesde="+fechaDesde+"&fechaHasta="+fechaHasta,
        dataType: "json",
        success: function () {
            
        }
    });
}