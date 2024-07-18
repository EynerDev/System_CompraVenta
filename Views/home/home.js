let suc_id = $('#SUC_IDx').val()

$.post("../../Controller/CompraController.php?op=listar_top_productos",{suc_id:suc_id})
    .done(function(data) {

        $("#listtopcompraproducto").html(data);
    })
    .fail(function(error) {
        console.error("Error en la solicitud:", error);
    });

$.post("../../Controller/VentaController.php?op=listar_top_productos",{suc_id:suc_id})
.done(function(data) {
    $("#listtopventaproducto").html(data);
})
.fail(function(error) {
    console.error("Error en la solicitud:", error);
});