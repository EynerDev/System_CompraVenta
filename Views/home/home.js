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

        var cantidad = [];
        var categoria = [];

        for (var i in data) {
            cantidad.push(data[i].CANT);
            categoria.push(data[i].CAT_NAME);
        }

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



$.ajax({
    url: "../../Controller/VentaController.php?op=ventabarras",
    method: "POST",
    data: {
        suc_id: suc_id
    },
    success: function(response) {
        var data = JSON.parse(response);
        console.log(data)

        var dias = [];
        var total_ventas = [];

        for (var i in data) {
            dias.push(data[i].FECHA);
            total_ventas.push(data[i].TOTAL);
        }


        var barChart, isbarchart = document.getElementById("grafventa");
        barChartColor = getChartColorsArray("grafventa"), barChartColor && (isbarchart.setAttribute("width", isbarchart.parentElement.offsetWidth), barChart = new Chart(isbarchart, {
            type: "bar",
            data: {
                labels: dias ,
                datasets: [{
                    label: "Ventas Diarias",
                    backgroundColor: barChartColor[0],
                    borderColor: barChartColor[0],
                    borderWidth: 1,
                    hoverBackgroundColor: barChartColor[1],
                    hoverBorderColor: barChartColor[1],
                    data: total_ventas
                }]
            },
            options: {
                x: {
                    ticks: {
                        font: {
                            family: "Poppins"
                        }
                    }
                },
                y: {
                    ticks: {
                        font: {
                            family: "Poppins"
                        }
                    }
                },
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
        }));
    }
})


$.ajax({
    url: "../../Controller/CompraController.php?op=comprabarras",
    method: "POST",
    data: {
        suc_id: suc_id
    },
    success: function(response) {
        var data = JSON.parse(response);
        console.log(data)

        var dias = [];
        var total_compras = [];

        for (var i in data) {
            dias.push(data[i].FECHA);
            total_compras.push(data[i].TOTAL);
        }


        var barChart, isbarchart = document.getElementById("grafcompra");
        barChartColor = getChartColorsArray("grafcompra"), barChartColor && (isbarchart.setAttribute("width", isbarchart.parentElement.offsetWidth), barChart = new Chart(isbarchart, {
            type: "bar",
            data: {
                labels: dias,
                datasets: [{
                    label: "Compras Diarias",
                    backgroundColor: barChartColor[0],
                    borderColor: barChartColor[0],
                    borderWidth: 1,
                    hoverBackgroundColor: barChartColor[1],
                    hoverBorderColor: barChartColor[1],
                    data: total_compras
                }]
            },
            options: {
                x: {
                    ticks: {
                        font: {
                            family: "Poppins"
                        }
                    }
                },
                y: {
                    ticks: {
                        font: {
                            family: "Poppins"
                        }
                    }
                },
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
        }))

    }
})
