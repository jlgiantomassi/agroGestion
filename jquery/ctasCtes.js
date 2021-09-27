$().ready(iniciarEventosFacturas);


function iniciarEventosFacturas() {

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

    $('#fechaDesde').change(function (e) {
        e.preventDefault();
        if (comparaFechasdmY($('#fechaDesde').val(),$('#fechaHasta').val())==true)
            $('#fechaHasta').val($('#fechaDesde').val());
    });

    $('#fechaHasta').change(function (e) {
        e.preventDefault();
        if (comparaFechasdmY($('#fechaDesde').val(),$('#fechaHasta').val())==true)
            $('#fechaHasta').val($('#fechaDesde').val());
    });
}