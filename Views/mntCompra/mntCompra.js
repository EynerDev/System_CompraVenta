let emp_id = $('#EMP_IDx').val()
let suc_id = $('#SUC_IDx').val()
let user_id = $('#USER_IDx').val()
$(document).ready(function() {

    $('#prov_id, #cat_id, #prod_id, #pago_id, #mon_id').select2();


    $.post("../../Controller/CompraController.php?op=registrar",{suc_id:suc_id, user_id:user_id})
    .done(function(data) {
        data = JSON.parse(data)
        console.log(data)
        $('#compra_id').val(data.COMPRA_ID)
        
    })
    .fail(function(error) {
        console.error("Error en la solicitud:", error);
    });
    

    $.post("../../Controller/MonedaController.php?op=combo",{suc_id:suc_id})
    .done(function(data) {
        $("#mon_id").html(data)        
    })
    .fail(function(error) {
        console.error("Error en la solicitud:", error);
    });

    
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
                $('#prov_rut').val(data.PROV_RUT)
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
                })

    })
});
function eliminar(det_id,compra_id){
    swal.fire({
        title: "Eliminar",
        text: "¿Estás seguro de eliminar este registro?",
        icon: "error",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"

    }).then((result => {
        if (result.value){
            $.post("../../Controller/CompraController.php?op=eliminar",{det_id:det_id}, function(data){
              console.log(data)
              
            })
            calculo_detalle(compra_id)
        
            swal.fire({
                title : "Compra y Venta",
                text : "Registro Eliminado",
                icon : "success",
            })
            $("#table_datos").DataTable().ajax.reload();
        }

    }));
}
function init_table(compra_id){
    $('#table_datos').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
        ],
        "ajax": {
            url: "../../Controller/CompraController.php?op=listar_detalle",
            type: "post",
            data: { compra_id : compra_id},
            dataSrc: function(json) {
                console.log("Response from server:", json); // Depurar la respuesta del servidor
                if (!json.aaData) {
                    console.error("Invalid JSON response:", json);
                    return [];
                }
                return json.aaData;
            }
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo": true,
        "iDisplayLength": 10,
        "order": [[0, "desc"]],
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
    });
}
function calculo_detalle(compra_id){
    $.post("../../Controller/CompraController.php?op=calculo",{
        compra_id: compra_id, })
        .done(function(data){
            data = JSON.parse(data)
            $('#compra_sub_total').html(data.SUBTOTAL)
            $("#compra_iva").html(data.IVA)
            $("#compra_total").html(data.TOTAL)
        })
        .fail(function(error) {
            console.error("Error en la solicitud:", error);
        });
}
function isEmpty(value) {
    return value === "" || value === null || value === undefined;
}
$(document).on("click","#btn_agregar",function(){
    let compra_id = $("#compra_id").val()
    let prod_id = $("#prod_id").val()
    let prod_pcompra = $("#prod_pcompra").val()
    let det_cant = $("#prod_stock").val()

// Función para verificar si un valor está vacío
if (isEmpty(compra_id) || isEmpty(prod_id) || isEmpty(prod_pcompra) || isEmpty(det_cant)) {
    swal.fire({
        title: "Error",
        text: "Hay campos vacíos",
        icon: "error",
    });
} else {
    $.post("../../Controller/CompraController.php?op=detalle", {
        compra_id: compra_id,
        prod_id: prod_id,
        prod_pcompra: prod_pcompra,
        det_cant: det_cant
    })
    .done(function() {
        // Acciones a realizar en caso de éxito
        calculo_detalle(compra_id);
        $("#prod_pcompra").val('')
        $("#prod_stock").val('')

        init_table(compra_id);
        $('#table_datos').DataTable().ajax.reload();

    
    })
    .fail(function(error) {
        console.error("Error en la solicitud:", error);
    });
}
 
    
});

$(document).on("click","#btn_guardar",function(){
    let compra_id = $("#compra_id").val()
    let prov_id = $("#prov_id").val()
    let pago_id = $("#pago_id").val()
    let prov_rut = $("#prov_rut").val()
    let prov_dirc = $("#prov_direcc").val()
    let prov_email = $("#prov_email").val()
    let mon_id = $("#mon_id").val()
    let prov_number = $("#prov_number").val()
    let prov_coment = $("#prov_coment").val()

    if (isEmpty(compra_id) || isEmpty(prov_id) || isEmpty(pago_id) || isEmpty(prov_rut) 
        || isEmpty(prov_dirc) || isEmpty(prov_email) || isEmpty(mon_id) 
        || isEmpty(prov_number))
        {
            swal.fire({
                title: "Error",
                text: "Hay campos vacios",
                icon: "error",
            });
    } else {
        $.post("../../Controller/CompraController.php?op=calculo",{
            compra_id: compra_id, })
        .done(function(data){
            data = JSON.parse(data)
            console.log(data)
            if (isEmpty(data.TOTAL)){
                swal.fire({
                    title: "Compra",
                    text: "No existen detalles",
                    icon: "error",
                });

            }else{
                $.post("../../Controller/CompraController.php?op=guardar", {
                    compra_id: compra_id,
                    pago_id: pago_id,
                    prov_id: prov_id,
                    prov_rut: prov_rut,
                    prov_dirc: prov_dirc,
                    prov_email: prov_email,
                    mon_id: mon_id,
                    prov_number: prov_number,
                    prov_coment: prov_coment,
                })
                .done(function() {
            
                    swal.fire({
                        title: "Compra",
                        text: "Compra registrada exitosamente N°: C-" + compra_id,
                        icon: "success",
                        showCancelButton: true,
                        confirmButtonText: 'Ver PDF',
                        cancelButtonText: 'OK',
                    }).then((result) => {
                        if (result.value) { 
                            // Abre la vista de la compra en una nueva ventana si se hace clic en 'Ver PDF'
                            redirigirAVistaCompra(compra_id);
                        } else {
                            // No haces nada o realizas alguna otra acción si se presiona 'Cancelar' o 'OK'
                        }
                    });
                    
                    
                })
                .fail(function(error) {
                    console.error("Error en la solicitud:", error);
                });
               

            }
            
        })
        .fail(function(error) {
            console.error("Error en la solicitud:", error);
        });


        
    }

})

function redirigirAVistaCompra(compra_id) {
    
    let url = `../viewCompra/?c=${compra_id}`;
    window.open(url, '_blank');
}


$(document).on("click","#btnlimpiar",function(){
    location.reload();
});


