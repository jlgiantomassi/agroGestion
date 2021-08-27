let idUsuarioActivo = $("#idUsuarioActivo").val();
let idcampoSel = 0;
let idloteSel=0;

$().ready(function () {

    $("#btnInsertarCampo").click(function (e) {
        e.preventDefault();
        let flag = false;
        campo = $("#txtInsCampo").val();
        $("#tblcampos tbody tr .campo").each(function () { //buscar si el insumo se encuentra ingresado en la lista
            if ($(this).text() == campo) {
                flag = true;
            }
        });
        if (flag)
            alert("El nombre de este campo ya existe");
        else
            $.ajax({
                type: "GET",
                url: "includes/ajax/ajax.php",
                data: "accion=insCampo&campo=" + campo + "&idusuario=" + idUsuarioActivo,
                dataType: "text",
                success: function (id) {
                    if (id == "false") {
                        alert("se genero un error al guardar el campo");
                    } else {
                        location.reload();
                    }

                }
            });
    });

    $("#btnInsertarLote").click(function (e) {
        e.preventDefault();
        let flag = false;
        lote = $("#txtInsLote").val();
        superficie=$("#txtInsSupLote").val();
        idcampo=$("#idcampo").val();
        console.log(idcampo);
        $("#tbllotes tbody tr .lote").each(function () { //buscar si el insumo se encuentra ingresado en la lista
            if ($(this).text() == lote) {
                flag = true;
            }
        });
        if (flag)
            alert("El nombre de este lote ya existe");
        else
            $.ajax({
                type: "GET",
                url: "includes/ajax/ajax.php",
                data: "accion=insLote&lote=" + lote + "&idcampo="+idcampo+"&superficie="+superficie,
                dataType: "text",
                success: function (id) {
                    if (id == "false") {
                        alert("se genero un error al guardar el lote");
                    } else {
                        location.reload();
                    }

                }
            });
    });

    $(".btnEliminarCampo").click(function (e) {
        e.preventDefault();
        idcampo = $(this).val();
        if (confirm("Esta seguro que desea eliminar este campo?")) {
            $.ajax({
                type: "GET",
                url: "includes/ajax/ajax.php",
                data: "accion=borrarCampo&idcampo=" + idcampo,
                dataType: "text",
                success: function (resp) {
                    if (resp)
                        location.reload();
                    else
                        alert("Se produjo un error al borrar el campo");
                }
            });
        }
    });

    $(".btnEliminarLote").click(function (e) {
        e.preventDefault();
        idlote = $(this).val();
        if (confirm("Esta seguro que desea eliminar este lote?")) {
            $.ajax({
                type: "GET",
                url: "includes/ajax/ajax.php",
                data: "accion=borrarLote&idlote=" + idlote,
                dataType: "text",
                success: function (resp) {
                    if (resp)
                        location.reload();
                    else
                        alert("Se produjo un error al borrar el lote");
                }
            });
        }
    });

    $("#btnModificarCampo").click(function (e) {
        e.preventDefault();
        campo = $("#txtModificarCampo").val();
        $.ajax({
            type: "GET",
            url: "includes/ajax/ajax.php",
            data: "accion=modificarCampo&idcampo=" + idcampoSel + "&campo=" + campo,
            dataType: "text",
            success: function (dato) {
                if (dato)
                    location.reload();
                else
                    alert("Se produjo un error al modificar el campo");
            }
        });
    });

    $("#btnModificarLote").click(function (e) {
        e.preventDefault();
        lote = $("#txtModificarLote").val();
        superficie=$("#txtModificarSupLote").val();
        $.ajax({
            type: "GET",
            url: "includes/ajax/ajax.php",
            data: "accion=modificarLote&idlote=" + idloteSel + "&lote=" + lote+ "&superficie=" + superficie,
            dataType: "text",
            success: function (dato) {
                if (dato)
                    location.reload();
                else
                    alert("Se produjo un error al modificar el lote");
            }
        });
    });
});

function modificarCampo(campo, id) {
    idcampoSel = id;
    $("#txtModificarCampo").val(campo);
}

function modificarLote(lote, id,superficie) {
    idloteSel = id;
    $("#txtModificarLote").val(lote);
    $("#txtModificarSupLote").val(superficie);
}