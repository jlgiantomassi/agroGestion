$().ready(iniciarEventosFacturas);

function iniciarEventosFacturas() {

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
                let total = cantidad * precioUn;
                $("#tblinsumos tbody").append("<tr>\
                                        <td class='d-none idinsumo'>"+ idinsumo + "</td>\
                                        <td>"+ insumo + "</td>\
                                        <td class='text-right precioUn'>"+ precioUn + "</td>\
                                        <td class='text-right cantidad'>"+ cantidad + "</td>\
                                        <td class='text-right'>"+ total.toFixed(2) + "</td>\
                                    </tr>");
            } else {
                alert("Este insumo ya se encuentra en la lista");
            }

        }
    });

    $("#btnGuardarFactura").click(function (e) {
        e.preventDefault();
        let descripcion = [];
        let d;
        let tbl = $("#tblinsumos tbody tr");
        let fecha=$("#fecha").val();
        let idempresa=$("#sltempresas").val();
        tbl.each(function () { //buscar si el insumo se encuentra ingresado en la lista
            d = {
                idinsumo: $(this).find(".idinsumo").html(),
                cantidad: parseFloat($(this).find(".cantidad").html()),
                precioUn: parseFloat($(this).find(".precioUn").html())
            };
            descripcion.push(d);
        });
        let datos=JSON.stringify(descripcion);
        $.ajax({
            type: "POST",
            url: "includes/ajax/facturas.php",
            data: "descripcion="+datos+"&fecha="+fecha+"&idempresa="+idempresa,
            dataType: "text",
            success: function (dato) {
                if(dato==false)
                    alert("Ocurrio un error al guardar la factura");

            }
        });
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