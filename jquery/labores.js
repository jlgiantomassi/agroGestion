let idUsuarioActivo = $("#idUsuarioActivo").val();
let idlaborSel = 0;

$().ready(function () {

    $("#btnInsertarLabor").click(function (e) {
        e.preventDefault();
        let flag = false;
        labor = $("#txtInsLabor").val();
        precio=$("#txtInsPrecioLabor").val();
        $("#tbllabores tbody tr .labor").each(function () { //buscar si el labor se encuentra ingresado en la lista
            if ($(this).text() == labor) {
                flag = true;
            }
        });
        if (flag)
            alert("El nombre de este labor ya existe");
        else
            $.ajax({
                type: "GET",
                url: "includes/ajax/ajax.php",
                data: "accion=insLabor&labor=" + labor + "&idusuario=" + idUsuarioActivo+"&precio="+precio,
                dataType: "text",
                success: function (id) {
                    if (id == "false") {
                        alert("se genero un error al guardar la labor");
                    } else {
                        location.reload();
                    }

                }
            });
    });

    $(".btnEliminarLabor").click(function (e) {
        e.preventDefault();
        idlabor = $(this).val();
        if (confirm("Esta seguro que desea eliminar esta labor?")) {
            $.ajax({
                type: "GET",
                url: "includes/ajax/ajax.php",
                data: "accion=borrarLabor&idlabor=" + idlabor,
                dataType: "text",
                success: function (resp) {
                    if (resp)
                        location.reload();
                    else
                        alert("Se produjo un error al borrar la labor");
                }
            });
        }
    });

    $("#btnModificarLabor").click(function (e) {
        e.preventDefault();
        labor = $("#txtModificarLabor").val();
        precio = $("#txtModificarPrecioLabor").val();
        $.ajax({
            type: "GET",
            url: "includes/ajax/ajax.php",
            data: "accion=modificarLabor&idlabor=" + idlaborSel + "&labor=" + labor+ "&precio=" + precio,
            dataType: "text",
            success: function (dato) {
                if (dato)
                    location.reload();
                else
                    alert("Se produjo un error al modificar la labor");
            }
        });
    });

    
});

function modificarLabor(id) {
    idlaborSel = id;
    $.ajax({
        type: "GET",
        url: "includes/ajax/ajax.php",
        data: "accion=labores&idlabor="+id,
        dataType: "json",
        success: function (datos) {
            $("#txtModificarLabor").val(datos[0].labor);
            $("#txtModificarPrecioLabor").val(datos[0].precio);
            
        }
    });
    
}
