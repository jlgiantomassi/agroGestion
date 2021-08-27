let idUsuarioActivo = $("#idUsuarioActivo").val();
let idempresaSel = 0;

$().ready(function () {

    $("#btnInsertarEmpresa").click(function (e) {
        e.preventDefault();
        let flag = false;
        empresa = $("#txtInsEmpresa").val();
        direccion=$("#txtInsDireccionEmpresa").val();
        cuit=$("#txtInsCuitEmpresa").val();
        productor=$("#chkproductor").prop("checked");
        contratista=$("#chkcontratista").prop("checked");
        proveedor=$("#chkproveedor").prop("checked");
        otro=$("#chkotro").prop("checked");
        $("#tblempresas tbody tr .empresa").each(function () { //buscar si el empresa se encuentra ingresado en la lista
            if ($(this).text() == empresa) {
                flag = true;
            }
        });
        if (flag)
            alert("El nombre de esta empresa ya existe");
        else
            $.ajax({
                type: "GET",
                url: "includes/ajax/ajax.php",
                data: "accion=insEmpresa&empresa=" + empresa + "&idusuario=" + idUsuarioActivo+"&direccion="+direccion+"&cuit="+cuit+"&productor="+productor+"&contratista="+contratista+"&proveedor="+proveedor+"&otro="+otro,
                dataType: "text",
                success: function (id) {
                    if (id == "false") {
                        alert("se genero un error al guardar la empresa");
                    } else {
                        location.reload();
                    }

                }
            });
    });

    $(".btnEliminarEmpresa").click(function (e) {
        e.preventDefault();
        idempresa = $(this).val();
        if (confirm("Esta seguro que desea eliminar esta empresa?")) {
            $.ajax({
                type: "GET",
                url: "includes/ajax/ajax.php",
                data: "accion=borrarEmpresa&idempresa=" + idempresa,
                dataType: "text",
                success: function (resp) {
                    if (resp)
                        location.reload();
                    else
                        alert("Se produjo un error al borrar el empresa");
                }
            });
        }
    });

    $("#btnModificarEmpresa").click(function (e) {
        e.preventDefault();
        $("#txtModificarEmpresa").attr("disabled", false);
        //empresa = $("#txtModificarEmpresa").val(); no podemos modificar el nombre de la empresa
        direccion = $("#txtModificarDireccionEmpresa").val();
        cuit=$("#txtModificarCuitEmpresa").val();
        productor=$("#chkModificarproductor").prop("checked");
        contratista=$("#chkModificarcontratista").prop("checked");
        proveedor=$("#chkModificarproveedor").prop("checked");
        otro=$("#chkModificarotro").prop("checked");
        $.ajax({
            type: "GET",
            url: "includes/ajax/ajax.php",
            data: "accion=modificarEmpresa&idempresa=" + idempresaSel+"&direccion="+direccion+"&cuit="+cuit+"&productor="+productor+"&contratista="+contratista+"&proveedor="+proveedor+"&otro="+otro,
            dataType: "text",
            success: function (dato) {
                if (dato)
                    location.reload();
                else
                    alert("Se produjo un error al modificar la empresa");
            }
        });
    });

    
});

function modificarEmpresa(id) {
    idempresaSel = id;
    $("#txtModificarEmpresa").attr("disabled", true);
    $.ajax({
        type: "GET",
        url: "includes/ajax/ajax.php",
        data: "accion=empresas&idempresa="+id,
        dataType: "json",
        success: function (datos) {
            $("#txtModificarEmpresa").val(datos[0].empresa);
            $("#txtModificarDireccionEmpresa").val(datos[0].direccion);
            $("#txtModificarCuitEmpresa").val(datos[0].cuit);
            $("#chkModificarproductor").prop("checked",datos[0].productor==1?true:false);
            $("#chkModificarcontratista").prop("checked",datos[0].contratista==1?true:false);
            $("#chkModificarproveedor").prop("checked",datos[0].proveedor==1?true:false);
            $("#chkModificarotro").prop("checked",datos[0].otro==1?true:false);
            
        }
    });
    
}
