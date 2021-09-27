$().ready(iniciarEventosActividades);
let tipoMaquinaria = 0;
let idcampana = 0;
let idusuario = 0;
let idcultivoSel = 0;
let idlotecampana = 0;
let idactividadSel = 0; //toma los id de la tabla de actividades que se seleccionan
let superficieSel = 0; //toma las superficies de la tabla de actividades que se seleccionan
//let totalActividadSel=0; //toma el importe de la tabla de actividades que se seleccionan
let idinsumoSel = 0;
let totalInsumoSel = 0;
let cantidadInsumoSel = 0;
let idactividadInsumoSel = 0;
let idactividadPersonalSel = 0;
let idactividadTerceroSel = 0;
let precioHaSel = 0;
let opcionProductor = 0;  //establece desde donde se llama la ventana modal para agragar productores a Actividades(1) o Insumos(1)
let totalProductorActividadSel = 0;
let totalProductorInsumoSel = 0;
let totalOldParticipacion = 0;


function iniciarEventosActividades() {
    idcampana = $("#idCampanaActiva").val();
    idusuario = $("#idUsuarioActivo").val(); //recuperamos en java los id de usuario y campana

    //cargamos los lotes a los select de lotes
    $("#sltcamposAct").change(function (e) {
        e.preventDefault();
        $("#supLote").val("");
        $("#sltlotesAct").empty();
        $("#sltcultivos").val(0);
        idcultivoSel = 0;
        superficieSel = 0;
        $("#sltlotesAct").append('<option value="0"></option>');
        $("#navDatos").addClass("d-none");
        $("#fldActividades").addClass("d-none");
        let idcampo = $("#sltcamposAct").val();
        //actualizarListaLabores();
        $.ajax({
            type: "GET",
            url: "includes/ajax/ajax.php",
            data: "accion=campos&idcampo=" + idcampo,
            dataType: "json",
            success: function (datos) {
                if (datos.length > 0) {
                    //$("#supLote").val(datos[0].superficie);
                    $.each(datos, function (index, valor) {
                        $("#sltlotesAct").append('<option value="' + valor.idlote + '">' + valor.lote + '</option>');
                    });
                }
            },
            error: function () {
                alert("error de conexion");
            }
        });
    });

    //cargamos los datos de los lotes, el cultivo de la campana y las actividades guardadas
    $('#sltlotesAct').change(function (e) {
        e.preventDefault();

        let idlote;
        idlote = $("#sltlotesAct").val();
        actualizarListaActividades(idlote);
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

    $('#sltpersonales').change(function (e) {
        e.preventDefault();
        $("#txtCuil").val("");
        $("#txtPrecioHa").val("");
        let idpersonal = $("#sltpersonales").val();
        $.ajax({
            data: "accion=personales&idpersonal=" + idpersonal,
            type: "GET",
            dataType: "json",
            url: "includes/ajax/ajax.php",
            success: function (datos) {
                if (datos.length > 0) {
                    $("#txtCuil").val(datos[0].cuil);
                    $("#txtPrecioHa").val(datos[0].precioHa);
                }
            },
            error: function () {
                alert("error de conexion");
            }
        });
    });

    $('#sltterceros').change(function (e) {
        e.preventDefault();
        $("#txtCuitTercero").val("");
        $("#txtDireccion").val("");
        let idtercero = $("#sltterceros").val();
        $.ajax({
            data: "accion=terceros&idtercero=" + idtercero,
            type: "GET",
            dataType: "json",
            url: "includes/ajax/ajax.php",
            success: function (datos) {
                if (datos.length > 0) {
                    $("#txtCuitTercero").val(datos[0].cuit);
                    $("#txtDireccionTercero").val(datos[0].direccion);
                }
            },
            error: function () {
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
                            $("#txtInsInsumo").val("");
                            $("#txtInsPrecio").val("")
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
        let slt = $("#sltcamposAct option");
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
                            actualizarListaCampos(datos); //le pasamos datos (id) del campo creado para dejar seleccionado el campo en el select
                            $("#supLote").val("");
                            $("#sltlotesAct").empty();
                            $("#sltcultivos").val(0);
                            idcultivoSel = 0;
                            superficieSel = 0;

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
        let idcampo = $("#sltcamposAct").val();
        let nombreLote = $("#txtInsLote").val();
        let slt = $("#sltlotesAct option");
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
                data: "accion=guardar&idlotecampana=" + idlotecampana + "&idlabor=" + idlabor + "&fecha=" + fechaActividad + "&precioha=" + precioHa + "&superficie=" + superficie,
                dataType: "text",
                success: function (id) {
                    $("#tblactividades tbody").append("<tr>\
                                                    <td class='d-none idactividad'>" + id + "</td>\
                                                    <td class='d-none'>" + idlabor + "</td>\
                                                    <td class='fechaActividad'>" + fechaActividad + "</td>\
                                                    <td class='actividad'>" + nombreLabor + "</td>\
                                                    <td class='text-right precioHa'>" + precioHa + "</td>\
                                                    <td class='text-right superficie'>" + superficie + "</td>\
                                                    <td class='text-right importeActividad'>" + precioHa * superficie + "</td>\
                                                    <td class='d-none observaciones'></td>\
                                                    <td class='text-center'>\
                                                        <a class='modificarActividad' href='#' data-toggle='modal' data-target='#modalModificarActividad' data-whatever=''>\
                                                            <i class='material-icons'>create</i>\
                                                        </a>\
                                                        <a class='borrarActividad' href='#'>\
                                                            <i class='material-icons'>clear</i>\
                                                        </a>\
                                                    </td>\
                                                </tr>");
                    completarResumen();
                    if ($("#chkCapitalizacion").prop("checked") == false) {
                        let idempresaSel = $("#idEmpresaActiva").val();
                        let total = precioHa * superficie;
                        $.ajax({
                            type: "GET",
                            url: "includes/ajax/actividades.php",
                            data: "accion=insProductorActividad&idactividad=" + id + "&idempresa=" + idempresaSel + "&total=" + total,
                            dataType: "text",
                            success: function (datos) {
                                if (datos == 0)
                                    alert("Se produjo un error al guardar el Productor para esta Actividad");
                                else
                                    actualizaProductoresActividades(id);
                            }
                        });
                    }
                },
                error: function () {
                    alert("ocurrio un error al guardar la actividad");
                }
            });
            $("#navDatos").addClass("d-none");

        } //fin validar campos
    });

    $("#btnInsertarLabor").click(function (e) {
        e.preventDefault();
        let precio = ($("#txtInsPrecioLabor").val() == "") ? 0 : parseInt($("#txtInsPrecioLabor").val());
        let nombreLabor = $("#txtInsLabor").val();
        let slt = $("#sltlabores option");
        if (estaEnElCombo(nombreLabor, slt)) {
            alert("Esta Labor ya existe");

        } else {
            if ($("#frmAgregarLabor").valid()) {

                $.ajax({
                    data: "accion=insLabor&labor=" + nombreLabor + "&precio=" + precio,
                    type: "GET",
                    dataType: "text",
                    url: "includes/ajax/ajax.php",
                    success: function (datos) {
                        if (datos != "false") {
                            totalLabores = precio;
                            $("#modalLabor").hide();
                            $("#modalLabor").modal('hide');
                            actualizarListaLabores(datos);
                            $("#txtInsPrecioLabor").val("");
                            $("#txtInsLabor").val("")

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

    //al hacer click en la tabla de actividades se selecciona una actividad y actualiza el resto de las tablas correspondientes
    $('#tblactividades tbody').click(function (e) {
        //console.log(e.target.parentNode.className);
        switch (e.target.parentNode.className) {
            case "borrarActividad":
                if (confirm("Desea borrar esta actividad?")) {
                    dato = e.target.parentNode.parentNode.parentNode
                    idactividadSel = $(dato).children().html();
                    $.ajax({
                        type: "GET",
                        url: "includes/ajax/actividades.php",
                        data: "accion=borrar&idactividad=" + idactividadSel,
                        dataType: "text",
                        success: function (id) {
                            if (id) {
                                $(dato).remove();
                                $("#navDatos").addClass("d-none");
                                idactividadSel = 0;
                                superficieSel = 0;
                                actualizaProductoresActividades(idactividadSel);
                            } else {
                                alert("Hubo un error al borrar la actividad");
                            }
                        }
                    });
                }
                break;
            case "modificarActividad":
                dato = e.target.parentNode.parentNode.parentNode;
                idactividadSel = $(dato).children().html();
                superficieSel = parseFloat($(dato).find(".superficie").html());
                $("#txtActividadModificar").val($(dato).find(".actividad").html());
                $("#txtFechaActividadModificar").val($(dato).find(".fechaActividad").html());
                $("#txtPrecioActividadModificar").val($(dato).find(".precioHa").html());
                $("#txtSupActividadModificar").val($(dato).find(".superficie").html());
                break;
            default:
                dato = e.target.parentNode
                idactividadSel = $(dato).children().html();  //es lo mismo que -> console.log(dato.children[0].innerHTML);
                superficieSel = parseFloat($(dato).find(".superficie").html());
                precioHaSel = parseFloat($(dato).find(".precioHa").html());
                //$("#txtobservaciones").val($(dato).find(".observaciones").html()=="null"?"":$(dato).find(".observaciones").html());
                $("#txtobservaciones").val($(dato).find(".observaciones").html());
                $('#tblactividades tbody tr').removeClass("table-active");
                dato.className = "table-active";
                $("#navDatos").removeClass("d-none");
                actualizarListaInsumosActividades(idactividadSel);
                actualizarListaMaquinariaActividades(idactividadSel);
                actualizaProductoresActividades(idactividadSel);
                $("#btnActProdModal").prop("disabled", false);
                break;
        }
        completarResumen();
    });

    $('#tblactividades thead').click(function (e) {
        //tipoMaquinaria=0;
        $('#tblactividades tbody tr').removeClass("table-active");
        $("#idActividad").val(0);
        $("#navDatos").addClass("d-none");
        actualizarListaInsumosActividades();
    });

    $("#tblinsumos tbody").click(function (e) {
        e.preventDefault();
        switch (e.target.parentNode.className) {
            case "borrarInsumo":
                if (confirm("Desea borrar este insumo?")) {
                    dato = e.target.parentNode.parentNode.parentNode;
                    idinsumoSel = $(dato).children().html();
                    $.ajax({
                        type: "GET",
                        url: "includes/ajax/actividades.php",
                        data: "accion=borrarInsumo&idactividad_insumo=" + idinsumoSel,
                        dataType: "text",
                        success: function (id) {
                            if (id) {
                                $(dato).remove();
                                completarResumen();
                                //$("#navDatos").addClass("d-none");
                                idinsumoSel = 0;
                                actualizarListaInsumosActividades(idactividadSel);
                            } else {
                                alert("Hubo un error al borrar la actividad");
                            }
                        }
                    });
                }
                break;

            case "modificarInsumo":
                dato = e.target.parentNode.parentNode.parentNode;
                idactividadInsumoSel = $(dato).find(".idactividad_insumo").html();
                $("#txtinsumoactividad").val($(dato).find(".insumo").html());
                $("#txtprecioInsumoActividad").val($(dato).find(".precio").html());
                $("#txtcantidadInsumoActividad").val($(dato).find(".cantidadHa").html());
                $("#txtcantidadInsumoTotal").val($(dato).find(".cantidadTotal").html());
                completarResumen();
                break;
            default:
                dato = e.target.parentNode
                idinsumoSel = $(dato).children().html();  //es lo mismo que -> console.log(dato.children[0].innerHTML);
                totalInsumoSel = parseFloat($(dato).find(".precioTotal").html());
                cantidadInsumoSel = parseFloat($(dato).find(".cantidadTotal").html());
                $('#tblinsumos tbody tr').removeClass("table-active");
                dato.className = "table-active";
                $("#btnInsProdModal").prop("disabled", false);
                actualizaProductoresInsumos(idinsumoSel);
        }

    });

    $("#tblterceros").click(function (e) {
        e.preventDefault();
        switch (e.target.parentNode.className) {
            case "modificarTercero":
                dato = e.target.parentNode.parentNode.parentNode;
                idactividadTerceroSel = $(dato).find(".idactividad_tercero").html();
                $("#txtModificarTercero").val($(dato).find(".tercero").html());
                $("#txtModificarPrecioHaTercero").val($(dato).find(".precioHaTercero").html());
                break;
            case "borrarTercero":
                if (confirm("Desea borrar esta empresa Tercerizada de la lista?")) {
                    dato = e.target.parentNode.parentNode.parentNode;
                    idactividadTerceroSel = $(dato).children().html();
                    $.ajax({
                        type: "GET",
                        url: "includes/ajax/actividades.php",
                        data: "accion=borrarTercero&idactividad_tercero=" + idactividadTerceroSel,
                        dataType: "text",
                        success: function (id) {
                            if (id) {
                                $(dato).remove();
                                //$("#navDatos").addClass("d-none");
                                idactividadTerceroSel = 0;
                            } else {
                                alert("Hubo un error al borrar la actividad");
                            }
                        }
                    });
                }
                break;
        }
    });

    $("#tblpersonales").click(function (e) {
        e.preventDefault();
        switch (e.target.parentNode.className) {
            case "modificarPersonal":
                dato = e.target.parentNode.parentNode.parentNode;
                idactividadPersonalSel = $(dato).find(".idactividad_personal").html();
                $("#txtModificarPersonalAct").val($(dato).find(".personal").html());
                $("#txtModificarPrecioHaPersonalAct").val($(dato).find(".precioHaPersonal").html());
                break;
            case "borrarPersonal":
                if (confirm("Desea borrar esta persona de la lista?")) {
                    dato = e.target.parentNode.parentNode.parentNode;
                    idactividadPersonalSel = $(dato).children().html();
                    $.ajax({
                        type: "GET",
                        url: "includes/ajax/actividades.php",
                        data: "accion=borrarPersonal&idactividad_personal=" + idactividadPersonalSel,
                        dataType: "text",
                        success: function (id) {
                            if (id) {
                                $(dato).remove();
                                //$("#navDatos").addClass("d-none");
                                idactividadPersonalSel = 0;
                            } else {
                                alert("Hubo un error al borrar la persona de la actividad");
                            }
                        }
                    });
                }
                break;
        }
    });

    $("#tblproductoresActividades tbody").click(function (e) {
        e.preventDefault();
        switch (e.target.parentNode.className) {
            case "borrarProductorActividad":
                if (confirm("Desea borrar este Productor?")) {
                    dato = e.target.parentNode.parentNode.parentNode;
                    idProductorActividadSel = $(dato).children().html();
                    $.ajax({
                        type: "GET",
                        url: "includes/ajax/actividades.php",
                        data: "accion=borrarProductorActividad&idactividad_empresa=" + idProductorActividadSel,
                        dataType: "text",
                        success: function (id) {
                            if (id) {
                                $(dato).remove();
                                //completarResumen();
                                //$("#navDatos").addClass("d-none");
                                idProductorActividadSel = 0;
                                actualizaProductoresActividades(idactividadSel);
                            } else {
                                alert("Hubo un error al borrar el productor");
                            }
                        }
                    });
                }
                break;

            case "modificarProductorActividad":
                dato = e.target.parentNode.parentNode.parentNode;
                idProductorActividadSel = $(dato).find(".idactividad_empresa").html();
                totalOldParticipacion = parseFloat($(dato).find(".total").html());
                $("#txtModProductor").val($(dato).find(".empresa").html());
                $("#txtModParticipacionProductor").val($(dato).find(".total").html());
                opcionProductor = 1;
                //completarResumen();
                break;
        }
    });

    $("#tblproductoresInsumos tbody").click(function (e) {
        e.preventDefault();
        switch (e.target.parentNode.className) {
            case "borrarProductorInsumo":
                if (confirm("Desea borrar este Productor?")) {
                    dato = e.target.parentNode.parentNode.parentNode;
                    idProductorInsumoSel = $(dato).children().html();
                    $.ajax({
                        type: "GET",
                        url: "includes/ajax/actividades.php",
                        data: "accion=borrarProductorInsumo&idinsumo_empresa=" + idProductorInsumoSel,
                        dataType: "text",
                        success: function (id) {
                            if (id) {
                                $(dato).remove();
                                //completarResumen();
                                //$("#navDatos").addClass("d-none");
                                idProductorInsumoSel = 0;
                                actualizaProductoresInsumos(idinsumoSel);
                            } else {
                                alert("Hubo un error al borrar el productor");
                            }
                        }
                    });
                }
                break;

            case "modificarProductorInsumo":
                dato = e.target.parentNode.parentNode.parentNode;
                idProductorInsumoSel = $(dato).find(".idinsumo_empresa").html();
                totalOldParticipacion = parseFloat($(dato).find(".total").html());
                $("#txtModProductor").val($(dato).find(".empresa").html());
                $("#txtModParticipacionProductor").val($(dato).find(".total").html());
                $("#txtModCantidadProductor").val($(dato).find(".cantidadTotal").html());
                opcionProductor = 2;
                //completarResumen();
                break;
        }
    });

    $("#sltcultivos").change(function (e) {
        e.preventDefault();
        let idcultivo = $("#sltcultivos").val();
        let idlote = $("#sltlotesAct").val();
        if (idcultivoSel == 0) {

            $.ajax({
                type: "GET",
                url: "includes/ajax/ajax.php",
                data: "accion=loteCultivoGuardar&idlote=" + idlote + "&idcultivo=" + idcultivo,
                dataType: "json",
                success: function (datos) {
                    idlotecampana = datos;
                    $("#fldActividades").removeClass("d-none");
                    actualizarListaActividades(idlote);
                    actualizarListaInsumosActividades();
                    actualizarListaInsumosActividades();
                    actualizarListaMaquinariaActividades();
                    actualizarListaPersonalesActividades();
                    actualizarListaPersonalesActividades();
                }
            });
        } else {
            if (confirm("Desea cambiar el cultivo de la campaña para este lote?") == true) {
                $.ajax({
                    type: "GET",
                    url: "includes/ajax/ajax.php",
                    data: "accion=loteCultivoModificar&idlote=" + idlote + "&idcultivo=" + idcultivo,
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
        let flag = false;
        if ($("#txtcantidadInsumo").val() == '') {
            alert("Debe ingresar la cantidad por ha");
            return;
        }
        if ($("#txtprecio").val() == '') {
            alert("Debe ingresar el precio del insumo");
            return;
        }

        $("#tblinsumos tbody tr .idinsumo").each(function () { //buscar si el insumo se encuentra ingresado en la lista
            if ($(this).text() == nombreInsumo) {
                flag = true;
            }
        });
        if (flag) {
            alert("Este insumo ya se encuentra en la lista");
        } else {

            let precio = $("#txtprecio").val();
            let cantidadha = $("#txtcantidadInsumo").val();
            let idinsumo = $("#sltinsumos").val();
            let insumo = $("#sltinsumos option:selected").html();
            $.ajax({
                type: "GET",
                url: "includes/ajax/actividades.php",
                data: "accion=insertarInsumo&idactividad=" + idactividadSel + "&superficie=" + superficieSel + "&precio=" + precio + "&cantidadha=" + cantidadha + "&idinsumo=" + idinsumo,
                dataType: "text",
                success: function (idactividad_insumo) {
                    actualizarListaInsumosActividades(idactividadSel);
                    completarResumen();
                    if ($("#chkCapitalizacion").prop("checked") == false) {
                        let idempresaSel = $("#idEmpresaActiva").val();
                        let total = precio * superficieSel*cantidadha;
                        let cantProductor = superficieSel*cantidadha;
                        $.ajax({
                            type: "GET",
                            url: "includes/ajax/actividades.php",
                            data: "accion=insProductorInsumo&idempresa=" + idempresaSel + "&idactividad_insumo=" + idactividad_insumo + "&total=" + total + "&cantidad=" + cantProductor,
                            dataType: "text",
                            success: function (id) {
                                if (id > 0) {
                                    actualizaProductoresInsumos(idactividad_insumo);
                                } else {
                                    alert("Se produjo un error al guardar la participacion del productor para este insumos");
                                }
                                //opcionProductor = 0;
                            }
                        });
                    }
                },
                error: function () {
                    alert("ocurrio un error al guardar la actividad");
                }

            });
        }
    });

    $("#btnModificarInsumoActividad").click(function (e) {
        e.preventDefault();
        let precio = $("#txtprecioInsumoActividad").val();
        let cantidadHa = $("#txtcantidadInsumoActividad").val();
        let cantidadTotal = $("#txtcantidadInsumoTotal").val();
        $.ajax({
            type: "GET",
            url: "includes/ajax/actividades.php",
            data: "accion=modificarInsumo&idactividad_insumo=" + idactividadInsumoSel + "&precio=" + precio + "&cantidadHa=" + cantidadHa + "&cantidadTotal=" + cantidadTotal,
            dataType: "text",
            success: function (datos) {
                if (datos == 1) {
                    actualizarListaInsumosActividades(idactividadSel);
                    completarResumen();
                } else {
                    alert("Hubo un error al modificar los datos");
                }

            },
            error: function () {
                alert("hubo un error al modificar los datos");
            }
        });
        $("#txtprecioInsumoActividad").val("");
        $("#txtcantidadInsumoActividad").val("");
        $("#txtinsumoactividad").val("");
        $("#modalInsumoActividad").hide();
        $("#modalInsumoActividad").modal('hide');

    });

    $("#btnModificarPersonalAct").click(function (e) {
        e.preventDefault();
        let precioHa = $("#txtModificarPrecioHaPersonalAct").val();
        $.ajax({
            type: "GET",
            url: "includes/ajax/actividades.php",
            data: "accion=modificarPersonal&idactividad_personal=" + idactividadPersonalSel + "&precioHa=" + precioHa,
            dataType: "text",
            success: function (datos) {
                if (datos == 1) {
                    actualizarListaPersonalesActividades(idactividadSel);
                } else {
                    alert("Hubo un error al modificar los datos");
                }
            }
        });
        $("#modalModificarPersonalAct").hide();
        $("#modalModificarPersonalAct").modal('hide');
    });

    $("#btnModificarTercero").click(function (e) {
        e.preventDefault();
        let precioHa = $("#txtModificarPrecioHaTercero").val();
        $.ajax({
            type: "GET",
            url: "includes/ajax/actividades.php",
            data: "accion=modificarTercero&idactividad_tercero=" + idactividadTerceroSel + "&precioHa=" + precioHa,
            dataType: "text",
            success: function (datos) {
                if (datos == 1) {
                    actualizarListaTercerosActividades(idactividadSel);
                } else {
                    alert("Hubo un error al modificar los datos");
                }
            }
        });
        $("#modalModificarPersonal").hide();
        $("#modalModificarPersonal").modal('hide');
    });

    $("#btnModificarActividad").click(function (e) {
        e.preventDefault();
        $("#modalModificarActividad").hide();
        $("#modalModificarActividad").modal('hide');
        superficie = $("#txtSupActividadModificar").val();
        precioHa = $("#txtPrecioActividadModificar").val();
        fecha = $("#txtFechaActividadModificar").val();
        $.ajax({
            type: "GET",
            url: "includes/ajax/actividades.php",
            data: "accion=modificar&idactividad=" + idactividadSel + "&fecha=" + fecha + "&superficie=" + superficie + "&precioHa=" + precioHa,
            dataType: "text",
            success: function (datos) {
                if (datos == 0)
                    alert("Ocurrio un error al modificar la actividad");
                else
                    $("#sltlotesAct").change();

            },
            error: function () {
                alert("Ocurrio un error al modificar la actividad");
            }
        });

        if (superficieSel != superficie) {
            if (confirm("Desea actualizar la lista de insumos?")) {
                $.ajax({
                    type: "GET",
                    url: "includes/ajax/actividades.php",
                    data: "accion=modificarInsumosDeActividad&idactividad=" + idactividadSel + "&superficie=" + superficie,
                    dataType: "text",
                    success: function (datos) {
                        if (datos) {
                            actualizarListaInsumosActividades(idactividadSel);
                        } else {
                            alert("Ocurrio un error al actualizar la base de datos");
                        }
                    }
                });
            } else {
                alert("Puede cambiar los valores de los insumos manualmente de acuerdo a las necesidades");
            }
        }
    });

    $("#btnModParticipacionProductor").click(function (e) {
        e.preventDefault();
        $("#modalModificarProductor").hide();
        $("#modalModificarProductor").modal('hide');
        let total = parseFloat($("#txtModParticipacionProductor").val());
        let cantidadTotal = 0;
        if (opcionProductor == 1) {
            if ((totalProductorActividadSel + total - totalOldParticipacion) > (superficieSel * precioHaSel))
                alert("La suma de aportes de Productores es mayor al valor de la actividad");
            else {
                $.ajax({
                    type: "GET",
                    url: "includes/ajax/actividades.php",
                    data: "accion=modificarProductorActividad&idactividad_empresa=" + idProductorActividadSel + "&total=" + total,
                    dataType: "text",
                    success: function (datos) {
                        if (datos == 0)
                            alert("Ocurrio un error al modificar el productor");
                        else
                            actualizaProductoresActividades(idactividadSel);

                    },
                    error: function () {
                        alert("Ocurrio un error al modificar el productor");
                    }
                });
            }
        }
        if (opcionProductor == 2) {
            if ((totalProductorInsumoSel + total - totalOldParticipacion) > (totalInsumoSel))
                alert("La suma de aportes de Productores es mayor al valor del insumo");
            else {
                cantidadTotal = parseFloat($("#txtModCantidadProductor").val());
                $.ajax({
                    type: "GET",
                    url: "includes/ajax/actividades.php",
                    data: "accion=modificarProductorInsumo&idinsumo_empresa=" + idProductorInsumoSel + "&total=" + total + "&cantidadTotal=" + cantidadTotal,
                    dataType: "text",
                    success: function (datos) {
                        if (datos == 0)
                            alert("Ocurrio un error al modificar el productor");
                        else
                            actualizaProductoresInsumos(idinsumoSel);

                    },
                    error: function () {
                        alert("Ocurrio un error al modificar el productor");
                    }
                });
            }
        }
    });

    $("input:radio[name='maquinaria']").change(function (e) {
        //e.preventDefault();
        opt = $(this).val(); //sacamos el valor de la opcion seleccionada
        if (tipoMaquinaria == 0) {
            $.ajax({
                type: "GET",
                url: "includes/ajax/actividades.php",
                data: "accion=guardarTipoMaquinaria&idactividad=" + idactividadSel + "&tipoMaquinaria=" + opt,
                dataType: "text",
                success: function (datos) {
                    if (datos == 0)
                        alert("Ocurrio un error al guardar los datos");
                    else
                        actualizarListaMaquinariaActividades(idactividadSel);
                },
                error: function () {
                    alert("Ocurrio un error al guardar los datos");
                }
            });
        } else {
            if (confirm("Desea cambiar el tipo maquinaria? Si confirma se eliminaran todos los datos cargados anteriormente")) {
                $.ajax({
                    type: "GET",
                    url: "includes/ajax/actividades.php",
                    data: "accion=guardarTipoMaquinaria&idactividad=" + idactividadSel + "&tipoMaquinaria=" + opt,
                    dataType: "text",
                    success: function (datos) {
                        if (datos == 0)
                            alert("Ocurrio un error al guardar los datos");
                        else
                            actualizarListaMaquinariaActividades(idactividadSel);
                    },
                    error: function () {
                        alert("Ocurrio un error al guardar los datos");
                    }
                });
            } else {
                opt == "1" ? $("input[name='maquinaria'][value='2']").prop("checked", true) : $("input[name='maquinaria'][value='1']").prop("checked", true);


            }
        }
    });

    $("#btnAgregarPersonal").click(function (e) {
        e.preventDefault();
        let idpersonal = $("#sltpersonales").val();
        let precioHa = $("#txtPrecioHa").val();
        let flag = false;
        $("#tblpersonales tbody tr").each(function () {
            if ($(this).find(".idpersonal").html() == idpersonal)
                flag = true;
        });
        console.log(flag);
        if (flag) {
            alert("Ya se ingreso a la lista este personal");
        }
        else {
            $.ajax({
                type: "GET",
                url: "includes/ajax/actividades.php",
                data: "accion=agregarPersonal&idactividad=" + idactividadSel + "&idpersonal=" + idpersonal + "&precioHa=" + precioHa,
                dataType: "json",
                success: function (datos) {
                    actualizarListaPersonalesActividades(idactividadSel);
                }
            });
        }
    });

    $("#btnAgregarTercero").click(function (e) {
        e.preventDefault();
        let idtercero = $("#sltterceros").val();
        let cantidad = 0;
        console.log(idtercero);
        console.log(idactividadSel);
        $("#tblterceros tbody tr").each(function () {
            cantidad += 1;
        });
        if (cantidad == 1) {
            alert("No puede ingresar mas de una empresa contratada para realizar la activiad");
        }
        else {

            $.ajax({
                type: "GET",
                url: "includes/ajax/actividades.php",
                data: "accion=agregarTercero&idactividad=" + idactividadSel + "&idtercero=" + idtercero + "&precioHa=" + precioHaSel,
                dataType: "json",
                success: function (datos) {
                    actualizarListaTercerosActividades(idactividadSel);
                }
            });
        }
    });

    $("#btnObservaciones").click(function (e) {
        e.preventDefault();
        let observaciones = $("#txtobservaciones").val();
        $.ajax({
            type: "GET",
            url: "includes/ajax/actividades.php",
            data: "accion=guardarObservaciones&idactividad=" + idactividadSel + "&observaciones=" + observaciones,
            dataType: "text",
            success: function (datos) {
                if (datos == 0) {
                    alert("ocurrio un error al guardar las observaciones");
                }
            }
        });

    });

    $("#btnInformeCostos").click(function (e) {
        e.preventDefault();
        window.open("generarCostosLote.php?idloteCampana=" + idlotecampana);
    });

    $("#btnInformeDetallado").click(function (e) {
        e.preventDefault();
        window.open("generarInformeCostosDetallado.php?idloteCampana=" + idlotecampana);
    });

    $("#sltcampanas").change(function (e) {
        e.preventDefault();
        $("#sltcamposAct").val(0);
        $("#sltcamposAct").change();
    });

    $("#chkCapitalizacion").change(function (e) {
        e.preventDefault();

        if ($("#chkCapitalizacion").prop("checked")) {
            $("#listaProductoresActividades").removeClass("d-none");
            $("#listaProductoresInsumos").removeClass("d-none");

        }
        else {
            $("#listaProductoresActividades").addClass("d-none");
            $("#listaProductoresInsumos").addClass("d-none");
        }

    });

    $("#chkCapitalizacion").click(function (e) {
        //e.preventDefault();
        let estado = $("#chkCapitalizacion").prop("checked");
        if (idlotecampana > 0) {
            $.ajax({
                type: "GET",
                url: "includes/ajax/actividades.php",
                data: "accion=capitalizacion&idlotecampana=" + idlotecampana + "&estado=" + estado,
                dataType: "text",
                success: function (datos) {
                    if (datos == 0) {
                        alert("Se produjo un error al actualizar la base de datos");
                    } else {
                        $("#chkCapitalizacion").change();
                    }
                }
            });
        }
    });

    $("#btnAgregarProductor").click(function (e) {
        e.preventDefault();
        let flag = false;
        let idproductor = 0;
        let total = 0;
        let cantProductor = 0;
        if (opcionProductor == 1)  //se agreaga el productor a la lista de Actividades
        {
            idproductor = $("#sltproductores").val();

            $("#tblproductoresActividades tbody tr .idempresa").each(function () { //buscar si el insumo se encuentra ingresado en la lista
                if ($(this).text() == idproductor) {
                    flag = true;
                }
            });
            if (flag) {
                alert("Este productor ya se encuentra en la lista");
            } else {
                total = parseFloat($("#txtParticipacion").val())
                if ((totalProductorActividadSel + total) > (superficieSel * precioHaSel)) {
                    alert("La suma de las participaciones es mayor al valor de la actividad");
                } else {
                    $.ajax({
                        type: "GET",
                        url: "includes/ajax/actividades.php",
                        data: "accion=insProductorActividad&idempresa=" + idproductor + "&idactividad=" + idactividadSel + "&total=" + total,
                        dataType: "text",
                        success: function (id) {
                            if (id > 0) {
                                actualizaProductoresActividades(idactividadSel);
                            } else {
                                alert("Se produjo un error al guardar el productor para esta actividad");
                            }
                            //opcionProductor = 0;
                        }
                    });
                }
            }
        } else if (opcionProductor == 2) {
            idproductor = $("#sltproductores").val();
            console.log("productor: "+idproductor);

            $("#tblproductoresInsumos tbody tr .idempresa").each(function () { //buscar si el insumo se encuentra ingresado en la lista
                if ($(this).text() == idproductor) {
                    flag = true;
                }
            });
            if (flag) {
                alert("Este productor ya se encuentra en la lista");
            } else {
                total = parseFloat($("#txtParticipacion").val());
                cantProductor = parseFloat($("#txtProductorCantidad").val());
                console.log("total: "+total);
                console.log("cantidad: "+idinsumoSel);
                if ((totalProductorInsumoSel + total) > totalInsumoSel) {
                    alert("La suma de las participaciones es mayor al valor del Insumo");
                } else {
                    let cantProductor = $("#txtProductorCantidad").val();
                    $.ajax({
                        type: "GET",
                        url: "includes/ajax/actividades.php",
                        data: "accion=insProductorInsumo&idempresa=" + idproductor + "&idactividad_insumo=" + idinsumoSel + "&total=" + total + "&cantidad=" + cantProductor,
                        dataType: "text",
                        success: function (id) {
                            if (id > 0) {
                                actualizaProductoresInsumos(idinsumoSel);
                            } else {
                                alert("Se produjo un error al guardar la participacion del productor para este insumo");
                            }
                            //opcionProductor = 0;
                        }
                    });
                }
            }
        } else {
            alert("No se asigno hacia donde se va a asignar el productor");
        }
    });

    $("#btnInsertarTercero").click(function (e) {
        e.preventDefault();
        let nombreTercero = $("#txtInsTercero").val();
        let cuit = ($("#txtInsCuitTercero").val() == "") ? 0 : parseInt($("#txtInsCuitTercero").val());
        let direccion = $("#txtInsDireccionTercero").val();
        let slt = $("#sltterceros option");
        if (estaEnElCombo(nombreTercero, slt)) {
            alert("Este Productor ya existe");

        } else {
            if ($("#frmAgregarTerceros").valid()) {
                $.ajax({
                    data: "accion=insEmpresa&empresa=" + nombreTercero + "&cuit=" + cuit + "&direccion=" + direccion + "&productor=false&contratista=true&proveedor=false&otro=false",
                    type: "GET",
                    dataType: "text",
                    url: "includes/ajax/ajax.php",
                    success: function (datos) {
                        if (datos != "false") {
                            $("#modalInsTercero").hide();
                            $("#modalInsTercero").modal('hide');
                            actualizarListaTerceros(datos);
                            //modificarPresupuesto();

                        } else if (datos == 0) {
                            alert("El usuario ya se encuentra registrado. Cambie el rol del usuario para encontrarlo en la lista de productores");
                        } else {
                            alert("Hubo otro error");
                        }
                    },
                    error: function () {
                        alert("error de conexion");
                    }
                });
            }
        }
    });

    $("#btnActProdModal").click(function (e) { //se abre la ventana modal para agregar productores a la actividad
        opcionProductor = 1;
        $("#txtParticipacion").val(precioHaSel * superficieSel);

    });

    $("#btnInsProdModal").click(function (e) { //se abre la ventana modal para agregar productores a los insumos
        //e.preventDefault();
        opcionProductor = 2;
        $("#txtParticipacion").val(totalInsumoSel);
        $("#txtProductorCantidad").val(cantidadInsumoSel);
    });

}//fin iniciar eventos actividades

function actualizarListaActividades(idlote) {
    superficieSel = 0;
    precioHaSel = 0;
    idactividadSel = 0;
    importeTotalActividades = 0;
    totalProductorActividadSel = 0;
    opcionProductor = 0;
    $("#tblactividades tbody").empty();
    $("#tblproductoresActividades tbody").empty();
    $("#tblproductoresInsumos tbody").empty();
    $("#tblinsumos tbody").empty();
    $("#btnActProdModal").prop("disabled", true);

    $("#navDatos").addClass("d-none");
    $("#supLote").val("");
    $("#chkCapitalizacion").prop("checked", false);
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
                    data: "accion=loteCultivo&idlote=" + idlote,
                    dataType: "json",
                    success: function (datos) {
                        if (datos.length > 0) {
                            $("#sltcultivos").val(datos[0].idcultivo);
                            datos[0].capitalizacion == 1 ? $("#chkCapitalizacion").prop("checked", true) : $("#chkCapitalizacion").prop("checked", false);
                            $("#chkCapitalizacion").change();
                            idlotecampana = datos[0].idloteCampana;
                            idcultivoSel = datos[0].idcultivo;

                            $.ajax({
                                type: "GET",
                                url: "includes/ajax/actividades.php",
                                data: "accion=cargar&idlotecampana=" + idlotecampana,
                                dataType: "json",
                                success: function (datos) {
                                    datos.forEach(dato => {
                                        $("#tblactividades tbody").append("<tr>\
                                                                        <td class='d-none idactividad'>" + dato.idactividad + "</td>\
                                                                        <td class='fechaActividad'>" + dato.fechaDMY + "</td>\
                                                                        <td class='actividad'>" + dato.labor + "</td>\
                                                                        <td class='text-right precioHa'>" + dato.precioha + "</td>\
                                                                        <td class='text-right superficie'>" + dato.superficie + "</td>\
                                                                        <td class='text-right importeActividad'>" + dato.precioha * dato.superficie + "</td>\
                                                                        <td class='d-none observaciones'>" + dato.observaciones + "</td>\
                                                                        <td class='text-center'>\
                                                                            <a class='modificarActividad' href='#' data-toggle='modal' data-target='#modalModificarActividad' data-whatever=''>\
                                                                                <i class='material-icons'>create</i>\
                                                                            </a>\
                                                                            <a class='borrarActividad' href='#'>\
                                                                                <i class='material-icons'>clear</i>\
                                                                            </a>\
                                                                        </td>\
                                                                    </tr>");
                                    });
                                    completarResumen();
                                }
                            });
                        }
                        else {
                            $("#sltcultivos").val(0);
                            idcultivoSel = 0;
                            idlotecampana = 0;
                            $("#fldActividades").addClass("d-none");
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
}

//funciones complementarias
function actualizarListaLotes(idcampo, idlote) {
    $("#sltlotesAct").empty();
    $("#sltlotesAct").append('<option value="0"></option>');
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
                    $("#sltlotesAct").append('<option value="' + valor.idlote + '" ' + sel + '>' + valor.lote + '</option>');

                });
                $("#fldActividades").addClass("d-none");
                $("#navDatos").addClass("d-none");
                $("#sltcultivos").val(0);
                idcultivoSel = 0;
            }
        },
        error: function () {
            alert("error de conexion");
        }
    });
}

function actualizarListaCampos(id) {
    $("#sltcamposAct").empty();
    $("#sltcamposAct").append('<option value="0"></option>');
    $.ajax({
        data: "accion=todosCampos",
        type: "GET",
        dataType: "json",
        url: "includes/ajax/ajax.php",
        success: function (datos) {
            if (datos.length > 0) {
                $.each(datos, function (index, valor) {
                    $("#sltcamposAct").append('<option value="' + valor.idcampo + '">' + valor.campo + '</option>');
                    if (valor.idcampo == id) {
                        $("#sltcamposAct").val(id);
                    }
                });
                $("#fldActividades").addClass("d-none");
                $("#navDatos").addClass("d-none");
                $("#sltlotesAct").val(0);
                $("#sltcultivos").val(0);
                $("#supLote").val("");
                idcultivoSel = 0;
                superficieSel = 0;
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
function actualizarListaInsumosActividades(idactividad) {
    $("#tblinsumos tbody").empty();
    $("#tblproductoresInsumos tbody").empty();
    $("#btnInsProdModal").prop("disabled", true);
    $.ajax({
        type: "GET",
        url: "includes/ajax/actividades.php",
        data: "accion=listaInsumos&idactividad=" + idactividad,
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

//actualiza la lista de labores de la ventana modal
function actualizarListaLabores(id) {
    let idlabor = 'idlabor';
    $("#sltlabores").empty();
    $.ajax({
        data: "accion=labores&idlabor=" + idlabor,
        type: "GET",
        dataType: "json",
        url: "includes/ajax/ajax.php",
        success: function (datos) {
            if (datos.length > 0) {
                $.each(datos, function (index, valor) {
                    if (valor.idlabor == parseInt(id)) {
                        var sel = "selected";
                        $("#txtPrecioLabor").val(valor.precio);
                    }
                    $("#sltlabores").append('<option value="' + valor.idlabor + '" data-foo="' + valor.precio + '" ' + sel + '>' + valor.labor + '</option>');
                });
            }
        },
        error: function () {
            alert("error de conexion");
        }
    });
}

//actualiza la lista de maquinarias en la tabla de maquinarias correspondiente a una actividad
function actualizarListaMaquinariaActividades(idactividad) {
    $.ajax({
        type: "GET",
        url: "includes/ajax/actividades.php",
        data: "accion=tipoMaquinaria&idactividad=" + idactividad,
        dataType: "json",
        success: function (datos) {
            if (datos.length > 0) {
                tipoMaquinaria = datos[0].maquinaria;
                if (datos[0].maquinaria == 1) //si la maquinaria es contratada
                {
                    $("#maquinariaContratada").prop("checked", true);
                    $("#tblMaquinaria").addClass("d-none");
                    $("#tblContratistas").removeClass("d-none");
                    actualizarListaTercerosActividades(idactividadSel);
                }
                if (datos[0].maquinaria == 2) //si la maquinaria es propia
                {
                    $("#maquinariaPropia").prop("checked", true);
                    $("#tblContratistas").addClass("d-none");
                    $("#tblMaquinaria").removeClass("d-none");
                    actualizarListaPersonalesActividades(idactividadSel);
                    //actualizarPersonal(idactividad);
                }
                if (datos[0].maquinaria == 0) {
                    $("#maquinariaContratada").prop("checked", false);
                    $("#maquinariaPropia").prop("checked", false);
                    $("#tblMaquinaria").addClass("d-none");
                    $("#tblContratistas").addClass("d-none");
                }
            }
        }
    });
}

function actualizarListaPersonalesActividades(idactividad) {
    $("#tblpersonales tbody").empty();
    $.ajax({
        type: "GET",
        url: "includes/ajax/actividades.php",
        data: "accion=listaPersonales&idactividad=" + idactividad,
        dataType: "json",
        success: function (datos) {
            datos.forEach(dato => {
                $("#tblpersonales tbody").append("<tr>\
                                                            <td class='d-none idactividad_personal'>" + dato.idactividad_personal + "</td>\
                                                            <td class='d-none idpersonal'>" + dato.idpersonal + "</td>\
                                                            <td class='personal'>" + dato.personal + "</td>\
                                                            <td class='text-right precioHaPersonal'>" + dato.precioHa + "</td>\
                                                            <td class='text-right precioTotalPersonal'>" + dato.precioHa * superficieSel + "</td>\
                                                            <td class='text-center'>\
                                                                <a class='modificarPersonal' href='#' data-toggle='modal' data-target='#modalModificarPersonalAct' data-whatever=''>\
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

function actualizarListaTercerosActividades(idactividad) {
    $("#tblterceros tbody").empty();
    $.ajax({
        type: "GET",
        url: "includes/ajax/actividades.php",
        data: "accion=listaTerceros&idactividad=" + idactividad,
        dataType: "json",
        success: function (datos) {
            datos.forEach(dato => {
                $("#tblterceros tbody").append("<tr>\
                                                        <td class='d-none idactividad_tercero'>" + dato.idactividad_tercero + "</td>\
                                                        <td class='tercero'>" + dato.tercero + "</td>\
                                                        <td class='text-right precioHaTercero'>" + dato.precioHa + "</td>\
                                                        <td class='text-right precioTotalTercero'>" + dato.precioHa * superficieSel + "</td>\
                                                        <td class='text-center'>\
                                                            <a class='borrarTercero' href='#'>\
                                                                <i class='material-icons'>clear</i>\
                                                            </a>\
                                                        </td>\
                                                    </tr>");
            });
            //  <a class='modificarTercero' href='#' data-toggle='modal' data-target='#modalModificarTercero' data-whatever=''><i class='material-icons'>create</i></a> //para modificar el contratista en la lista
        }
    });

}

function actualizaProductoresActividades(idactividad) {
    $("#tblproductoresActividades tbody").empty();
    totalProductorActividadSel = 0;
    $.ajax({
        type: "GET",
        url: "includes/ajax/actividades.php",
        data: "accion=ProductorActividad&idactividad=" + idactividad,
        dataType: "json",
        success: function (datos) {
            datos.forEach(dato => {
                totalProductorActividadSel += parseFloat(dato.total);
                $("#tblproductoresActividades tbody").append("<tr>\
                                                                <td class='d-none idactividad_empresa'>" + dato.idactividad_empresa + "</td>\
                                                                <td class='d-none idempresa'>" + dato.idempresa + "</td>\
                                                                <td class='empresa'>" + dato.empresa + "</td>\
                                                                <td class='text-right total'>" + dato.total + "</td>\
                                                                <td class='text-center'>\
                                                                            <a class='modificarProductorActividad' href='#' data-toggle='modal' data-target='#modalModificarProductor' data-whatever=''>\
                                                                                <i class='material-icons'>create</i>\
                                                                            </a>\
                                                                            <a class='borrarProductorActividad' href='#'>\
                                                                                <i class='material-icons'>clear</i>\
                                                                            </a>\
                                                                        </td>\
                                                        </tr>");
            });
            if (totalProductorActividadSel != (superficieSel * precioHaSel)) {
                $("#tblproductoresActividades thead").removeClass("thead-light");
                $("#tblproductoresActividades thead").addClass("table-danger");
            } else {
                $("#tblproductoresActividades thead").removeClass("table-danger");
                $("#tblproductoresActividades thead").addClass("thead-light");
            }
        }
    });

}

function actualizaProductoresInsumos(idactividad_insumo) {
    $("#tblproductoresInsumos tbody").empty();
    totalProductorInsumoSel = 0;
    let cantidadTotal = 0;
    $.ajax({
        type: "GET",
        url: "includes/ajax/actividades.php",
        data: "accion=ProductorInsumo&idactividad_insumo=" + idactividad_insumo,
        dataType: "json",
        success: function (datos) {
            datos.forEach(dato => {
                totalProductorInsumoSel += parseFloat(dato.total);
                cantidadTotal += parseFloat(dato.cantidad);
                $("#tblproductoresInsumos tbody").append("<tr>\
                                                                <td class='d-none idinsumo_empresa'>" + dato.idinsumo_empresa + "</td>\
                                                                <td class='d-none idempresa'>" + dato.idempresa + "</td>\
                                                                <td class='empresa'>" + dato.empresa + "</td>\
                                                                <td class='text-right cantidadTotal'>" + dato.cantidad + "</td>\
                                                                <td class='text-right total'>" + dato.total + "</td>\
                                                                <td class='text-center'>\
                                                                            <a class='modificarProductorInsumo' href='#' data-toggle='modal' data-target='#modalModificarProductor' data-whatever=''>\
                                                                                <i class='material-icons'>create</i>\
                                                                            </a>\
                                                                            <a class='borrarProductorInsumo' href='#'>\
                                                                                <i class='material-icons'>clear</i>\
                                                                            </a>\
                                                                        </td>\
                                                        </tr>");
            });

            if ((totalProductorInsumoSel != totalInsumoSel) || (cantidadTotal != cantidadInsumoSel)) {
                $("#tblproductoresInsumos thead").removeClass("thead-light");
                $("#tblproductoresInsumos thead").addClass("table-danger");
            } else {
                $("#tblproductoresInsumos thead").removeClass("table-danger");
                $("#tblproductoresInsumos thead").addClass("thead-light");
            }
        }
    });

}

function actualizarListaProductores(id) {
    let idproductor = 'idempresa';
    $("#sltproductores").empty();
    $.ajax({
        data: "accion=productores&idproductor=" + idproductor,
        type: "GET",
        dataType: "json",
        url: "includes/ajax/ajax.php",
        success: function (datos) {
            if (datos.length > 0) {
                $.each(datos, function (index, valor) {
                    if (valor.idempresa == parseInt(id)) {
                        var sel = "selected";
                        $("#txtCuit").val(valor.cuit);
                        $("#txtDireccion").val(valor.direccion);
                    }
                    $("#sltproductores").append('<option value="' + valor.idempresa + '" ' + sel + '>' + valor.empresa + '</option>');
                });
            }
        },
        error: function () {
            alert("error de conexion al actualizar la lista de empresas de productores");
        }
    });
}

function actualizarListaTerceros(id) {
    $("#sltterceros").empty();
    $.ajax({
        data: "accion=listarEmpresas&productor=false&contratista=true&proveedor=false&otro=false",
        type: "GET",
        dataType: "json",
        url: "includes/ajax/ajax.php",
        success: function (datos) {
            if (datos.length > 0) {
                $.each(datos, function (index, valor) {
                    if (valor.idempresa == parseInt(id)) {
                        var sel = "selected";
                        $("#txtCuitTercero").val(valor.cuit);
                        $("#txtDireccionTercero").val(valor.direccion);
                    }
                    $("#sltterceros").append('<option value="' + valor.idempresa + '" ' + sel + '>' + valor.empresa + '</option>');
                });
            }
        },
        error: function () {
            alert("error de conexion al actualizar la lista de empresas de contratistas");
        }
    });
}

function completarResumen() {
    let importeTotalActividades = 0;
    let importeInsumos = 0;
    $("#tblactividades tbody tr .importeActividad").each(function () { //buscar si el insumo se encuentra ingresado en la lista
        importeTotalActividades += parseFloat($(this).text());
    });

    $("#tdSupTotal").html($("#supLote").val());
    $("#tdTotalLabores").html(importeTotalActividades);
    $.ajax({
        type: "GET",
        url: "includes/ajax/actividades.php",
        data: "accion=importeInsumosLote&idlotecampana=" + idlotecampana,
        dataType: "json",
        success: function (datos) {
            importeInsumos = datos[0].importe == null ? 0 : parseFloat(datos[0].importe);
            $("#tdTotalInsumos").html(importeInsumos.toFixed(2));
            $("#tdTotal").html(importeInsumos + importeTotalActividades);
        }
    });

}