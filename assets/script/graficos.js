/*Author: Ing. Daniel David Chavarro R. Tlf: +58 0416-3422924, email: elsaiya@gmail.com*/

/*tipos de graficos
    bar
    horizontalBar
    line
    radar
    polarArea
    pie
    doughnut
    bubble
 Con pointRadius podr�s establecer el radio del punto.

fill: false, �> no aparecer� relleno por debajo de la l�nea.

showLine: false, �> no aparecer� la l�nea.

Es decir, si ponemos fill y showLine a false, tendremos un gr�fico de puntos, en lugar de un gr�fico
de l�neas. pointStyle: �circle�, �triangle�, �rect�, �rectRounded�, �rectRot�, �cross�, �crossRot�, �star�,
�line�, and �dash� Podr�a ser incluso una imagen.

spanGaps est� por defecto a false. Si lo ponemos a true, cuando te falte un valor en la l�nea, no se 
romper� la l�nea.*/

/* GRAFICO PARA VENTAS POR SUCURSALES ANUAL*/
function showGraphBarS(){
    {
        $.post("data.php?ProcesosxSucursales=si",
        function (data)
        {
            console.log(data);
            var id = [];
            var name = [];
            var compras = [];
            var cotizacion = [];
            var ventas = [];
            var myColors=[];

            for (var i in data) {
                id.push(data[i].codsucursal);
                name.push(data[i].nomsucursal);
                compras.push(data[i].sumcompras);
                cotizacion.push(data[i].sumcotizacion);
                ventas.push(data[i].sumventas);
            }

            var chartdata = {
                labels: name,
                datasets: [
                {
                  label: "Compras",    
                  backgroundColor: ['#ff7676'],
                  borderWidth: 1,
                  data: compras
              },
              {
                  label: "Cotizaciones",
                  backgroundColor: ['#8EE1BC'],
                  borderWidth: 1,
                  data: cotizacion
              },
              {
                  label: "Ventas",
                  backgroundColor: ['#25AECD'],
                  borderWidth: 1,
                  data: ventas
              }
              ]
            };

            var graphTarget = $("#barChart");
            //var steps = 3;

            var barGraph = new Chart(graphTarget, {
                type: 'bar',
                data: chartdata,
                responsive : true,
                animation: true,
                barValueSpacing : 2,
                barDatasetSpacing : 1,
                tooltipFillColor: "rgba(0,0,0,0.8)",
                multiTooltipTemplate: "<%= datasetLabel %> - <%= value %>" 
            });
        });
    }
}



/* GRAFICO PARA VENTAS DIARIAS*/
function showGraphLineVentasDiarias(){
    {
        $.post("data.php?ProcesosxVentasDiarias=si",
        function (data)
        {
            console.log(data);
            var name = [];
            var contado  = [];
            var credito  = [];
            var myColors=[];

            for (var i in data) {
                name.push(data[i].dia_venta);
                contado.push(data[i].total_dia);
                credito.push(data[i].total_dia2);
            }

            var chartdata = {
                labels: name,
                datasets: [
                {
                    label: "Contado",
                    backgroundColor: '#f7b9b9',
                    borderColor: '#ff7676',
                    hoverBackgroundColor: '#ff7676',
                    hoverBorderColor: '#f7b9b9',
                    borderWidth: 1,
                    data: contado
                },
                {
                    label: "Credito",
                    backgroundColor: '#85d4e6',
                    borderColor: '#19829a',
                    hoverBackgroundColor: '#19829a',
                    hoverBorderColor: '#85d4e6',
                    borderWidth: 1,
                    data: credito
                }
              ]
            };

            var graphTarget = $("#lineChart");
            //var steps = 3;

            var lineGraph = new Chart(graphTarget, {
                type: 'line',
                data: chartdata,
                responsive : true,
                animation: true,
                barValueSpacing : 2,
                barDatasetSpacing : 1,
                tooltipFillColor: "rgba(0,0,0,0.8)",
                multiTooltipTemplate: "<%= datasetLabel %> - <%= value %>" 
            });
        });
    }
}

/* GRAFICO DE COMPRAS POR PROVEEDOR*/
function showGraphDoughnutComprasxProveedor(){
    {
        $.post("data.php?ComprasxProveedor=si",
        function (data)
        {
            console.log(data);
            var id = [];
            var name = [];
            var marks = [];
            var myColors=[];

            for (var i in data) {
                id.push(data[i].codproveedor);
                name.push(data[i].nomproveedor);
                marks.push(data[i].total);
            }

            $.each(id, function( index,num ) {
                if (num == 1)
                    myColors[index]= "#F38630";
                if (num == 2)
                    myColors[index]= "#ff7676";
                if (num == 3)
                    myColors[index]= "#fff933";
                if (num == 4)
                    myColors[index]= "#3e95cd";
                if (num == 5)
                    myColors[index]= "#90ff33";
                if (num == 6)
                    myColors[index]= "#987DDB";
                if (num == 7)
                    myColors[index]= "#E8AC9E"; 
                if (num == 8)
                    myColors[index]= "#69D2E7";   
                if (num == 9)
                    myColors[index]= "#f0ad4e";   
                if (num == 10)
                    myColors[index]= "#2b34c4";  
                if (num == 11)
                    myColors[index]= "#D3E37D";  
                if (num == 12)
                    myColors[index]= "#00FFFF";  
                if (num == 13)
                    myColors[index]= "#c4572b";  
                if (num == 14)
                    myColors[index]= "#969788";  
                if (num == 15)
                    myColors[index]= "#169696";
            });

            var chartdata = {
                labels: name,
                datasets: [
                    {
                        label: 'Total en Ventas',
                        data: marks,  
                        backgroundColor: myColors,
                        borderWidth: 1
                    }
                ]
            };

            var graphTarget = $("#DoughnutChartCP");
            //var steps = 3;

            var barGraph = new Chart(graphTarget, {
                type: 'doughnut',
                data: chartdata,
                responsive : true,
                animation: true,
                barValueSpacing : 5,
                barDatasetSpacing : 1,
                tooltipFillColor: "rgba(0,0,0,0.8)",
                multiTooltipTemplate: "<%= datasetLabel %> - <%= value %>" 
            });
        });
    }
}

/* GRAFICO DE VENTAS POR VENDEDOR*/
function showGraphDoughnutVentasxUsuarios(){
    {
        $.post("data.php?VentasxUsuarios=si",
        function (data)
        {
            console.log(data);
            var id = [];
            var name = [];
            var marks = [];
            var myColors=[];

            for (var i in data) {
                id.push(data[i].codigo);
                name.push(data[i].nombres);
                marks.push(data[i].total);
            }

            $.each(id, function( index,num ) {
                if (num == 1)
                    myColors[index]= "#f0ad4e";
                if (num == 2)
                    myColors[index]= "#ff7676";
                if (num == 3)
                    myColors[index]= "#E0E4CC";
                if (num == 4)
                    myColors[index]= "#3e95cd";
                if (num == 5)
                    myColors[index]= "#969788";
                if (num == 6)
                    myColors[index]= "#987DDB";
                if (num == 7)
                    myColors[index]= "#169696"; 
                if (num == 8)
                    myColors[index]= "#69D2E7";   
                if (num == 9)
                    myColors[index]= "#F38630";   
                if (num == 10)
                    myColors[index]= "#F82330";  
                if (num == 11)
                    myColors[index]= "#D3E37D";  
                if (num == 12)
                    myColors[index]= "#00FFFF";  
                if (num == 13)
                    myColors[index]= "#fff933";  
                if (num == 14)
                    myColors[index]= "#90ff33";  
                if (num == 15)
                    myColors[index]= "#E8AC9E";
            });

            var chartdata = {
                labels: name,
                datasets: [
                    {
                        label: 'Total en Ventas',
                        data: marks,  
                        backgroundColor: myColors,
                        borderWidth: 1
                    }
                ]
            };

            var graphTarget = $("#DoughnutChartVU");
            //var steps = 3;

            var barGraph = new Chart(graphTarget, {
                type: 'doughnut',
                data: chartdata,
                responsive : true,
                animation: true,
                barValueSpacing : 5,
                barDatasetSpacing : 1,
                tooltipFillColor: "rgba(0,0,0,0.8)",
                multiTooltipTemplate: "<%= datasetLabel %> - <%= value %>" 
            });
        });
    }
}

function showGraphDoughnutProductosVendidos(){
    {
        $.post("data.php?ProductosVendidos=si",
        function (data)
        {
            console.log(data);
            var id = [];
            var name = [];
            var total = [];

            for (var i in data) {
                id.push(data[i].codproducto);
                name.push(data[i].producto);
                total.push(data[i].cantidad);
            }

            var chartdata = {
                labels: name,
                datasets: [
                {
                    backgroundColor: ["#ff7676", "#3e95cd","#3cba9f","#003399","#f0ad4e","#987DDB","#E8AC9E","#D3E37D"],
                    borderWidth: 1,
                    data: total
                }
                ]
            };

            var graphTarget = $("#DoughnutChartPV");
            //var steps = 3;

            var barGraph = new Chart(graphTarget, {
                type: 'doughnut',
                data: chartdata,
                responsive : true,
                animation: true,
                barValueSpacing : 2,
                barDatasetSpacing : 1,
                tooltipFillColor: "rgba(0,0,0,0.8)",
                multiTooltipTemplate: "<%= datasetLabel %> - <%= value %>" 
            });
        });
    }
}