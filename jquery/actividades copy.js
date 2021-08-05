$().ready(iniciarEventosActividades);


function iniciarEventosActividades() {
    let filaActividad = 0;
    let idcampana=0;
    let idusuario=0;
    let idcultivoSel=0;
    let idlotecampana=0;
    idcampana=$("#idCampanaActiva").val();
    idusuario=$("#idUsuarioActivo").val(); //recuperamos en java los id de usuario y campana

    //cargamos los lotes a los select de lotes
    $("#sltcampos").change(function (e) {
        e.preventDefault();
        $("#supLote").val("");
        $("#sltlotes").empty();
        $("#sltlotes").append('<option value="0"></option>');
        let idcampo = $("#sltcampos").val();
        $.ajax({
            type: "GET",
            url: "includes/ajax/ajax.php",
            data: "accion=campos&idcampo=" + idcampo,
            dataType: "json",
            success: function (datos) {
                if (datos.length > 0) {
                    //$("#supLote").val(datos[0].superficie);
                    $.each(datos, function (index, valor) {
                        $("#sltlotes").append('<option value="' + valor.idlote + '">' + valor.lote + '</option>');
                    });
                }
            },
            error: function () {
                alert("error de conexion");
            }
        });
    });

    //cargamos los datos de los lotes, el cultivo de la campana y las actividades guardadas
    $('#sltlotes').change(function (e) {
        e.preventDefault();
        $("#supLote").val("");
        let idlote;
        idlote = $("#sltlotes").val();
        console.log("entro 1");
        $.ajax({  //cargamos datos del lote
            data: "accion=lotes&idlote=" + idlote,
            type: "GET",
            dataType: "json",
            url: "includes/ajax/ajax.php",
            success: function (datos) {
                if (datos.length > 0) {
                    $("#supLote").val(datos[0].superficie);
                    $("#txtsupActividad").val(datos[0].superficie);
                    $("#fldActividades").removeClass("d-none");
                } else {
                    $("#fldActividades").addClass("d-none");
                }
            },
            error: function () {
                alert("error de conexion");
            }
        });
        console.log("entro 2");
        $.ajax({  //buscamos si esta definido el cultivo para el lote de la campana actual y el usuario
            type: "GET",
            url: "includes/ajax/ajax.php",
            data: "accion=loteCultivo&idlote=" + idlote +"&idusuario="+idusuario+"&idcampana="+idcampana,
            dataType: "json",
            success: function (datos) {
                if(datos.length>0)
                {
                    $("#sltcultivos").val(datos[0].idcultivo);
                    idlotecampana=datos[0].idloteCampana;
                    console.log("entro 2b: "+idlotecampana);
                    idcultivoSel=datos[0].idcultivo;
                }  
                else
                {
                    $("#sltcultivos").val(0);
                    idcultivoSel=0;
                    idlotecampana=0;
                } 
                
            }
        });
        
        console.log("entro 3: "+idlotecampana);
        filaActividad=0;
        //$("#tblactividades tbody").empty();
        
        $.ajax({
            type: "GET",
            url: "includes/ajax/actividades.php",
            data: "accion=cargar&idlotecampana="+idlotecampana,
            dataType: "json",
            success: function (datos) {
                //filaActividad += 1;
                datos.forEach(dato => {
                    $("#tblactividades tbody").append("<tr>\
                                                    <td class='d-none idactividad'>" + dato.idactividad + "</td>\
                                                    <td>" + dato.fecha + "</td>\
                                                    <td>" + dato.labor + "</td>\
                                                    <td class='text-right'>" + dato.precioha + "</td>\
                                                    <td class='text-right'>" + dato.superficie + "</td>\
                                                    <td class='text-right'>" + dato.precioha * dato.superficie + "</td>\
                                                    <td class='text-center'><a class='borrarActividad' href='#'><i class='material-icons'>clear</i></a></td>\
                                                </tr>");
                });
                
            }
        });
        
    });

    $('#sltlabores').change(function (e) {
        e.preventDefault();
        $("#txtPrecioLabor").val("");
        let idlabor = $("#sltlabores").val();
        $.ajax({
            data: "accion=labores&idlabor=" + idlabor,
            type: "GET",
            dataType: "json",
            url: "includes/ajax/ajax.php",
            success: function (datos) {

                if (datos.length > 0) {
                    $("#txtPrecioLabor").val(datos[0].precio);
                }
            },
            error: function () {
                alert("error de conexion al buscar productores");
            }
        });
    });

    $("#btnInsertarCampo").click(function (e) {
        e.preventDefault();
        let nombreCampo = $("#txtInsCampo").val();
        let slt = $("#sltcampos option");
        if (estaEnElCombo(nombreCampo, slt)) {
            alert("Este Campo ya existe");

        } else {
            if ($("#frmAgregarCampo").valid()) {
                $.ajax({
                    data: "accion=insCampo&campo=" + nombreCampo,
                    type: "GET",
                    dataType: "text",
                    url: "includes/ajax/ajax.php",
                    success: function (datos) {
                        if (datos != "false") {
                            $("#modalInsertarCampo").hide();
                            $("#modalInsertarCampo").modal('hide');
                            actualizarListaCampos();
                        } else {
                            alert(datos);
                        }
                    },
                    error: function () {
                        alert("error de conexion al tratar de agregar un campo a la BD");
                    }
                });
            }
        }
    });


    $("#btnInsertarLote").click(function (e) {
        e.preventDefault();
        let idcampo = $("#sltcampos").val();
        let nombreLote = $("#txtInsLote").val();
        let slt = $("#sltlotes option");
        if (estaEnElCombo(nombreLote, slt)) {
            alert("Este Lote ya existe");

        } else {
            if ($("#frmAgregarLote").valid()) {

                let superficie = ($("#txtInsSupLote").val() == "") ? 0 : parseFloat($("#txtInsSupLote").val());

                $.ajax({
                    data: "accion=insLote&idcampo=" + idcampo + "&lote=" + nombreLote + "&superficie=" + superficie,
                    type: "GET",
                    dataType: "text",
                    url: "includes/ajax/ajax.php",
                    success: function (datos) {
                        if (datos != "false") {
                            $("#modalInsertarLote").hide();
                            $("#modalInsertarLote").modal('hide');
                            actualizarListaLotes(idcampo, datos);
                        } else {
                            alert(datos);
                        }
                    },
                    error: function () {
                        alert("error de conexion");
                    }
                });
            }
        }
    });

    //agrega una actividad al presionar el boton de agregar en el modal de labores
    $('#btnAgregarLabor').click(function (e) {
        e.preventDefault();
        //validar campos
        if ($("#frmlabores").valid()) {
            let idlabor = 0;
            let nombreLabor = $("#sltlabores option:selected").text();
            let fechaActividad = $("#fecha").val();
            let precioHa = ($("#txtPrecioLabor").val() == "") ? 0 : parseFloat($("#txtPrecioLabor").val());
            let superficie = ($("#txtsupActividad").val() == "") ? 0 : parseFloat($("#txtsupActividad").val());
            let idlotecampana=$("#idlotecampana").val();
            idlabor = parseInt($("#sltlabores option:selected").val());
            //id='filaActividad" + filaActividad + "'
            
            $.ajax({
                type: "GET",
                url: "includes/ajax/actividades.php",
                data: "accion=guardar&idlotecampana="+idlotecampana+"&idlabor="+idlabor+"&fecha="+fechaActividad+"&precioha="+precioHa+"&superficie="+superficie,
                dataType: "text",
                success: function (id) {
                    filaActividad += 1;
                    $("#tblactividades tbody").append("<tr>\
                                                    <td class='d-none idactividad'>" + id + "</td>\
                                                    <td class='d-none'>" + idlabor + "</td>\
                                                    <td>" + fechaActividad + "</td>\
                                                    <td>" + nombreLabor + "</td>\
                                                    <td class='text-right'>" + precioHa + "</td>\
                                                    <td class='text-right'>" + superficie + "</td>\
                                                    <td class='text-right'>" + precioHa * superficie + "</td>\
                                                    <td class='text-center'><a class='borrarActividad' href='#'><i class='material-icons'>clear</i></a></td>\
                                                </tr>");
                },
                error: function(){
                    alert("ocurrio un error al guardar la actividad");
                }
            });
            
            
        } //fin validar campos
    });

    $('#tblactividades tbody').click(function (e) { 
        console.log(e.target.parentNode.className);
        if(e.target.parentNode.className=="borrarActividad")
            {
                alert("Desea borrar esta actividad?");
            }else
            {
                $('#tblactividades tbody tr').removeClass("table-active");
                dato=e.target.parentNode
                dato.className="table-active";
                $("#idActividad").val($(dato).children().html());  //es lo mismo que -> console.log(dato.children[0].innerHTML);
                $("#navDatos").removeClass("d-none");
                actualizarListaActividades();
            }
    });

    $('#tblactividades thead').click(function (e) { 
        $('#tblactividades tbody tr').removeClass("table-active");
        $("#idActividad").val(0);
        $("#navDatos").addClass("d-none");
        actualizarListaActividades();
    });

    $("#sltcultivos").change(function (e) { 
        e.preventDefault();
        let idcultivo=$("#sltcultivos").val();
        let idlote=$("#sltlotes").val();
        if(idcultivoSel==0)
        {
            
            $.ajax({
                type: "GET",
                url: "includes/ajax/ajax.php",
                data: "accion=loteCultivoGuardar&idlote=" + idlote +"&idusuario="+idusuario+"&idcampana="+idcampana+"&idcultivo="+idcultivo,
                dataType: "json",
                success: function (datos) {
                    idlotecampana=datos;
                }
            });
        }else{
            if (confirm("Desea cambiar el cultivo de la campaña para este lote?") == true) {
                $.ajax({
                    type: "GET",
                    url: "includes/ajax/ajax.php",
                    data: "accion=loteCultivoModificar&idlote=" + idlote +"&idusuario="+idusuario+"&idcampana="+idcampana+"&idcultivo="+idcultivo,
                    dataType: "json",
                    success: function (datos) {
                        
                    }
                });
            } else {
                $("#sltcultivos").val(idcultivoSel);    
            }
            
            
        }
    });
    
}//fin iniciar eventos actividades

function actualizarListaLotes(idcampo, idlote) {
    $("#sltlotes").empty();
    $("#sltlotes").append('<option value="0"></option>');
    $.ajax({
        data: "accion=campos&idcampo=" + idcampo,
        type: "GET",
        dataType: "json",
        url: "includes/ajax/ajax.php",
        success: function (datos) {
            if (datos.length > 0) {
                $.each(datos, function (index, valor) {
                    if (parseInt(idlote) == valor.idlote) {
                        var sel = "selected";
                        $("#supLote").val(valor.superficie);
                    }
                    $("#sltlotes").append('<option value="' + valor.idlote + '" ' + sel + '>' + valor.lote + '</option>');

                });
            }
        },
        error: function () {
            alert("error de conexion");
        }
    });
}

function actualizarListaCampos() {
    $("#sltcampos").empty();
    $("#sltcampos").append('<option value="0"></option>');
    $.ajax({
        data: "accion=todosCampos",
        type: "GET",
        dataType: "json",
        url: "includes/ajax/ajax.php",
        success: function (datos) {
            if (datos.length > 0) {
                $.each(datos, function (index, valor) {
                    $("#sltcampos").append('<option value="' + valor.idcampo + '">' + valor.campo + '</option>');
                });
            }
        },
        error: function () {
            alert("error de conexion al actualizar la lista de campos");
        }
    });
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

function actualizarListaActividades(){

}