$(document).ready(iniciarEventosCuentas);

function iniciarEventosCuentas() {
    $("#btnNuevoTipoCuenta").click(function (e) {
        e.preventDefault();
        $("#agregarTipoCuenta").toggleClass("d-none");
        $("#sltTipoCuenta").toggleClass("d-none");
    });

    $("#btnAgregarTipoCuenta").click(function (e) {
        e.preventDefault();
        let tipo = $("#txtNuevoTipoCuenta").val();
        
        if (tipo != "") {
            $.ajax({
                type: "GET",
                url: "includes/ajax/cuentas.php",
                data: "accion=agregarTipoCuenta&tipo=" + tipo,
                dataType: "text",
                success: function (id) {
                    if(id!=0)
                    {
                    $("#sltTipoCuenta").append("<option value='"+id+"' selected>" + tipo + "</option>");
                    $("#btnNuevoTipoCuenta").click();
                    }else{
                        alert("Ocurrio un error al guardar el tipo de Cuenta");
                    }
                }
            });

        }
    });

    $("#btnNuevaMoneda").click(function (e) {
        e.preventDefault();
        $("#agregarMoneda").toggleClass("d-none");
        $("#sltMoneda").toggleClass("d-none");
    });

    $("#btnAgregarMoneda").click(function (e) {
        e.preventDefault();
        let moneda = $("#txtNuevaMoneda").val();
        if (moneda != "") {
            $.ajax({
                type: "GET",
                url: "includes/ajax/cuentas.php",
                data: "accion=agregarMoneda&moneda=" + moneda,
                dataType: "text",
                success: function (id) {
                    if(id!=0)
                    {
                    $("#sltMoneda").append("<option value='"+id+"' selected>" + moneda + "</option>");
                    $("#btnNuevaMoneda").click();
                    }else{
                        alert("Ocurrio un error al guardar la Moneda");
                    }
                }
            });

        }
    });

}
