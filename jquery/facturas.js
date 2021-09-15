$().ready(iniciarEventosFacturas);
let _importe = 0;
let _iva = 0;
function iniciarEventosFacturas() {

    $('#fecha').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'dd/mm/yyyy',
        locale: 'es-es'
    });

    $('#fechaVencimiento').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'dd/mm/yyyy',
        locale: 'es-es'
    });

    $('#fecha').change(function (e) {
        e.preventDefault();
        if ($('#fecha').val() > $('#fechaVencimiento').val())
            $('#fechaVencimiento').val($('#fecha').val());
    });

    $('#fechaVencimiento').change(function (e) {
        e.preventDefault();
        if ($('#fechaVencimiento').val() < $('#fecha').val())
            $('#fechaVencimiento').val($('#fecha').val());
    });

    $("#sltinsumos").change(function (e) {
        e.preventDefault();
        $("#precioUn").val($(this).find(':selected').attr('data-precio'));
    });

    $("#btnAgregar").click(function (e) {
        e.preventDefault();
        let idinsumo = $("#sltinsumos").val();
        let insumo = $("#sltinsumos option:selected").html();
        let precioUn = $("#precioUn").val();
        let cantidad = $("#cantidadInsumo").val();
        if (cantidad == "" || cantidad == 0) {
            alert("Debe ingresar una cantidad");
        } else if (precioUn == "" || precioUn == 0) {
            alert("Debe ingresar un precio");
        } else {
            let tbl = $("#tblinsumos tbody tr .idinsumo");
            if (estaEnLaTabla(tbl, idinsumo) == false) {
                let importe = cantidad * precioUn;
                _importe += importe;
                let iva = importe * $("#txtiva").val() / 100;
                _iva += iva;
                let total = importe + iva;
                $("#tblinsumos tbody").append("<tr>\
                                        <td class='d-none idinsumo'>"+ idinsumo + "</td>\
                                        <td class='detalle'>"+ insumo + "</td>\
                                        <td class='text-right precioUn'>"+ precioUn + "</td>\
                                        <td class='text-right cantidad'>"+ cantidad + "</td>\
                                        <td class='text-right importe'>"+ importe.toFixed(2) + "</td>\
                                        <td class='text-right iva'>"+ iva.toFixed(2) + "</td>\
                                        <td class='text-right total'>"+ total.toFixed(2) + "</td>\
                                        <td class='text-center acciones'>\
                                            <a class='borrarinsumo' href='#'>\
                                            <i class='material-icons'>clear</i>\
                                        </td>\
                                    </tr>");
                actualizarResumen();
            } else {
                alert("Este insumo ya se encuentra en la lista");
            }

        }
    });

    $("#btnAgregarDetalle").click(function (e) {
        e.preventDefault();
        let idinsumo = 0;
        let insumo = $("#txtdetalle").val();
        let precioUn = parseFloat($("#precioDetalle").val());
        let cantidad = $("#cantidadDetalle").val();
        if (cantidad == "" || cantidad == 0) {
            alert("Debe ingresar una cantidad");
        } else if ($("#precioDetalle").val() == "" || precioUn == 0) {
            alert("Debe ingresar un precio");
        } else if ($("#txtdetalle").val() == "") {
            alert("Debe ingresar un Detalle");
        } else {
            let importe = cantidad * precioUn;
            _importe += importe;
            let iva = importe * $("#ivaDetalle").val() / 100;
            _iva += iva;
            let total = importe + iva;
            $("#tblinsumos tbody").append("<tr>\
                                        <td class='d-none idinsumo'>"+ idinsumo + "</td>\
                                        <td class='detalle'>"+ insumo + "</td>\
                                        <td class='text-right precioUn'>"+ precioUn.toFixed(2) + "</td>\
                                        <td class='text-right cantidad'>"+ cantidad + "</td>\
                                        <td class='text-right importe'>"+ importe.toFixed(2) + "</td>\
                                        <td class='text-right iva'>"+ iva.toFixed(2) + "</td>\
                                        <td class='text-right total'>"+ total.toFixed(2) + "</td>\
                                        <td class='text-center acciones'>\
                                            <a class='borrarinsumo' href='#'>\
                                            <i class='material-icons'>clear</i>\
                                        </td>\
                                    </tr>");
            $("#txtdetalle").val("");
            $("#precioDetalle").val("");
            $("#cantidadDetalle").val("");
            actualizarResumen();
        }
    });

    $("#btnGuardarFactura").click(function (e) {
        e.preventDefault();
        let descripcion = [];
        let d;
        let tbl = $("#tblinsumos tbody tr");
        let fecha = $("#fecha").val();
        let vencimiento = $("#fechaVencimiento").val();
        let numero = $("#nroFactura").val();
        let idproveedor = $("#sltempresas").val();
        let cant;
        let precioUn;
        let importe = 0;;
        let iva;
        let ivaTotal = 0;
        tbl.each(function () { //buscar si el insumo se encuentra ingresado en la lista
            cant = parseFloat($(this).find(".cantidad").html());
            precioUn = parseFloat($(this).find(".precioUn").html());
            iva = parseFloat($(this).find(".iva").html())
            importe += cant * precioUn;
            ivaTotal += iva;
            d = {
                idinsumo: $(this).find(".idinsumo").html(),
                detalle: $(this).find(".detalle").html(),
                cantidad: cant,
                precioUn: precioUn,
                iva: iva
            };
            descripcion.push(d);
        });
        let datos = JSON.stringify(descripcion);
        $.ajax({
            type: "POST",
            url: "includes/ajax/facturas.php",
            data: "descripcion=" + datos + "&fecha=" + fecha + "&vencimiento=" + vencimiento + "&idproveedor=" + idproveedor + "&numero=" + numero + "&importe=" + importe + "&iva=" + ivaTotal,
            dataType: "text",
            success: function (dato) {
                if (dato == false)
                    alert("Ocurrio un error al guardar la factura");
                else
                    location.reload();

            }
        });
    });

    $('#tblinsumos tbody').click(function (e) {
        if (e.target.parentNode.className == "borrarinsumo") {
            if (confirm("Desea borrar este insumo de la lista?")) {
                dato = e.target.parentNode.parentNode.parentNode
                let importe = parseFloat($(dato).find('importe'));
                let iva = parseFloat($(dato).find('iva'));
                console.log(importe);
                console.log(iva);
                _importe -= importe;
                _iva -= iva;
                $(dato).remove();
                actualizarResumen();
            }
        }
    });
}

function estaEnLaTabla(tbl, idinsumo) {
    let flag = false;
    tbl.each(function () { //buscar si el insumo se encuentra ingresado en la lista
        if ($(this).text() == idinsumo) {
            flag = true;
        }
    });
    return flag;
}

function actualizarResumen()
{
    $("#resSubtotal").html(_importe.toFixed(2));
    $("#resIva").html(_iva.toFixed(2));
    $("#resTotal").html((_importe+_iva).toFixed(2));
}