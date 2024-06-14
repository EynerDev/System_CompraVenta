let com_id = $('#COM_IDx').val()
function init(){
    $("#mantenimiento_form").on("submit",function(e){
        guardaryeditar(e);
    });
}

function guardaryeditar(e) {
    e.preventDefault();
    var formData = new FormData($("#mantenimiento_form")[0]);
    formData.append('com_id', $('#COM_IDx').val());
    $.ajax({
        url: "../../Controller/EmpresaController.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
                if (response) {
                    data = JSON.parse(response)
                    // La respuesta indica éxito
                    $('#table_datos').DataTable().ajax.reload();
                    $('#ModalEmpresa').modal('hide');
                    Swal.fire({
                        title: 'Empresa',
                        text: data.message,
                        icon: 'success'
                    });
                } else {
                    // La respuesta indica un error
                    Swal.fire({
                        title: 'Error',
                        text: data.message,
                        icon: 'error'
                    });
                }
            
        
    
        }
    }
)}

$(document).ready(function() { // Puedes obtener este valor dinámicamente según tus necesidades

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
            url: "../../controller/EmpresaController.php?op=listar",
            type: "post",
            data: { com_id : com_id},
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

function editar(emp_id){
    $.post("../../Controller/EmpresaController.php?op=mostrar",{emp_id:emp_id}, function(data){
        data=JSON.parse(data);
        $("#emp_id").val(data.EMP_ID)
        $("#emp_name").val(data.EMP_NAME)
        $("#emp_rut").val(data.EMP_RUT)
    });
    $("#lblTitle").html("Editar Registro")
    $("#ModalEmpresa").modal("show");


}
function eliminar(emp_id){
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
            $.post("../../Controller/EmpresaController.php?op=eliminar",{emp_id:emp_id}, function(data){
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
    $('#emp_id').val('');
    $('#emp_name').val('');
    $('#emp_rut').val('');
    $('#lblTitle').html('Nuevo Registro');
    $("#mantenimiento_form")[0].reset();
    $('#ModalEmpresa').modal('show');
});

init();