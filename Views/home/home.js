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


$.post("../../Controller/CompraController.php?op=listar_top_compras",{suc_id:suc_id})
.done(function(data) {

   $("#listventatop5").html(data);
})
.fail(function(error) {
    console.error("Error en la solicitud:", error);
});
$.post("../../Controller/CategoriaController.php?op=listar_stock_categorias",{suc_id:suc_id})
.done(function(data) {

   $("#listcategoriastock").html(data);
})
.fail(function(error) {
    console.error("Error en la solicitud:", error);
});


$.post("../../Controller/CompraController.php?op=listar_top_compras_ventas",{suc_id:suc_id})
.done(function(data) {

   $("#listcompraventa").html(data);
})
.fail(function(error) {
    console.error("Error en la solicitud:", error);
});

$.ajax({
    url: "../../Controller/CompraController.php?op=dountcompra",
    method: "POST",
    data: {
        suc_id: suc_id
    },
    success: function(response) {
        var data = JSON.parse(response);
        console.log(data); // Agrega esta línea para ver la estructura de los datos
        var cantidad = [];
        var categoria = [];

        for (var i in data) {
            cantidad.push(data[i].CANT);
            categoria.push(data[i].CAT_NAME);
        }

        console.log('Categoría:', categoria); // Verifica si el array categoría se está llenando correctamente

        // Construir el gráfico
        var isdoughnutchart = document.getElementById("doughnut");
        var doughnutChartColors = getChartColorsArray("doughnut");

        if (doughnutChartColors) {
            new Chart(isdoughnutchart, {
                type: "doughnut",
                data: {
                    labels: categoria,
                    datasets: [{
                        data: cantidad,
                        backgroundColor: doughnutChartColors,
                        hoverBackgroundColor: doughnutChartColors,
                        hoverBorderColor: "#fff"
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            labels: {
                                font: {
                                    family: "Poppins"
                                }
                            }
                        }
                    }
                }
            });
        }
    }
})
