function init(){
    $("#mantenimiento_form").on("submit",function(e){
        guardaryeditar(e);
    });
}

function guardaryeditar(e){
    e.preventDefault();
    var formData = new FormData($("#mantenimiento_form")[0]);
    formData.append('suc_id',$('#SUC_IDx').val());
    $.ajax({
        url:"../../Controller/CategoriaController.php?op=guardaryeditar",
        type:"POST",
        data:formData,
        contentType:false,
        processData:false,
        success:function(){
            $('#table_datos').DataTable().ajax.reload();
            $('#ModalCategoria').modal('hide');

            swal.fire({
                title:'Categoria',
                text: 'Registro Exitoso',
                icon: 'success'
            });
        }
    });
}

$(document).ready(function() {
    var suc_id = 1; // Puedes obtener este valor dinámicamente según tus necesidades

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
            url: "../../controller/CategoriaController.php?op=listar",
            type: "post",
            data: { suc_id : 1},
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
});

function editar(cat_id){
    $.post("../../Controller/CategoriaController.php?op=mostrar",{cat_id:cat_id}, function(data){
        console.log(data)
        $("#cat_id").val(data.CAT_ID)
        $("#cat_name").val(data.CAT_NAME)
    })

    $("#lblTitle").html("Editar Registro")
    $("#ModalCategoria").modal("show");


}
function eliminar(cat_id){
    swal.fire({
        title: "Eliminar",
        text: "Estas Seguro de eliminar este registro",
        icon:"error",
        confirmButtonText : "Si",
        showCancelButton: true,
        cancelButtonText: "No",

    }).then((result => {
        if (result.value){
            $.post("../../Controller/CategoriaController.php?op=eliminar",{cat_id:cat_id}, function(data){
              console.log(data)
            })
           
            $("#table_datos").DataTable().ajax.reload();

            swal.fire({
                title : "Compra y Venta",
                text : "Registro Eliminado",
                type : "success",
                confirmButtonClass : "btn-success"


            })
        }

    }));
}


$(document).on("click","#btn_nuevo",function(){
    $('#cat_id').val('');
    $('#cat_name').val('');
    $('#lblTitle').html('Nuevo Registro');
    $("#mantenimiento_form")[0].reset();
    $('#ModalCategoria').modal('show');
});

init();