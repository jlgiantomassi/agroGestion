$().ready(iniciarEventosActividades);
let tipoMaquinaria=0;
let idcampana=0;
let idusuario=0;
let idcultivoSel=0;
let idlotecampana=0;
let idactividadSel=0; //toma los id de la tabla de actividades que se seleccionan
let superficieSel=0 //toma las superficies de la tabla de actividades que se seleccionan
let idinsumoSel=0;
let idactividadInsumoSel=0;
let idactividadPersonalSel =0;

function iniciarEventosActividades() {
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
                                        datos.forEach(dato => {
                                            $("#tblactividades tbody").append("<tr>\
                                                                            <td class='d-none idactividad'>" + dato.idactividad + "</td>\
                                                                            <td class='fechaActividad'>" + dato.fecha + "</td>\
                                                                            <td class='actividad'>" + dato.labor + "</td>\
                                                                            <td class='text-right precioHa'>" + dato.precioha + "</td>\
                                                                            <td class='text-right superficie'>" + dato.superficie + "</td>\
                                                                            <td class='text-right'>" + dato.precioha * dato.superficie + "</td>\
                                                                            <td class='text-center'>\
                                                                                <a class='modificarActividad' href='#' data-toggle='modal' data-target='#modalModificarLabor' data-whatever=''>\
                                                                                    <i class='material-icons'>create</i>\
                                                                                </a>\
                                                                                <a class='borrarActividad' href='#'>\
                                                                                    <i class='material-icons'>clear</i>\
                                                                                </a>\
                                                                            </td>\
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
                    $("#tblactividades tbody").append("<tr>\
                                                    <td class='d-none idactividad'>" + id + "</td>\
                                                    <td class='d-none'>" + idlabor + "</td>\
                                                    <td class='fechaActividad'>" + fechaActividad + "</td>\
                                                    <td class='actividad'>" + nombreLabor + "</td>\
                                                    <td class='text-right precioHa'>" + precioHa + "</td>\
                                                    <td class='text-right superficie'>" + superficie + "</td>\
                                                    <td class='text-right'>" + precioHa * superficie + "</td>\
                                                    <td class='text-center'>\
                                                        <a class='modificarActividad' href='#' data-toggle='modal' data-target='#modalModificarLabor' data-whatever=''>\
                                                            <i class='material-icons'>create</i>\
                                                        </a>\
                                                        <a class='borrarActividad' href='#'>\
                                                            <i class='material-icons'>clear</i>\
                                                        </a>\
                                                    </td>\
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
        switch (e.target.parentNode.className) {
            case "borrarActividad":
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
                break;
            case "modificarActividad":
                dato=e.target.parentNode.parentNode.parentNode;
                idactividadSel= $(dato).children().html();
                superficieSel=$(dato).find(".superficie").html();
                $("#txtActividadModificar").val($(dato).find(".actividad").html());
                $("#txtFechaActividadModificar").val($(dato).find(".fechaActividad").html());
                $("#txtPrecioActividadModificar").val($(dato).find(".precioHa").html());
                $("#txtSupActividadModificar").val($(dato).find(".superficie").html());  
            break;
            default:
                dato=e.target.parentNode
                idactividadSel= $(dato).children().html();  //es lo mismo que -> console.log(dato.children[0].innerHTML);
                superficieSel=$(dato).find(".superficie").html();
                $('#tblactividades tbody tr').removeClass("table-active");
                dato.className="table-active";
                $("#navDatos").removeClass("d-none");
                actualizarListaInsumosActividades(idactividadSel);
                actualizarListaMaquinariaActividades(idactividadSel);
                break;
        }
    });

    $('#tblactividades thead').click(function (e) { 
        //tipoMaquinaria=0;
        $('#tblactividades tbody tr').removeClass("table-active");
        $("#idActividad").val(0);
        $("#navDatos").addClass("d-none");
        actualizarListaInsumosActividades();
    });

    $("#tblinsumos").click(function (e) { 
        e.preventDefault();
        switch (e.target.parentNode.className) {
            case "borrarInsumo":
                if(confirm("Desea borrar este insumo?"))
                {
                    dato=e.target.parentNode.parentNode.parentNode;
                    idinsumoSel= $(dato).children().html();
                    $.ajax({
                        type: "GET",
                        url: "includes/ajax/actividades.php",
                        data: "accion=borrarInsumo&idactividad_insumo="+idinsumoSel,
                        dataType: "text",
                        success: function (id) {
                            if(id)
                            {
                            $(dato).remove();
                            //$("#navDatos").addClass("d-none");
                            idinsumoSel=0;
                            }else{
                                alert("Hubo un error al borrar la actividad");
                            }
                        }
                    });       
                } 
            break;
            
            case "modificarInsumo":
                dato=e.target.parentNode.parentNode.parentNode;
                idactividadInsumoSel= $(dato).find(".idactividad_insumo").html();
                $("#txtinsumoactividad").val($(dato).find(".insumo").html());
                $("#txtprecioInsumoActividad").val($(dato).find(".precio").html());
                $("#txtcantidadInsumoActividad").val($(dato).find(".cantidadHa").html());
                $("#txtcantidadInsumoTotal").val($(dato).find(".cantidadTotal").html());
            break;
        }
    });

    $("#tblpersonales").click(function (e) { 
        e.preventDefault();
        switch (e.target.parentNode.className) {
            case "modificarPersonal":
                dato=e.target.parentNode.parentNode.parentNode;
                idactividadPersonalSel= $(dato).find(".idactividad_personal").html();
                $("#txtPersonal").val($(dato).find(".personal").html());
                $("#txtModificarPrecioHaPersonal").val($(dato).find(".precioHaPersonal").html());
            break;
            case "borrarPersonal":
                if(confirm("Desea borrar este personal de la lista?"))
                {
                    dato=e.target.parentNode.parentNode.parentNode;
                    idactividadPersonalSel= $(dato).children().html();
                    $.ajax({
                        type: "GET",
                        url: "includes/ajax/actividades.php",
                        data: "accion=borrarPersonal&idactividad_personal="+idactividadPersonalSel,
                        dataType: "text",
                        success: function (id) {
                            if(id)
                            {
                            $(dato).remove();
                            //$("#navDatos").addClass("d-none");
                            idactividadPersonalSel=0;
                            }else{
                                alert("Hubo un error al borrar la actividad");
                            }
                        }
                    });       
                } 
            break;
        }
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
        let nombreInsumo = $("#sltinsumos option:selected").val();
        let flag=false;
        if($("#txtcantidadInsumo").val()==''){
            alert("Debe ingresar la cantidad por ha");
            return;
        }
        if($("#txtprecio").val()==''){
            alert("Debe ingresar el precio del insumo");
            return;
        }
        
            $("#tblinsumos tbody tr .idinsumo").each(function () { //buscar si el insumo se encuentra ingresado en la lista
                if($(this).text()==nombreInsumo)
                {
                    flag=true;
                }
                
            });
        if(flag){
            alert("Este insumo ya se encuentra en la lista");
        }else{
            
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
                    actualizarListaInsumosActividades(idactividadSel)
                    },
                    error: function(){
                        alert("ocurrio un error al guardar la actividad");
                    }
                
            });
        }
    });

    $("#btnModificarInsumo").click(function (e) { 
        e.preventDefault();
        let precio=$("#txtprecioInsumoActividad").val();
        let cantidadHa=$("#txtcantidadInsumoActividad").val();
        let cantidadTotal=$("#txtcantidadInsumoTotal").val();
        $.ajax({
            type: "GET",
            url: "includes/ajax/actividades.php",
            data: "accion=modificarInsumo&idactividad_insumo="+idactividadInsumoSel+"&precio="+precio+"&cantidadHa="+cantidadHa+"&cantidadTotal="+cantidadTotal,
            dataType: "text",
            success: function (datos) {
                if(datos==1)
                {
                    actualizarListaInsumosActividades(idactividadSel);
                }else
                {
                    alert("Hubo un error al modificar los datos");
                }
                
            },
            error: function(){
                alert("hubo un error al modificar los datos");
            }
        });
        $("#txtprecioInsumoActividad").val("");
        $("#txtcantidadInsumoActividad").val("");
        $("#txtinsumoactividad").val("");
        $("#modalInsumoActividad").hide();
        $("#modalInsumoActividad").modal('hide');

    });

    $("#btnModficarPersonal").click(function (e) { 
        e.preventDefault();
        let precioHa=$("#txtModificarPrecioHaPersonal").val();
        $.ajax({
            type: "GET",
            url: "includes/ajax/actividades.php",
            data: "accion=modificarPersonal&idactividad_personal="+idactividadPersonalSel+"&precioHa="+precioHa,
            dataType: "text",
            success: function (datos) {
                if(datos==1)
                {
                    actualizarListaPersonalesActividades(idactividadSel);
                }else
                {
                    alert("Hubo un error al modificar los datos");
                }
            }
        });
        $("#modalModificarPersonal").hide();
        $("#modalModificarPersonal").modal('hide');
    });

    $("#btnModificarActividad").click(function (e) { 
        e.preventDefault();
        $("#modalModificarLabor").hide();
        $("#modalModificarLabor").modal('hide');
        superficie=$("#txtSupActividadModificar").val();
        precioHa=$("#txtPrecioActividadModificar").val();
        fecha=$("#txtFechaActividadModificar").val();
        $.ajax({
            type: "GET",
            url: "includes/ajax/actividades.php",
            data: "accion=modificar&idactividad="+idactividadSel+"&fecha="+fecha+"&superficie="+superficie+"&precioHa="+precioHa,
            dataType: "text",
            success: function (datos) {
                if(datos==0)
                    alert("Ocurrio un error al modificar la actividad");
                else
                    $("#sltlotes").change();

            },
            error: function(){
                alert("Ocurrio un error al modificar la actividad");
            }
        });
        
        if(superficieSel!=superficie)
        {
            if(confirm("Desea actualizar la lista de insumos?"))
            {
                $.ajax({
                    type: "GET",
                    url: "includes/ajax/actividades.php",
                    data: "accion=modificarInsumosDeActividad&idactividad="+idactividadSel+"&superficie="+superficie,
                    dataType: "text",
                    success: function (datos) {
                        if(datos)
                        {
                            actualizarListaInsumosActividades(idactividadSel);
                        }else{
                            alert("Ocurrio un error al actualizar la base de datos");
                        }
                    }
                });
            }else
            {
                alert("Puede cambiar los valores de los insumos manualmente de acuerdo a las necesidades");
            }
        }
    });

    $("input:radio[name='maquinaria']").change(function(e){
        e.preventDefault();
        opt=$("input:radio[name='maquinaria']:checked").val(); //sacamos el valor de la opcion seleccionada
        if(tipoMaquinaria==0)
        {
            $.ajax({
                type: "GET",
                url: "includes/ajax/actividades.php",
                data: "accion=guardarTipoMaquinaria&idactividad="+idactividadSel+"&tipoMaquinaria="+opt,
                dataType: "text",
                success: function (datos) {
                    if(datos==0)
                        alert("Ocurrio un error al guardar los datos");
                },
                error: function(){
                    alert("Ocurrio un error al guardar los datos");
                }
            });
        }else
        {
            if(confirm("Desea cambiar el tipo maquinaria? Si confirma se eliminaran todos los datos cargados anteriormente"))
            {
                $.ajax({
                    type: "GET",
                    url: "includes/ajax/actividades.php",
                    data: "accion=guardarTipoMaquinaria&idactividad="+idactividadSel+"&tipoMaquinaria="+opt,
                    dataType: "text",
                    success: function (datos) {
                        if(datos==0)
                            alert("Ocurrio un error al guardar los datos");
                        else
                        actualizarListaMaquinariaActividades(idactividadSel);
                    },
                    error: function(){
                        alert("Ocurrio un error al guardar los datos");
                    }
                });
                
            }
        }
    });

    $("#btnAgregarPersonal").click(function (e) { 
        e.preventDefault();
        let idpersonal=$("#sltpersonales").val();
        let precioHa=$("#txtPrecioHa").val();
        $.ajax({
            type: "GET",
            url: "includes/ajax/actividades.php",
            data: "accion=agregarPersonal&idactividad="+idactividadSel+"&idpersonal="+idpersonal+"&precioHa="+precioHa,
            dataType: "json",
            success: function (datos) {
                    actualizarListaPersonalesActividades(idactividadSel);
            }
        });
    });
}//fin iniciar eventos actividades




//funciones complementarias
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
                                            <td class='d-none idinsumo'>" + dato.idinsumo + "</td>\
                                            <td class='insumo'>" + dato.insumo + "</td>\
                                            <td class='text-right precio'>" + dato.precio + "</td>\
                                            <td class='text-right cantidadHa'>" + dato.cantidadHa + "</td>\
                                            <td class='text-right cantidadTotal'>" + dato.cantidadTotal + "</td>\
                                            <td class='text-right precioTotal'>" + (dato.precio * dato.cantidadTotal).toFixed(2) + "</td>\
                                            <td class='text-center'>\
                                                <a class='modificarInsumo' href='#' data-toggle='modal' data-target='#modalInsumoActividad' data-whatever=''>\
                                                    <i class='material-icons'>create</i>\
                                                </a>\
                                                <a class='borrarInsumo' href='#'>\
                                                    <i class='material-icons'>clear</i>\
                                                </a>\
                                            </td>\
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
    $.ajax({
        type: "GET",
        url: "includes/ajax/actividades.php",
        data: "accion=tipoMaquinaria&idactividad="+idactividad,
        dataType: "json",
        success: function (datos) {
            tipoMaquinaria=datos[0].maquinaria;
            if(datos[0].maquinaria==1) //si la maquinaria es contratada
            {
                $("#maquinariaContratada").prop("checked", true);
                $("#tblMaquinaria").addClass("d-none");
                $("#tblContratistas").removeClass("d-none");
                //actualizarTerceros(idactividad);
            }
            if(datos[0].maquinaria==2) //si la maquinaria es propia
            {
                $("#maquinariaPropia").prop("checked", true);
                $("#tblContratistas").addClass("d-none");
                $("#tblMaquinaria").removeClass("d-none");
                actualizarListaPersonalesActividades(idactividadSel);
                //actualizarPersonal(idactividad);
            }
            if(datos[0].maquinaria==0)
            {
                $("#maquinariaContratada").prop("checked", false);
                $("#maquinariaPropia").prop("checked", false);
                $("#tblMaquinaria").addClass("d-none");
                $("#tblContratistas").addClass("d-none");
            }
        }
    });
}

function actualizarListaPersonalesActividades(idactividad)
    {
        $("#tblpersonales tbody").empty();
        $.ajax({
            type: "GET",
            url: "includes/ajax/actividades.php",
            data: "accion=listaPersonales&idactividad="+idactividad,
            dataType: "json",
            success: function (datos) {
                datos.forEach(dato => {
                    $("#tblpersonales tbody").append("<tr>\
                                                            <td class='d-none idactividad_personal'>" + dato.idactividad_personal + "</td>\
                                                            <td class='personal'>" + dato.personal + "</td>\
                                                            <td class='text-right precioHaPersonal'>" + dato.precioHa + "</td>\
                                                            <td class='text-right precioTotalPersonal'>" + dato.precioHa*superficieSel + "</td>\
                                                            <td class='text-center'>\
                                                                <a class='modificarPersonal' href='#' data-toggle='modal' data-target='#modalModificarPersonal' data-whatever=''>\
                                                                    <i class='material-icons'>create</i>\
                                                                </a>\
                                                                <a class='borrarPersonal' href='#'>\
                                                                    <i class='material-icons'>clear</i>\
                                                                </a>\
                                                            </td>\
                                                      </tr>");
                });
            }
        });
        
    }