let emp_id = $('#EMP_IDx').val()
let suc_id = $('#SUC_IDx').val()
$(document).ready(function() {
    $('#prov_id').select2()
    $('#cat_id').select2()
    $('#prod_id').select2()
    $('#pago_id').select2()


    $.post("../../Controller/ProveedorController.php?op=combo",{emp_id:emp_id})
    .done(function(data) {
        $("#prov_id").html(data);

    })
    .fail(function(error) {
        console.error("Error en la solicitud:", error);
    });

    $.post("../../Controller/CategoriaController.php?op=combo",{suc_id:suc_id})
    .done(function(data) {
        $("#cat_id").html(data);

    })
    .fail(function(error) {
        console.error("Error en la solicitud:", error);
    });
    $.post("../../Controller/PagoController.php?op=combo")
    .done(function(data) {
        $("#pago_id").html(data);

    })
    .fail(function(error) {
        console.error("Error en la solicitud:", error);
    });


    // Añade un listener de evento change al elemento #emp_id
    $("#prov_id").change(function() {
        prov_id = $(this).val();
        // Realiza una solicitud AJAX POST a ProveedorController.php con el prov_id seleccionado
        $.post("../../Controller/ProveedorController.php?op=mostrar", { prov_id: prov_id })
            .done(function(data) {
                console.log("Datos recibidos:", data);
                data = JSON.parse(data)
                $('#prov_ruc').val(data.PROV_RUT)
                $('#prov_direcc').val(data.PROV_DIRC)
                $('#prov_email').val(data.PROV_EMAIL)
                $('#prov_number').val(data.PROV_NUMBER)
            })
            .fail(function(error) {
                console.error("Error en la solicitud:", error);
            });
    });
    
    
    $("#cat_id").change(function() {
        cat_id = $(this).val();
        // Realiza una solicitud AJAX POST a ProveedorController.php con el prov_id seleccionado
        $.post("../../Controller/ProductoController.php?op=combo", { cat_id: cat_id })
            .done(function(data) {
                console.log("Datos recibidos:", data);
                $("#prod_id").html(data)

            })
            .fail(function(error) {
                console.error("Error en la solicitud:", error);
            });
    });
    $("#prod_id").change(function(){
        prod_id = $(this).val();
        $.post("../../Controller/ProductoController.php?op=mostrar", { prod_id:prod_id })
                .done(function(data){
                    data = JSON.parse(data)
                    $('#prod_pcompra').val(data.PROD_PCOMPRA)
                    $("#unid_medida").val(data.UNID_NAME)
                    $("#prod_stock").val(data.PROD_STOCK)
                    $("#mon_name").val(data.MON_NAME)
                })

    })





});