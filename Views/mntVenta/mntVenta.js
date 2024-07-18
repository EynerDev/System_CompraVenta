let emp_id = $('#EMP_IDx').val()
let suc_id = $('#SUC_IDx').val()
let user_id = $('#USER_IDx').val()
$(document).ready(function() {

    $('#cat_id, #prod_id, #pago_id, #mon_id, #cli_id, #doc_id').select2();


    $.post("../../Controller/VentaController.php?op=registrar",{suc_id:suc_id, user_id:user_id})
    .done(function(data) {
        data = JSON.parse(data)
        $('#venta_id').val(data.VENTA_ID)
        
    })
    $.post("../../Controller/DocumentoController.php?op=combo",{doc_tipo:"Venta"})
    .done(function(data) {
        $("#doc_id").html(data)  
        
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

    
    $.post("../../Controller/ClienteController.php?op=combo",{emp_id:emp_id})
    .done(function(data) {
        $("#cli_id").html(data);

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
    $("#cli_id").change(function() {
        cli_id = $(this).val();
        // Realiza una solicitud AJAX POST a ClienteController.php con el prov_id seleccionado
        $.post("../../Controller/ClienteController.php?op=mostrar", { cli_id: cli_id })
            .done(function(data) {
                data = JSON.parse(data)
                $('#cli_tipo_doc_id').val(data.TIPO_DOC_ID)
                $('#cli_tipo_doc_name').val(data.DESCRIPTION)
                $('#cli_doc').val(data.CLI_DOC)
                $('#cli_direcc').val(data.CLI_DIRECC)
                $('#cli_email').val(data.CLI_EMAIL)
                $('#cli_number').val(data.CLI_NUMBER)
            })
            .fail(function(error) {
                console.error("Error en la solicitud:", error);
            });
    });
    
    
    $("#cat_id").change(function() {
        cat_id = $(this).val();
        // Realiza una solicitud AJAX POST a ClienteController.php con el prov_id seleccionado
        $.post("../../Controller/ProductoController.php?op=combo", { cat_id: cat_id })
            .done(function(data) {
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
                    $('#prod_pventa').val(data.PROD_PVENTA)
                    $("#unid_medida").val(data.UNID_NAME)
                })

    })
});
function eliminar(det_venta_id,venta_id){
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
            $.post("../../Controller/VentaController.php?op=eliminar",{det_venta_id:det_venta_id}, function(){              
            })
            
            swal.fire({
                title : "Venta y Venta",
                text : "Registro Eliminado",
                icon : "success",
            })
            calculo_detalle(venta_id)
            $("#table_datos").DataTable().ajax.reload();
        }

    }));
}
function init_table(venta_id){
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
            url: "../../Controller/VentaController.php?op=listar_detalle",
            type: "post",
            data: { venta_id : venta_id},
            dataSrc: function(json) {
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
function calculo_detalle(venta_id){
    $.post("../../Controller/VentaController.php?op=calculo",{
        venta_id: venta_id, })
        .done(function(data){
            data = JSON.parse(data)
            $('#venta_sub_total').html(data.SUB_TOTAL)
            $("#venta_iva").html(data.IVA)
            $("#venta_total").html(data.TOTAL)
        })
        .fail(function(error) {
            console.error("Error en la solicitud:", error);
        });
}
function isEmpty(value) {
    return value === "" || value === null || value === undefined;
}
$(document).on("click","#btn_agregar",function(){

    let venta_id = $("#venta_id").val()
    let prod_id = $("#prod_id").val()
    let prod_pventa = $("#prod_pventa").val()
    let det_vent_cant = $("#prod_stock").val()

// Función para verificar si un valor está vacío
if (isEmpty(venta_id) || isEmpty(prod_id) || isEmpty(prod_pventa) || isEmpty(det_vent_cant)) {
    swal.fire({
        title: "Error",
        text: "Hay campos vacíos",
        icon: "error",
    });
} else {

    
    $.post("../../Controller/VentaController.php?op=detalle", {
        venta_id: venta_id,
        prod_id: prod_id,
        prod_pventa: prod_pventa,
        det_venta_cant: det_vent_cant
    })
    .done(function(data) {
        // Acciones a realizar en caso de éxito
        let datos = JSON.parse(data);
        console.log(datos)

            if (datos.success) {
                // Acciones a realizar en caso de éxito
                swal.fire({
                    title: "Éxito",
                    text: datos.message,
                    icon: "success",
                });

                calculo_detalle(venta_id);
                $("#prod_pventa").val('');
                $("#prod_stock").val('');
                init_table(venta_id);
            } else {
                // Mostrar error en caso de stock insuficiente
                swal.fire({
                    title: "Error",
                    text: datos.message,
                    icon: "error",
                });
            }
    })
    .fail(function(error) {
        console.error("Error en la solicitud:", error);
    });

}
 
    
});

$(document).on("click","#btn_guardar",function(){
    let venta_id = $("#venta_id").val()
    let cli_id = $("#cli_id").val()
    let pago_id = $("#pago_id").val()
    let cli_tipo_doc_id = $("#cli_tipo_doc_id").val()
    let cli_doc = $("#cli_doc").val()
    let cli_email = $("#cli_email").val()
    let cli_number = $("#cli_number").val()
    let mon_id = $("#mon_id").val()
    let venta_coment = $("#venta_coment").val()
    let cli_direcc = $("#cli_direcc").val()
    let doc_id = $("#doc_id").val()

    if (isEmpty(doc_id) || isEmpty(venta_id) || isEmpty(pago_id) || isEmpty(cli_id) || isEmpty(cli_tipo_doc_id) 
        || isEmpty(cli_doc) || isEmpty(cli_email) || isEmpty(cli_number) 
        || isEmpty(cli_direcc) || isEmpty(mon_id) )
        {
            swal.fire({
                title: "Error",
                text: "Hay campos vacios" ,
                icon: "error",
            });
    } else {
        $.post("../../Controller/VentaController.php?op=calculo",{venta_id: venta_id})
        .done(function(data){
            datos = JSON.parse(data)
            if (isEmpty(datos.TOTAL)){
                swal.fire({
                    title: "Venta",
                    text: "No existen detalles",
                    icon: "error",
                });

            }else{
                $.post("../../Controller/VentaController.php?op=guardar",{
                    venta_id: venta_id,
                    pago_id: pago_id,
                    cli_id: cli_id,
                    cli_tipo_doc_id: cli_tipo_doc_id,
                    cli_doc: cli_doc,
                    cli_direcc: cli_direcc,
                    cli_email: cli_email,
                    cli_number: cli_number,
                    mon_id: mon_id,
                    venta_coment: venta_coment,
                    doc_id: doc_id,
                    
                })
                .done(function() {
            
                    swal.fire({
                        title: "Venta",
                        text: "Venta registrada exitosamente N°: V-" + venta_id,
                        icon: "success",
                        showCancelButton: true,
                        confirmButtonText: 'Ver PDF',
                        cancelButtonText: 'OK',
                    }).then((result) => {
                        if (result.value) { 
                            // Abre la vista de la venta en una nueva ventana si se hace clic en 'Ver PDF'
                            redirigirAVistaVenta(venta_id);
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

function redirigirAVistaVenta(venta_id) {
    
    let url = `../viewVenta/?c=${venta_id}`;
    window.open(url, '_blank');
}


$(document).on("click","#btnlimpiar",function(){
    location.reload();
});


