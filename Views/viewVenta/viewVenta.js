$(document).ready(function() {
    let venta_id = getUrlParameter('c');
    // Obtener datos principales de la venta
    $.post("../../Controller/VentaController.php?op=listar_pdf", { venta_id: venta_id })
    .done(function(data) {
        var data = JSON.parse(data);
        // Insertar datos en los elementos HTML correspondientes
        $('#txt_dirc').html(data.EMP_DIRC);
        $("#txt_rut").html(data.EMP_RUT);
        $("#txt_email").html(data.EMP_EMAIL);
        $('#txt_number').html(data.EMP_TEL);
        $("#venta_id").html(data.VENTA_ID);
        $("#txt_sitio").html(data.EMP_WEBSITE);
        $('#pago_id').html(data.PAGO_NAME);
        $("#venta_total").html(data.VENTA_TOTAL);
        $("#created_at").html(data.CREATED_AT);
        $("#sub_total").html(data.VENTA_SUB_TOTAL);
        $("#venta_iva").html(data.VENTA_IVA);
        $("#venta_total2").html(data.VENTA_TOTAL);
        $("#venta_coment").html(data.VENTA_COMENT);
        $("#mon_name").html(data.MON_NAME);
        $("#user_name").html(data.USER_NAME + ' ' + data.USER_APE);
        $("#cli_name").html(data.CLI_NAME);
        $("#cli_email").html(data.CLI_EMAIL);
        $("#cli_number").html(data.CLI_NUMBER);
        $("#cli_doc").html(data.CLI_DOC);
        $("#cli_dirc").html(data.CLI_DIRECC);
    })
    .fail(function(error) {
        console.error("Error en la solicitud de datos principales:", error);
    });

    // Obtener detalles de la venta
    $.post("../../Controller/VentaController.php?op=listar_detalle_pdf", { venta_id: venta_id })
    .done(function(data) {
    
        $("#list_detalles").html(data); // Insertar detalles en el contenedor HTML correspondiente
    })
    .fail(function(error) {
        console.error("Error en la solicitud de detalles de venta:", error);
    });
});

function getUrlParameter(parameter) {
    const parametrosUrl = new URLSearchParams(window.location.search);
    return parametrosUrl.get(parameter);
}
