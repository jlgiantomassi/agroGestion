$(document).ready(iniciarEvento);
let supTotal = 0;
let partTotal = 0;
let totalInsumosha = 0;
let totalLabores = 0;
let filaProductor = 0;
let filaTercero = 0;
let filaPersonal = 0;
let filaCampo = 0;
let filaInsumo = 0;
let idOrdenTrabajo = 0;
let error = false;

function iniciarEvento() {
    totalLabores = $("#txtPrecioLabor").val();

    $("#cantidadAportadoProductor").addClass("d-none");//ocultamos este div porque se usa solamente en actividades
    $("#resumen").hide();
    //cargar el combo de lotes
    //$('#alerta').alert('close');

    $("#sltlabores").change(function (e) {
        e.preventDefault();
        let selected = $(this).find('option:selected');
        totalLabores = parseFloat(selected.data('foo'));
        $("#txtPrecioLabor").val(totalLabores);
        modificarPresupuesto();

    });

    $('#sltcampos').change(function (e) {
        e.preventDefault();
        $("#sltlotes").empty($("#sltcampos").val());
        $("#txtsuperficie").val("");
        let idcampo;
        idcampo = $("#sltcampos").val();
        $.ajax({
            data: "accion=campos&idcampo=" + idcampo,
            type: "GET",
            dataType: "json",
            url: "includes/ajax/ajax.php",
            success: function (datos) {
                if (datos.length > 0) {
                    $("#txtsuperficie").val(datos[0].superficie);
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

    $('#sltproductores').change(function (e) {
        e.preventDefault();
        $("#txtCuit").val("");
        $("#txtDireccion").val("");
        $("#txtParticipacion").val("100");
        let idproductor = $("#sltproductores").val();
        $.ajax({
            data: "accion=productores&idproductor=" + idproductor,
            type: "GET",
            dataType: "json",
            url: "includes/ajax/ajax.php",
            success: function (datos) {

                if (datos.length > 0) {
                    $("#txtCuit").val(datos[0].cuit);
                    $("#txtDireccion").val(datos[0].direccion);
                }
            },
            error: function () {
                alert("error de conexion al buscar productores");
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


    //cargar el txt de superficie
    $('#sltlotes').change(function (e) {
        e.preventDefault();
        $("#txtsuperficie").val("");
        let idlote;
        idlote = $("#sltlotes").val();
        $.ajax({
            data: "accion=lotes&idlote=" + idlote,
            type: "GET",
            dataType: "json",
            url: "includes/ajax/ajax.php",
            success: function (datos) {
                if (datos.length > 0) {
                    $("#txtsuperficie").val(datos[0].superficie);
                }
            },
            error: function () {
                alert("error de conexion");
            }
        });
    });


    //agregar productor a la lista

    $('#btnAgregarProductor').click(function (e) {
        e.preventDefault();
        let flag = true;
        //validar campos
        if ($("#frmproductores").valid()) {
            let idproductor = 0;
            let nombreProductor = $("#sltproductores option:selected").text();
            let participacion = ($("#txtParticipacion").val() == "") ? 0 : parseFloat($("#txtParticipacion").val());
            idproductor = parseInt($("#sltproductores option:selected").val());

            if (partTotal + participacion > 100) {
                alert("La participacion de los productores debe ser menor al 100%");
                flag = false;
            }
            $('#tblproductores tr').each(function () {
                var id = $(this).find(".idproductor").html();
                if (idproductor == id) {
                    alert("Ya se ingreso a la lista");
                    flag = false;
                }
            });
            if (flag) {
                filaProductor += 1;
                $("#tblproductores").append("<tr id='filaProductor" + filaProductor + "'><td class='d-none idproductor'>" + idproductor + "</td><td>" + nombreProductor + "</td><td class='text-right participacion'>" + participacion + "</td><td class='text-center'><a href='#' onclick='eliminarProductor(" + filaProductor + "," + participacion + ")'><i class='material-icons'>clear</i></a></td></tr>");
                partTotal += participacion;
                modificarPresupuesto();
            }
        }
        //fin validar campos    
    });

    //agregar terceros a la lista
    $('#btnAgregarTercero').click(function (e) {
        e.preventDefault();
        let flag = true;
        //validar campos
        if ($("#frmterceros").valid()) {
            let idtercero = 0;
            let nombreTercero = $("#sltterceros option:selected").text();
            //var participacion = ($("#txtParticipacion").val() == "") ? 0 : parseFloat($("#txtParticipacion").val());
            idtercero = parseInt($("#sltterceros option:selected").val());

            if (filaTercero > 0) {
                alert("Solo se puede ingresar un contratista para realizar la orden");
                flag = false;
            }
            if (flag) {
                filaTercero += 1;
                $("#tblterceros").append("<tr id='filaTercero" + filaTercero + "'><td class='d-none idtercero'>" + idtercero + "</td><td>" + nombreTercero + "</td><td class='text-right precioHaTercero'>" + $("#txtPrecioLabor").val() + "</td><td class='text-right superficieTercero d-none'>" + supTotal + "</td><td class='text-center'><a href='#' onclick='eliminarTercero(" + filaTercero + ")'><i class='material-icons'>clear</i></a></td></tr>");
                //modificarPresupuesto();
            }
        }
        //fin validar campos    
    });

    //agregar personal a la lista
    $('#btnAgregarPersonal').click(function (e) {
        e.preventDefault();
        let flag = true;
        //validar campos

        if ($("#frmpersonales").valid()) {
            let idpersonal = 0;
            let nombrePersonal = $("#sltpersonales option:selected").text();
            let precioHa = ($("#txtPrecioHa").val() == "") ? 0 : parseFloat($("#txtPrecioHa").val());
            idpersonal = parseInt($("#sltpersonales option:selected").val());


            $('#tblpersonales tr').each(function () {
                let id = $(this).find(".idpersonal").html();
                if (idpersonal == id) {
                    alert("Ya se ingreso a la lista");
                    flag = false;
                }
            });
            if (flag) {
                filaPersonal += 1;
                $("#tblpersonales").append("<tr id='filaPersonal" + filaPersonal + "'><td class='d-none idpersonal'>" + idpersonal + "</td><td>" + nombrePersonal + "</td><td class='text-right precioHa'>" + precioHa + "</td><td class='text-center'><a href='#' onclick='eliminarPersonal(" + filaPersonal + ")'><i class='material-icons'>clear</i></a></td></tr>");
                modificarPresupuesto();
            }
        }

        //fin validar campos    
    });

    //agregar campo a la lista
    $('#btnAgregarCampo').click(function (e) {
        e.preventDefault();
        let flag = true;
        let idlote = 0;
        let nombreCampo = $("#sltcampos option:selected").text();
        let nombreLote = $('#sltlotes option:selected').text();
        let superficie = ($("#txtsuperficie").val() == "") ? 0 : parseFloat($("#txtsuperficie").val());
        idlote = parseInt($("#sltlotes option:selected").val());

        $('#tblcampos tr').each(function () {
            let id = $(this).find(".idlote").html();
            if (idlote == id) {
                alert("Ya se ingreso a la lista");
                flag = false;
            }
        });
        if (flag) {
            filaCampo += 1;
            $("#tblcampos").append("<tr id='filaCampo" + filaCampo + "'><td class='d-none idlote'>" + idlote + "</td><td>" + nombreCampo + "</td><td>" + nombreLote + "</td><td class='text-right superficie'>" + superficie + "</td><td class='text-center'><a href='#' onclick='eliminarCampo(" + filaCampo + "," + superficie + ")'><i class='material-icons'>clear</i></a></td></tr>");

            supTotal += superficie;
            modificarPresupuesto();
        }
    });

    //cargar el combo de insumos
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

    //agregar insumos a la lista
    $('#btnAgregarInsumo').click(function (e) {
        e.preventDefault();
        let flag = true;
        if ($("#frmInsertarInsumo").valid()) {
            let idinsumo = 0;
            let nombreInsumo = $("#sltinsumos option:selected").text();
            idinsumo = parseInt($("#sltinsumos option:selected").val());
            $('#tblinsumos tr').each(function () {
                let id = $(this).find(".idinsumo").html();
                if (idinsumo == id) {
                    alert("Ya se ingreso a la lista");
                    flag = false;
                }
            });
            if (flag) {
                let precio = 0;
                let cantidad = 0;
                let total = 0;
                precio = ($("#txtprecio").val() == "") ? 0 : parseFloat($("#txtprecio").val());
                cantidad = ($("#txtcantidadInsumo").val() == "") ? 0 : parseFloat($("#txtcantidadInsumo").val());
                total = precio * cantidad;
                totalInsumosha += total;
                filaInsumo += 1;
                $("#tblinsumos").append("<tr id='filaInsumo" + filaInsumo + "'><td class='d-none idinsumo'>" + idinsumo + "</td><td>" + nombreInsumo + "</td><td class='text-right cantidadInsumo'>" + cantidad + " " + $("#txtunidad").val() + "</td><td class='text-right precioInsumo'>" + precio + "</td><td class='text-right'>" + total.toFixed(2) + "</td><td class='text-center'><a href='#' onclick='eliminarInsumo(" + filaInsumo + "," + cantidad + "," + precio + ")'><i class='material-icons'>clear</i></a></td></tr>");

                modificarPresupuesto();
            }
        }
    });

    $('#txtPrecioLabor').change(function (e) {
        e.preventDefault();
        totalLabores = parseFloat($('#txtPrecioLabor').val());
        modificarPresupuesto();
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

    $("#btnModalInsertarInsumo").click(function (e) {
        e.preventDefault();
        $("#txtInsPrecio").val("");
        $("#txtInsCantidadInsumo").val("");
        $("#txtInsInsumo").val("");
    });

    $("#btnInsLoteModal").click(function (e) {
        e.preventDefault();
        $(".nombreCampo").html($("#sltcampos").find('option:selected').text());
        $("#txtInsLote").val("");
        $("#txtInsSupLote").val("");
    });

    $("#btnInsCampoModal").click(function (e) {
        e.preventDefault();
        $("#txtInsCampo").val("");
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
                            modificarPresupuesto();

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

    $("#btnInsertarProductor").click(function (e) {
        e.preventDefault();
        let nombreProductor = $("#txtInsProductor").val();
        let cuit = ($("#txtInsCuit").val() == "") ? 0 : parseInt($("#txtInsCuit").val());
        let direccion = $("#txtInsDireccion").val();
        let slt = $("#sltproductores option");
        if (estaEnElCombo(nombreProductor, slt)) {
            alert("Este Productor ya existe");

        } else {
            if ($("#frmAgregarProductor").valid()) {
                $.ajax({
                    data: "accion=insProductor&productor=" + nombreProductor + "&cuit=" + cuit + "&direccion=" + direccion,
                    type: "GET",
                    dataType: "text",
                    url: "includes/ajax/ajax.php",
                    success: function (datos) {
                        if (datos != "false") {
                            $("#modalInsProductor").hide();
                            $("#modalInsProductor").modal('hide');
                            actualizarListaProductores(datos);
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

    $("#btnInsertarTercero").click(function (e) {
        e.preventDefault();
        let nombreTercero = $("#txtInsTercero").val();
        let cuit = ($("#txtInsCuitTercero").val() == "") ? 0 : parseInt($("#txtInsCuitTercero").val());
        let direccion = $("#txtInsDireccionTercero").val();
        let slt = $("#sltterceros option");
        if (estaEnElCombo(nombreTercero, slt)) {
            alert("Este Contratista ya existe");

        } else {
            if ($("#frmAgregarTerceros").valid()) {
                $.ajax({
                    data: "accion=insTercero&tercero=" + nombreTercero + "&cuit=" + cuit + "&direccion=" + direccion,
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
                            alert("El usuario ya se encuentra registrado. Cambie el rol del usuario para encontrarlo en la lista de contratistas");
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

    $("#btnInsertarPersonal").click(function (e) {
        e.preventDefault();
        let nombrePersonal = $("#txtInsPersonal").val();
        let cuil = ($("#txtInsCuil").val() == "") ? 0 : parseInt($("#txtInsCuil").val());
        let precioHa = $("#txtInsPrecioHa").val();
        let slt = $("#sltpersonales option");
        if (estaEnElCombo(nombrePersonal, slt)) {
            alert("Este Personal ya existe");

        } else {
            if ($("#frmAgregarPersonal").valid()) {
                $.ajax({
                    data: "accion=insPersonal&personal=" + nombrePersonal + "&cuil=" + cuil + "&precioHa=" + precioHa,
                    type: "GET",
                    dataType: "text",
                    url: "includes/ajax/ajax.php",
                    success: function (datos) {
                        if (datos != "false") {
                            $("#modalInsPersonal").hide();
                            $("#modalInsPersonal").modal('hide');
                            actualizarListaPersonales(datos);
                            //modificarPresupuesto();

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
                            modificarPresupuesto();

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





    $("#btnOrdenTrabajo").click(function (e) {
        e.preventDefault();
        generarOrdenPDF();
    });

    $("#btnInformeProductor").click(function (e) {
        e.preventDefault();
        generarInformeProductorPDF();
    });


    $("#btnGuardarOrden").click(function (e) {
        e.preventDefault();
        $("#btnOrdenTrabajo").removeClass("d-none");
        $("#btnInformeProductor").removeClass("d-none");
        $("#btnLimpiarOrden").removeClass("d-none");
        $("#btnGuardarOrden").addClass("d-none");
        guardarOrden();
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
                            modificarPresupuesto();

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

    $("#btnLimpiarOrden").click(function () {
        location.reload();
    });

    jQuery.validator.addMethod("validarCuit",
        function (value, element) {
            cuit = value;
            let coef = [5, 4, 3, 2, 7, 6, 5, 4, 3, 2];
            let sumador = 0;
            let resultado = 0;
            if (cuit == "") {
                return true;
            }
            cuit = cuit.replace("-", "");
            if (isNaN(parseInt(cuit))) {
                return false;
            } else if (cuit.length != 11) {
                return false;
            }
            for (let i = 0; i <= 9; i++) {
                sumador += parseInt(cuit.charAt(i)) * coef[i];
            }
            resultado = 11 - (sumador % 11);
            if (resultado == 11) {
                resultado = 0;
            }
            if (resultado == 10) {
                resultado = 9;
            }
            if (parseInt(cuit.charAt(10)) != resultado) {
                return false;
            }
            return true;
        },
        "Cuit invalido"
    );
    jQuery.validator.addMethod("sololetras", function (value, element) {
        return this.optional(element) || /^[ a-z]+$/i.test(value);
    }, "Solo puede ingresar letras");

    //requisitos de validacion del formulario 
    $("#frmproductores").validate({
        rules: {
            txtParticipacion: {
                required: true,
                number: true,
                max: 100
            }
        }, //cierre de rules

        messages: {
            txtParticipacion: {
                required: "Campo Obligatorio",
                number: "Solo numeros",
                max: "El Valor no puede superar el 100%"
            }
        } //cierre de messages
    });

    $("#frmAgregarProductor").validate({
        rules: {
            txtInsProductor: {
                required: true,
                sololetras: true,
                maxlength: 50
            },
            txtInsCuit: {
                validarCuit: true
            }
        }, //cierre de rules

        messages: {
            txtInsProductor: {
                required: "Campo Obligatorio",
                maxlength: "El Valor no puede superar 50 caracteres"
            },
            txtInsCuit: {
                validarCuit: "El CUIT es invalido"
            }
        } //cierre de messages
    });

    $("#btnAbrirNuevoProductor").click(function () {
        $("#txtInsProductor").val("");
        $("#txtInsCuit").val("");
        $("#txtInsDireccion").val("");
    });

    $("#frmAgregarLabor").validate({
        rules: {
            txtInsLabor: {
                required: true,
                sololetras: true,
                maxlength: 50
            },
            txtInsPrecioLabor: {
                required: true,
                number: true
            }
        }, //cierre de rules

        messages: {
            txtInsLabor: {
                required: "Campo Obligatorio",
                maxlength: "El Valor no puede superar 50 caracteres"
            },
            txtInsPrecioLabor: {
                required: "Se requiere un valor de Labor",
                number: "Solo se acepta un numero valido"
            }
        } //cierre de messages
    });

    $("#btnAbrirNuevoLabor").click(function () {
        $("#txtInsLabor").val("");
        $("#txtInsPrecioLabor").val("");
    });

    $("#frmAgregarLote").validate({
        rules: {
            txtInsLote: {
                required: true,
                maxlength: 50
            },
            txtInsSupLote: {
                required: true,
                number: true
            },
            txtInsCantidadInsumo: {
                required: true,
                number: true
            }
        }, //cierre de rules

        messages: {
            txtInsLote: {
                required: "Campo Obligatorio",
                maxlength: "El Valor no puede superar 50 caracteres"
            },
            txtInsSupLote: {
                required: "Se requiere un valor de Superficie",
                number: "Solo se acepta un numero valido"
            },
            txtInsCantidadInsumo: {
                required: "Debe ingresar una cantidad",
                number: "Solo se acepta un numero valido"
            }
        } //cierre de messages
    });

    /*$("#btnAbrirNuevoLote").click(function () {
     $("#txtInsLote").val("");
     $("#txtInsSupLote").val("");
     });
     */

    $("#frmAgregarCampo").validate({
        rules: {
            txtInsCampo: {
                required: true,
                sololetras: true,
                maxlength: 50
            }
        }, //cierre de rules

        messages: {
            txtInsLote: {
                required: "Campo Obligatorio",
                maxlength: "El Valor no puede superar 50 caracteres"
            }
        } //cierre de messages
    });

    /*
     $("#btnAbrirNuevoCampo").click(function () {
     $("#txtInsCampo").val("");
     });
     */

    $("#frmAgregarInsumo").validate({
        rules: {
            txtInsInsumo: {
                required: true,
                maxlength: 50
            },
            txtInsPrecio: {
                number: true
            },
            txtInsCantidadInsumo: {
                required: true,
                number: true
            }
        }, //cierre de rules

        messages: {
            txtInsInsumo: {
                required: "Campo Obligatorio",
                maxlength: "El Valor no puede superar 50 caracteres"
            },
            txtInsPrecio: {
                number: "Debe ingresar un numero valido"
            },
            txtInsCantidadInsumo: {
                required: "Debe ingresar una cantidad a usar",
                number: "Debe ingresar un numero valido"
            }
        } //cierre de messages
    });

    $("#frmInsertarInsumo").validate({
        rules: {
            txtprecio: {
                number: true
            },
            txtcantidadInsumo: {
                required: true,
                number: true
            }
        }, //cierre de rules

        messages: {
            txtprecio: {
                number: "Debe ingresar un numero valido"
            },
            txtcantidadInsumo: {
                required: "Debe ingresar una cantidad a usar",
                number: "Debe ingresar un numero valido"
            }
        } //cierre de messages
    });
    /*
     $("#btnAbrirNuevoInsumo").click(function () {
     $("#txtInsInsumo").val("");
     $("#txtInsPrecio").val("");
     });
     */

    $('.rb').change(function () {
        let maquinaria = $('input:radio[name=maquinaria]:checked').val();

        if (maquinaria == "maquinariaPropia") {
            $("#tblMaquinaria").removeClass("d-none");
            $("#tblContratistas").addClass("d-none");
        }
        if (maquinaria == "maquinariaContratada") {
            $("#tblContratistas").removeClass("d-none");
            $("#tblMaquinaria").addClass("d-none");
        }

    });


}


//funciones
function eliminarProductor(i, participacion) {
    $("#filaProductor" + i).remove();
    filaProductor -= 1;
    partTotal -= parseFloat(participacion);
    modificarPresupuesto();
}

function eliminarTercero(i) {
    $("#filaTercero" + i).remove();
    filaTercero -= 1;
    modificarPresupuesto();
}

function eliminarPersonal(i) {
    $("#filaPersonal" + i).remove();
    filaPersonal -= 1;
    //modificarPresupuesto();
}

function eliminarCampo(i, sup) {
    $("#filaCampo" + i).remove();
    filaCampo -= 1;
    supTotal -= parseFloat(sup);
    modificarPresupuesto();
}

function eliminarInsumo(i, cantidad, precio) {
    $("#filaInsumo" + i).remove();
    filaInsumo -= 1;
    totalInsumosha -= parseFloat(cantidad) * parseFloat(precio);
    modificarPresupuesto();
}

function modificarPresupuesto() {
    if (supTotal > 0) {
        $("#tdSupTotal").html(supTotal);
        $("#tdTotalLabores").html((supTotal * totalLabores).toFixed(2));
        $("#tdTotalInsumos").html((supTotal * totalInsumosha).toFixed(2));

        $("#tdTotal").html(((supTotal * totalInsumosha) + (supTotal * totalLabores)).toFixed(2));
        $("#maquinariaPropia").attr("disabled", false);
        $("#maquinariaContratada").attr("disabled", false);
    }
    else {
        $("#maquinariaPropia").attr("disabled", true);
        $("#maquinariaContratada").attr("disabled", true);
        $("#tblMaquinaria").addClass("d-none");
        $("#tblContratistas").addClass("d-none");
    }
    if ((supTotal > 0) & (partTotal == 100)) {
        $("#resumen").show();
        $("#resumenMensaje").hide();
    } else {
        $("#resumen").hide();
        $("#resumenMensaje").show();
    }
}




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

function actualizarListaLotes(idcampo, idlote) {
    $("#sltlotes").empty();
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
                        $("#txtsuperficie").val(valor.superficie);
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
    let idtercero = 'idusuario and contratista=true'; //para traer todos los usuarios de la tabla
    $("#sltterceros").empty();
    $.ajax({
        data: "accion=terceros&idtercero=" + idtercero,
        type: "GET",
        dataType: "json",
        url: "includes/ajax/ajax.php",
        success: function (datos) {
            if (datos.length > 0) {
                $.each(datos, function (index, valor) {
                    if (valor.idtercero == parseInt(id)) {
                        var sel = "selected";
                        $("#txtCuitTercero").val(valor.cuit);
                        $("#txtDireccionTercero").val(valor.direccion);
                    }
                    if (valor.idusuario != $("#idUsuarioActivo").val())
                        $("#sltterceros").append('<option value="' + valor.idusuario + '" ' + sel + '>' + valor.usuario + '</option>');
                });
            }
        },
        error: function () {
            alert("error de conexion al actualizar la lista de Contratistas");
        }
    });
}

function actualizarListaPersonales(id) {
    let idpersonal = 'idpersonal';
    $("#sltpersonales").empty();
    $.ajax({
        data: "accion=personales&idpersonal=" + idpersonal,
        type: "GET",
        dataType: "json",
        url: "includes/ajax/ajax.php",
        success: function (datos) {
            if (datos.length > 0) {
                $.each(datos, function (index, valor) {
                    if (valor.idpersonal == parseInt(id)) {
                        var sel = "selected";
                        $("#txtCuil").val(valor.cuil);
                        $("#txtPrecioHa").val(valor.precioHa);
                    }
                    $("#sltpersonales").append('<option value="' + valor.idpersonal + '" ' + sel + '>' + valor.personal + '</option>');
                });
            }
        },
        error: function () {
            alert("error de conexion");
        }
    });
}

function guardarOrden() { //guarda los datos de la orden de trabajo en la BD

    let dOrden = datosOrden();
    let dProductores = datosProductores();
    let dTerceros = datosTerceros();
    let dPersonales = datosPersonales();
    let dCampos = datosCampos();
    let dInsumos = datosInsumos();

    var datos = "orden=" + dOrden + "&productores=" + dProductores + "&campos=" + dCampos;
    if (dInsumos != null) datos += "&insumos=" + dInsumos;
    if (dTerceros != null) datos += "&terceros=" + dTerceros;
    if (dPersonales != null) datos += "&personales=" + dPersonales;


    $.ajax({
        data: datos,
        type: "POST",
        dataType: "text",
        url: "includes/ajax/guardarOrden.php",
        success: function (datos) {
            if (datos>0) {
                $('#alerta').append('<div class="alert alert-success alert-dismissible fade show" id="alerta" role="alert">Se guardaron los datos con exito <button type = "button" class= "close" data-dismiss="alert" aria-label="Close" ><span aria-hidden="true">&times;</span></button ></div >');
                idOrdenTrabajo=datos;
            }
            else {
                alert("Se produjo un error");
            }
        },
        error: function () {
            alert("error en la conexion al guardar la nueva orden de trabajo");
        }
    });

}

function datosOrden() {
    datosOrden = {
        fecha: $('#fecha').val(),
        precioLabor: $("#txtPrecioLabor").val(),
        idlabor: $("#sltlabores").val(),
        precioLabor: $("#txtPrecioLabor").val(),
        observacion: $("#txtobservaciones").val(),
        supTotal: supTotal,
        idusuario: $("#idUsuarioActivo").val(),
        idcampana: $("#idCampanaActiva").val()
    };
    return JSON.stringify(datosOrden)
}

function datosProductores() {  //guarda los datos de los productores asignados a la orden de trabajo
    let datos = [];
    let d;
    let i;
    if (filaProductor > 0) {
        for (i = 1; i <= filaProductor; i++) //recorrer la tabla de productores para guardar en la base de datos
        {
            d = {
                idproductor: $("#filaProductor" + i + " .idproductor").html(),
                superficie: parseFloat($("#filaProductor" + i + " .participacion").html()) * supTotal / 100

            };
            datos.push(d);
        }
    } //fin for
    return JSON.stringify(datos);
}

function datosTerceros() { //guarda los datos de los contratistas asignados a la orden de trabajo
    let datos = [];
    let d;
    let i;

    if (filaTercero > 0) {
        for (i = 1; i <= filaTercero; i++) //recorrer la tabla de productores para guardar en la base de datos
        {
            d = {
                idtercero: $("#filaTercero" + i + " .idtercero").html(),
                precioHaTercero: parseFloat($("#filaTercero" + i + " .precioHaTercero").html())
            };
            datos.push(d);
        }
    } //fin for
    return JSON.stringify(datos);
}

function datosPersonales() { //guarda los datos de los personales asignados a la orden de trabajo
    let datos = [];
    let d;
    let i;
    if (filaPersonal > 0) {
        for (i = 1; i <= filaPersonal; i++) //recorrer la tabla de productores para guardar en la base de datos
        {
            d = {
                idpersonal: $("#filaPersonal" + i + " .idpersonal").html(),
                superficie: supTotal,
                precioHa: $("#filaPersonal" + i + " .precioHa").html()
            };
            datos.push(d);
        }
    } //fin for
    return JSON.stringify(datos);
}


function datosCampos() {  //guarda los datos de los campos asignados a la orden de trabajo
    let datos = [];
    let d;
    let i;
    if (filaCampo > 0) {
        for (i = 1; i <= filaCampo; i++) //recorrer la tabla de campos para guardar en la base de datos
        {
            d = {
                idlote: $("#filaCampo" + i + " .idlote").html(),
                superficie: parseFloat($("#filaCampo" + i + " .superficie").html()),
            };
            datos.push(d);
        }
    } //fin for
    return JSON.stringify(datos);
}

function datosInsumos() { //guarda los datos de los insumos asignados a la orden de trabajo
    let datos = [];
    let d;
    let i;
    if (filaInsumo > 0) {
        for (i = 1; i <= filaInsumo; i++) //recorrer la tabla de campos para guardar en la base de datos
        {
            d = {
                idinsumo: $("#filaInsumo" + i + " .idinsumo").html(),
                cantidad: parseFloat($("#filaInsumo" + i + " .cantidadInsumo").html()),
                precio: parseFloat($("#filaInsumo" + i + " .precioInsumo").html()),
                superficie: supTotal
            };
            datos.push(d);
        }
    } //fin for
    return JSON.stringify(datos);
}


function generarOrdenPDF() {
    let ancho = 2400;
    let alto = 1000;
    let x = parseInt((window.screen.width / 2) - (ancho / 2));
    let y = parseInt((window.screen.height / 2) - (alto / 2));
    $url = "generaOrden.php?idorden=" + idOrdenTrabajo;
    //window.open($url,"Orden de trabajo","left="+x+"top="+y,"height="+alto+"width="+ancho);
    window.open($url, "Orden de trabajo");

}

function generarInformeProductorPDF() {
    $url = "generaInformeProductor.php?idorden=" + idOrdenTrabajo;
    //window.open($url,"Orden de trabajo","left="+x+"top="+y,"height="+alto+"width="+ancho);
    window.open($url, "Informe de la Orden de trabajo");
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