let emp_id = $('#EMP_IDx').val()
function init(){
    $('#tipo_doc_id').select2();
    $.post("../../Controller/TipoDocController.php?op=combo",)
    .done(function(data) {
        $("#tipo_doc_id").html(data);
        $("#mantenimiento_form").on("submit",function(e){
            guardaryeditar(e);
        });
    })

    .fail(function(error) {
        console.error("Error en la solicitud:", error);
    });
}


function guardaryeditar(e) {  
    e.preventDefault();
    var formData = new FormData($("#mantenimiento_form")[0]);
    formData.append('emp_id', emp_id);
    $.ajax({
        url: "../../Controller/ClienteController.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            // Intenta analizar la respuesta como JSON
                if (response) {
                    data = JSON.parse(response)
                    // La respuesta indica éxito
                    $('#table_datos').DataTable().ajax.reload();
                    $('#ModalCliente').modal('hide');
                    Swal.fire({
                        title: 'Cliente',
                        text:data.message,
                        icon: data.icon
                    });
                } else {
                    // La respuesta indica un error
                    Swal.fire({
                        title: 'Error',
                        text: data.message,
                        icon: data.icon
                    });
                }
            
        },
    });
}

$(document).ready(function() {

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
            url: "../../Controller/ClienteController.php?op=listar",
            type: "post",
            data: { emp_id : emp_id},
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
});

function editar(cli_id){
    $.post("../../Controller/ClienteController.php?op=mostrar",{cli_id:cli_id}, function(data){
        data=JSON.parse(data);
        $("#cli_id").val(data.CLI_ID)
        $("#cli_name").val(data.CLI_NAME)
        $("#tipo_doc_id").val(data.TIPO_DOC_ID).trigger('change');
        $("#cli_doc").val(data.CLI_DOC)
        $("#cli_number").val(data.CLI_NUMBER)
        $("#cli_direcc").val(data.CLI_DIRECC)
        $("#cli_email").val(data.CLI_EMAIL)
    })

    $("#lblTitle").html("Editar Registro")
    $("#ModalCliente").modal("show");


}
function eliminar(cli_id){
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
            $.post("../../Controller/ClienteController.php?op=eliminar",{cli_id:cli_id}, function(){
            
            })
           
            $("#table_datos").DataTable().ajax.reload();

            swal.fire({
                title : "Compra y Venta",
                text : "Registro Eliminado",
                icon : "success",
                confirmButtonClass : "btn-success"


            })
        }

    }));
}


$(document).on("click","#btn_nuevo",function(){
    $('#cli_id').val('');
    $('#cli_name').val('');
    $('#tipo_doc_id').val('');
    $('#cli_doc').val('');
    $('#cli_number').val('');
    $('#cli_direcc').val('');
    $('#cli_email').val('');
    $('#lblTitle').html('Nuevo Registro');
    $("#mantenimiento_form")[0].reset();
    $('#ModalCliente').modal('show');
});

init();