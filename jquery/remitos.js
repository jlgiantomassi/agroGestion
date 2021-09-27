$().ready(iniciarEventosRemitos);

function iniciarEventosRemitos() {

    $('#fecha').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'dd/mm/yyyy',
        locale: 'es-es'
    });
   
    $("#btnAgregar").click(function (e) {
        e.preventDefault();
        let idinsumo = $("#sltinsumos").val();
        let insumo = $("#sltinsumos option:selected").html();
        let cantidad = $("#cantidadInsumo").val();
        if (cantidad == "" || cantidad == 0) {
            alert("Debe ingresar una cantidad");
        }
        else {
            let tbl = $("#tblinsumos tbody tr .idinsumo");
            if (estaEnLaTabla(tbl, idinsumo) == false) {
                $("#tblinsumos tbody").append("<tr>\
                                        <td class='d-none idinsumo'>"+ idinsumo + "</td>\
                                        <td>"+ insumo + "</td>\
                                        <td class='text-right cantidad'>"+ cantidad + "</td>\
                                    </tr>");
            } else {
                alert("Este insumo ya se encuentra en la lista");
            }

        }
    });

    $("#btnInsertarInsumo").click(function (e) {
        e.preventDefault();
        let flag = false;
        let insumo = $("#txtInsInsumo").val();
        let precio=0;
        let idunidad=$("#sltunidad").val();
        let slt = $("#sltinsumos option");
        if (estaEnElCombo(insumo, slt)) {
            alert("El nombre de este insumo ya existe");
        }
        else{
            $.ajax({
                type: "GET",
                url: "includes/ajax/ajax.php",
                data: "accion=insInsumos&insumo=" + insumo + "&idusuario=" + idUsuarioActivo+"&precio="+precio+"&idunidad="+idunidad,
                dataType: "text",
                success: function (id) {
                    if (id == "false") {
                        alert("se genero un error al guardar el insumo");
                    } 
                    actualizarListaInsumos();
                    

                }
            });
        }
    });

    $("#btnGuardarRemito").click(function (e) {
        e.preventDefault();
        let descripcion = [];
        let d;
        let tbl = $("#tblinsumos tbody tr");
        let fecha = $("#fecha").val();
        let numero=$("#nroRemito").val();
        let idproveedor = $("#sltempresas").val();
        tbl.each(function () { //buscar si el insumo se encuentra ingresado en la lista
            d = {
                idinsumo: $(this).find(".idinsumo").html(),
                cantidad: parseFloat($(this).find(".cantidad").html()),
            };
            descripcion.push(d);
        });
        let datos = JSON.stringify(descripcion);
        $.ajax({
            type: "POST",
            url: "includes/ajax/remitos.php",
            data: "descripcion=" + datos + "&fecha=" + fecha + "&idproveedor=" + idproveedor+"&numero="+numero,
            dataType: "text",
            success: function (dato) {
                if (dato == false)
                    alert("Ocurrio un error al guardar la factura");
                else
                    location.reload();

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

function estaEnElCombo(nombre, slt) {
    let estado = false;
    slt.each(function () {
        if ($(this).text().trim() == nombre) {
            estado = true;
        }
    });
    return estado;

}

function actualizarListaInsumos() {
    let idinsumo = 'idinsumo';
    $("#sltinsumos").empty();
    $.ajax({
        data: "accion=insumos&idinsumo=" + idinsumo,
        type: "GET",
        dataType: "json",
        url: "includes/ajax/ajax.php",
        success: function (datos) {
            if (datos.length > 0) {
                $.each(datos, function (index, valor) {
                    $("#sltinsumos").append('<option value="' + valor.idinsumo + '">' + valor.insumo + '</option>');
                });
            }
        },
        error: function () {
            alert("error de conexion");
        }
    });
}