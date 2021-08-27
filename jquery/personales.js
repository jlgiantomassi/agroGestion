let idUsuarioActivo = $("#idUsuarioActivo").val();
let idpersonalSel = 0;

$().ready(function () {

    $("#btnInsertarPersonal").click(function (e) {
        e.preventDefault();
        let flag = false;
        personal = $("#txtInsPersonal").val();
        precio=$("#txtInsPrecioHa").val();
        cuil=$("#txtInsCuil").val();
        $("#tblpersonales tbody tr .personal").each(function () { //buscar si el personal se encuentra ingresado en la lista
            if ($(this).text() == personal) {
                flag = true;
            }
        });
        if (flag)
            alert("El nombre de este personal ya existe");
        else
            $.ajax({
                type: "GET",
                url: "includes/ajax/ajax.php",
                data: "accion=insPersonal&personal=" + personal + "&idusuario=" + idUsuarioActivo+"&precioHa="+precio+"&cuil="+cuil,
                dataType: "text",
                success: function (id) {
                    if (id == "false") {
                        alert("se genero un error al guardar el personal");
                    } else {
                        location.reload();
                    }

                }
            });
    });

    $(".btnEliminarPersonal").click(function (e) {
        e.preventDefault();
        idpersonal = $(this).val();
        if (confirm("Esta seguro que desea eliminar este personal?")) {
            $.ajax({
                type: "GET",
                url: "includes/ajax/ajax.php",
                data: "accion=borrarPersonal&idpersonal=" + idpersonal,
                dataType: "text",
                success: function (resp) {
                    if (resp)
                        location.reload();
                    else
                        alert("Se produjo un error al borrar el personal");
                }
            });
        }
    });

    $("#btnModificarPersonal").click(function (e) {
        e.preventDefault();
        $("#txtPersonal").attr("disabled", true);
        personal = $("#txtPersonal").val();
        precio = $("#txtModificarPrecioHaPersonal").val();
        cuil=$("#txtModificarCuil").val();
        $.ajax({
            type: "GET",
            url: "includes/ajax/ajax.php",
            data: "accion=modificarPersonal&idpersonal=" + idpersonalSel + "&personal=" + personal+ "&precioHa=" + precio+ "&cuil=" + cuil,
            dataType: "text",
            success: function (dato) {
                if (dato)
                    location.reload();
                else
                    alert("Se produjo un error al modificar la personal");
            }
        });
    });

    
});

function modificarPersonal(id) {
    idpersonalSel = id;
    $("#txtPersonal").attr("disabled", false);
    $.ajax({
        type: "GET",
        url: "includes/ajax/ajax.php",
        data: "accion=personales&idpersonal="+id,
        dataType: "json",
        success: function (datos) {
            $("#txtPersonal").val(datos[0].personal);
            $("#txtModificarPrecioHaPersonal").val(datos[0].precioHa);
            $("#txtModificarCuil").val(datos[0].cuil);
            
        }
    });
    
}
