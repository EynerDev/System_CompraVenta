$(document).ready(function() {

    let compra_id = getUrlParameter('c')
    $.post("../../Controller/CompraController.php?op=listar_pdf", {compra_id: compra_id,})
    .done(function(data) {
        let datos = JSON.parse(data)
        console.log(datos)
        $('#txt_dirc').html(datos.EMP_DIRC)
        $("#txt_rut").html(datos.EMP_RUT)
        $("#txt_email").html(datos.EMP_EMAIL)
        $('#txt_number').html(datos.EMP_TEL)
        $("#compra_id").html(datos.COMPRA_ID)
        $("#txt_sitio").html(datos.EMP_WEBSITE)
        $('#pago_id').html(datos.PAGO_NAME)
        $("#compra_total").html(datos.TOTAL)
        $("#created_at").html(datos.FECHA_COMPRA)
        $("#sub_total").html(datos.SUB_TOTAL)
        $("#compra_iva").html(datos.IVA)
        $("#compra_total2").html(datos.TOTAL)
        $("#compra_coment").html(datos.COMPRA_COMENT)
        $("#mon_name").html(datos.MON_NAME)        
        $("#user_name").html(datos.USER_NAME+' '+datos.USER_APE)
        $("#prov_name").html(datos.PROV_NAME)
        $("#prov_email").html(datos.PROV_EMAIL)
        $("#prov_number").html(datos.PROV_NUMBER)
        $("#prov_rut").html(datos.PROV_RUT)
        $("#prov_dirc").html(datos.PROV_DIRC)



    })
    $.post("../../Controller/CompraController.php?op=listar_detalle_pdf", {compra_id: compra_id,})
    .done(function(data) {
        $("#list_detalles").html(data)
        
        
    })


})

function getUrlParameter(parameter) {
    const parametrosUrl = new URLSearchParams(window.location.search);
    return parametrosUrl.get(parameter);
}







