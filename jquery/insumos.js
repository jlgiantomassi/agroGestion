let idUsuarioActivo = $("#idUsuarioActivo").val();
let idinsumoSel = 0;

$().ready(function () {

    $("#btnInsertarInsumo").click(function (e) {
        e.preventDefault();
        let flag = false;
        insumo = $("#txtInsInsumo").val();
        precio=$("#txtInsPrecio").val();
        idunidad=$("#sltunidad").val();
        $("#tblinsumos tbody tr .insumo").each(function () { //buscar si el insumo se encuentra ingresado en la lista
            if ($(this).text() == insumo) {
                flag = true;
            }
        });
        if (flag)
            alert("El nombre de este insumo ya existe");
        else
            $.ajax({
                type: "GET",
                url: "includes/ajax/ajax.php",
                data: "accion=insInsumos&insumo=" + insumo + "&idusuario=" + idUsuarioActivo+"&precio="+precio+"&idunidad="+idunidad,
                dataType: "text",
                success: function (id) {
                    if (id == "false") {
                        alert("se genero un error al guardar el insumo");
                    } else {
                        location.reload();
                    }

                }
            });
    });

    $(".btnEliminarInsumo").click(function (e) {
        e.preventDefault();
        idinsumo = $(this).val();
        if (confirm("Esta seguro que desea eliminar este insumo?")) {
            $.ajax({
                type: "GET",
                url: "includes/ajax/ajax.php",
                data: "accion=borrarInsumo&idinsumo=" + idinsumo,
                dataType: "text",
                success: function (resp) {
                    if (resp)
                        location.reload();
                    else
                        alert("Se produjo un error al borrar el insumo");
                }
            });
        }
    });

    $("#btnModificarInsumo").click(function (e) {
        e.preventDefault();
        insumo = $("#txtModificarInsumo").val();
        precio = $("#txtModificarPrecio").val();
        idunidad=$("#sltModifcarUnidad").val();
        $.ajax({
            type: "GET",
            url: "includes/ajax/ajax.php",
            data: "accion=modificarInsumo&idinsumo=" + idinsumoSel + "&insumo=" + insumo+ "&precio=" + precio+ "&idunidad=" + idunidad,
            dataType: "text",
            success: function (dato) {
                if (dato)
                    location.reload();
                else
                    alert("Se produjo un error al modificar el insumo");
            }
        });
    });

    
});

function modificarInsumo(id) {
    idinsumoSel = id;
    $.ajax({
        type: "GET",
        url: "includes/ajax/ajax.php",
        data: "accion=insumos&idinsumo="+id,
        dataType: "json",
        success: function (datos) {
            $("#txtModificarInsumo").val(datos[0].insumo);
            $("#txtModificarPrecio").val(datos[0].precio);
            $("#sltModifcarUnidad option[value='"+datos[0].idunidad+"']").attr("selected",true);
        }
    });
    
}
