$().ready(iniciarEventosActividades);


function iniciarEventosActividades() {
    let filaActividad = 0;
    let idcampana=0;
    let idusuario=0;
    let idcultivoSel=0;
    let idlotecampana=0;
    let idactividadSel=0; //toma los id de la tabla de actividades que se seleccionan
    let superficieSel=0 //toma las superficies de la tabla de actividades que se seleccionan
    idcampana=$("#idCampanaActiva").val();
    idusuario=$("#idUsuarioActivo").val(); //recuperamos en java los id de usuario y campana

    //cargamos los lotes a los select de lotes
    $("#sltcampos").change(function (e) {
        e.preventDefault();
        $("#supLote").val("");
        $("#sltlotes").empty();
        $("#sltlotes").append('<option value="0"></option>');
        $("#navDatos").addClass("d-none");
        $("#fldActividades").addClass("d-none");
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
        filaActividad=0;
        $("#tblactividades tbody").empty();
        $("#navDatos").addClass("d-none");
        $("#supLote").val("");
        let idlote;
        idlote = $("#sltlotes").val();
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
                                idcultivoSel=datos[0].idcultivo;
                                
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
                                                                            <td class='text-right superficie'>" + dato.superficie + "</td>\
                                                                            <td class='text-right'>" + dato.precioha * dato.superficie + "</td>\
                                                                            <td class='text-center'><a class='borrarActividad' href='#'><i class='material-icons'>clear</i></a></td>\
                                                                        </tr>");
                                        });
                                        
                                    }
                                });
                            }  
                            else
                            {
                                $("#sltcultivos").val(0);
                                idcultivoSel=0;
                                idlotecampana=0;
                            } 
                            
                        }
                    });
                } else {
                    $("#fldActividades").addClass("d-none");
                }
            },
            error: function () {
                alert("error de conexion");
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

    // al seleccionar un insumo actualizamos los datos de la ventana
    $('#sltinsumos').change(function (e) {
        e.preventDefault();
        let idinsumo;
        idinsumo = $("#sltinsumos").val();
        $.ajax({
            data: "accion=insumos&idinsumo=" + idinsumo,
            type: "GET",
            dataType: "json",
            url: "includes/ajax/ajax.php",
            success: function (datos) {
                if (datos.length > 0) {
                    $("#txtprecio").val(datos[0].precio);
                    $("#txtunidad").val(datos[0].unidad);

                }
            },
            error: function (datos) {
                alert("error de conexion");
            }
        });
    });

    // insertar un insumo a la base de datos y luego agregarlo a la tabla
    $("#btnInsertarInsumo").click(function (e) {
        e.preventDefault();
        //let total = 0;
        let idunidad = $("#sltunidad").val();
        let nombreInsumo = $("#txtInsInsumo").val();
        let slt = $("#sltinsumos option");
        if (estaEnElCombo(nombreInsumo, slt)) {
            alert("Este insumo ya existe");

        } else {
            if ($("#frmAgregarInsumo").valid()) {
                let precio = ($("#txtInsPrecio").val() == "") ? 0 : parseFloat($("#txtInsPrecio").val());
                //let cantidad = ($("#txtInsCantidadInsumo").val() == "") ? 0 : parseFloat($("#txtInsCantidadInsumo").val());

                $.ajax({
                    data: "accion=insInsumos&idunidad=" + idunidad + "&insumo=" + nombreInsumo + "&precio=" + precio,
                    type: "GET",
                    dataType: "text",
                    url: "includes/ajax/ajax.php",
                    success: function (datos) {
                        if (datos != "false") {
                            //var idinsumo = parseInt(datos);
                            $("#modalInsertarInsumo").hide();
                            $("#modalInsertarInsumo").modal('hide');
                            actualizarListaInsumos();
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
            idlabor = parseInt($("#sltlabores option:selected").val());
            
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
                                                    <td class='text-right superficie'>" + superficie + "</td>\
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

    //al hacer click en la tabla de actividades se selecciona una actividad y actualiza el resto de las tablas correspondientes
    $('#tblactividades tbody').click(function (e) { 
        //console.log(e.target.parentNode.className);
        
        if(e.target.parentNode.className=="borrarActividad")
            {
                if(confirm("Desea borrar esta actividad?"))
                {
                    dato=e.target.parentNode.parentNode.parentNode
                    idactividadSel= $(dato).children().html();
                    $.ajax({
                        type: "GET",
                        url: "includes/ajax/actividades.php",
                        data: "accion=borrar&idactividad="+idactividadSel,
                        dataType: "text",
                        success: function (id) {
                            if(id)
                            {
                            $(dato).remove();
                            $("#navDatos").addClass("d-none");
                            idactividadSel=0;
                            superficieSel=0;
                            }else{
                                alert("Hubo un error al borrar la actividad");
                            }
                        }
                    });       
                } 
            }else
            {
                dato=e.target.parentNode
                idactividadSel= $(dato).children().html();  //es lo mismo que -> console.log(dato.children[0].innerHTML);
                superficieSel=$(dato).find(".superficie").html();
                $('#tblactividades tbody tr').removeClass("table-active");
                dato.className="table-active";
                $("#navDatos").removeClass("d-none");
                actualizarListaInsumosActividades(idactividadSel);
                actualizarListaMaquinariaActividades(idactividadSel);
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
    

    $("#btnAgregarInsumo").click(function (e) { 
        e.preventDefault();
        let precio=$("#txtprecio").val();
        let cantidadha=$("#txtcantidadInsumo").val();
        let idinsumo=$("#sltinsumos").val();
        let insumo=$("#sltinsumos option:selected").html();
        $.ajax({
            type: "GET",
            url: "includes/ajax/actividades.php",
            data: "accion=insertarInsumo&idactividad="+idactividadSel+"&superficie="+superficieSel+"&precio="+precio+"&cantidadha="+cantidadha+"&idinsumo="+idinsumo,
            dataType: "text",
            success: function (id) {
                $("#tblinsumos tbody").append("<tr>\
                                                    <td class='d-none idactividadinsumo'>" + id + "</td>\
                                                    <td class='d-none'>" + idinsumo + "</td>\
                                                    <td>" + insumo + "</td>\
                                                    <td class='text-right'>" + precio + "</td>\
                                                    <td class='text-right'>" + cantidadha + "</td>\
                                                    <td class='text-right superficie'>" + superficieSel*cantidadha + "</td>\
                                                    <td class='text-right'>" + superficieSel*cantidadha*precio + "</td>\
                                                    <td class='text-center'><a class='borrarActividad' href='#'><i class='material-icons'>clear</i></a></td>\
                                                </tr>");
                },
                error: function(){
                    alert("ocurrio un error al guardar la actividad");
                }
            
        });
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

//busca en un combo slt si esta el elemento nombre
function estaEnElCombo(nombre, slt) {
    let estado = false;
    slt.each(function () {
        if ($(this).text().trim() == nombre) {
            estado = true;
        }
    });
    return estado;
}

//actualiza la lista de insumos en la tabla de insumos correspondiente a una actividad
function actualizarListaInsumosActividades(idactividad){
    $("#tblinsumos tbody").empty();
    $.ajax({
        type: "GET",
        url: "includes/ajax/actividades.php",
        data: "accion=listaInsumos&idactividad="+idactividad,
        dataType: "json",
        success: function (datos) {
            datos.forEach(dato => {
                $("#tblinsumos tbody").append("<tr class='table-sm'>\
                                            <td class='d-none idactividad_insumo'>" + dato.idactividad_insumo + "</td>\
                                            <td class='d-none'>" + dato.idinsumo + "</td>\
                                            <td>" + dato.insumo + "</td>\
                                            <td class='text-right'>" + dato.precio + "</td>\
                                            <td class='text-right'>" + dato.cantidadHa + "</td>\
                                            <td class='text-right'>" + dato.cantidadTotal + "</td>\
                                            <td class='text-right'>" + dato.precio * dato.cantidadTotal + "</td>\
                                            <td class='text-center'><a class='borrarActividad' href='#'><i class='material-icons'>clear</i></a></td>\
                                        </tr>");
            });
        }
    });
}

//actualiza la lista de insumos de la ventana modal
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

//actualiza la lista de maquinarias en la tabla de maquinarias correspondiente a una actividad
function actualizarListaMaquinariaActividades(idactividad){

}