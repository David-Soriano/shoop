// Función para calcular totales por periodo
const calculateTotals = (data) => {
    return Object.entries(data).reduce((totals, [timeframe, categories]) => {
        totals[timeframe] = categories[0].data.map((_, i) =>
            categories.reduce((sum, category) => sum + category.data[i], 0)
        );
        return totals;
    }, {});
};

// Función para actualizar el gráfico de ventas totales
const updateChart = (timeframe, idprov) => {
    const daysMap = {
        "Mon": "Lunes", "Tue": "Martes", "Wed": "Miércoles", "Thu": "Jueves",
        "Fri": "Viernes", "Sat": "Sábado", "Sun": "Domingo"
    };

    const monthsMap = {
        "January": "Enero", "February": "Febrero", "March": "Marzo", "April": "Abril", "May": "Mayo",
        "June": "Junio", "July": "Julio", "August": "Agosto", "September": "Septiembre",
        "October": "Octubre", "November": "Noviembre", "December": "Diciembre"
    };

    fetch(`../controller/get_sales_data_prov.php?timeframe=${timeframe}&idprov=${idprov}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error("Error:", data.error);
                return;
            }

            if (!Array.isArray(data) || data.length === 0) {
                console.warn("No hay datos disponibles.");
                document.getElementById('summary').innerHTML = "<p>No hay datos disponibles.</p>";
                return;
            }

            const categories = data.map(item => {
                let periodo = item.periodo;
                return daysMap[periodo] || monthsMap[periodo] || periodo; // Traduce días o meses, o deja igual si no está en el mapa.
            });

            const salesData = data.map(item => parseFloat(item.ventas) || 0);

            Highcharts.chart('container', {
                title: { text: 'Ventas Totales' },
                subtitle: { text: `Intervalo: ${timeframe}` },
                yAxis: { title: { text: 'Ventas' } },
                xAxis: { categories },
                series: [{ name: 'Total', data: salesData }]
            });

            document.getElementById('summary').innerHTML = generateSummary(timeframe, salesData, categories);
        })
        .catch(error => console.error("Error al obtener datos:", error));
};



// Función para generar el resumen de ventas
const generateSummary = (timeframe, sales, categories) => {
    if (!sales || sales.length === 0) return "<p>No hay datos disponibles.</p>";

    const totalSales = sales.reduce((sum, value) => sum + value, 0);
    const maxSales = Math.max(...sales);
    const minSales = Math.min(...sales);

    const maxIndex = sales.indexOf(maxSales);
    const minIndex = sales.indexOf(minSales);

    const maxCategory = categories[maxIndex] || "N/A";
    const minCategory = categories[minIndex] || "N/A";

    let growth = 0;

if (sales.length > 1) {
    const minSale = Math.min(...sales);
    const maxSale = Math.max(...sales);

    console.log("Menor venta registrada:", minSale);
    console.log("Mayor venta registrada:", maxSale);

    if (minSale !== 0) {  
        growth = ((maxSale - minSale) / minSale * 100).toFixed(2);
    }
}
    return `
        <h5>Resumen de Ventas (${timeframe}):</h5>
        <div class="bx-des-gf">
            <ul>
                <li>Total de ventas: <b>${totalSales.toLocaleString()}</b></li>
                <li>Mayor venta: <b>${maxSales.toLocaleString()}</b> en <b>${maxCategory}</b></li>
                <li>Menor venta: <b>${minSales.toLocaleString()}</b> en <b>${minCategory}</b></li>
                <li>Crecimiento: <b>${growth}%</b></li>
            </ul>
            <div class="bx-crec-tv">
                <img src="../IMG/grafico-de-linea.png" alt="">
                <h4>${growth}%</h4>
                <p>Crecimiento</p>
            </div>
        </div>
    `;
};



// Función para actualizar el gráfico de ventas por categoría
const updateChartCt = (timeframe, idprov) => {
    const daysMap = {
        "Mon": "Lun", "Tue": "Mar", "Wed": "Mié", "Thu": "Jue", 
        "Fri": "Vie", "Sat": "Sáb", "Sun": "Dom"
    };

    const monthsMap = {
        "January": "Enero", "February": "Febrero", "March": "Marzo", "April": "Abril", "May": "Mayo",
        "June": "Junio", "July": "Julio", "August": "Agosto", "September": "Septiembre",
        "October": "Octubre", "November": "Noviembre", "December": "Diciembre"
    };

    fetch(`../controller/get_sales_data_prov.php?timeframe=${timeframe}&groupByCategory=true&idprov=${idprov}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error("Error:", data.error);
                return;
            }

            // Transformar datos para Highcharts
            const categoriasSet = new Set();
            const periodosSet = new Set();

            // Separar datos en estructura adecuada
            const seriesMap = {};
            const seriesCantidadMap = {};

            data.forEach(row => {
                categoriasSet.add(row.categoria);
                periodosSet.add(row.periodo);

                if (!seriesMap[row.categoria]) {
                    seriesMap[row.categoria] = [];
                    seriesCantidadMap[row.categoria] = [];
                }
            });

            // Ordenar periodos cronológicamente y traducir
            const periodos = Array.from(periodosSet)
                .map(periodo => daysMap[periodo] || monthsMap[periodo] || periodo) // Traduce días y meses si aplica
                .sort();

            // Inicializar arrays de datos en 0 para cada categoría en cada período
            categoriasSet.forEach(categoria => {
                periodos.forEach(() => {
                    seriesMap[categoria].push(0);
                    seriesCantidadMap[categoria].push(0);
                });
            });

            // Llenar los valores correspondientes en cada serie
            data.forEach(row => {
                const periodoTraducido = daysMap[row.periodo] || monthsMap[row.periodo] || row.periodo;
                const periodoIndex = periodos.indexOf(periodoTraducido);

                if (periodoIndex !== -1) {
                    seriesMap[row.categoria][periodoIndex] = parseFloat(row.ventas);
                    seriesCantidadMap[row.categoria][periodoIndex] = parseInt(row.cantidad_ventas, 10);
                }
            });

            // Convertir estructura para Highcharts
            const series = Object.keys(seriesMap).map(categoria => ({
                name: categoria,
                data: seriesMap[categoria]
            }));

            const seriesCantidad = Object.keys(seriesCantidadMap).map(categoria => ({
                name: categoria,
                data: seriesCantidadMap[categoria]
            }));

            // Dibujar el gráfico en Highcharts
            Highcharts.chart('container2', {
                chart: { type: 'spline' },
                title: { text: `Ventas Por Categoría (${timeframe})` },
                xAxis: {
                    categories: periodos,
                    title: { text: 'Periodo' }
                },
                yAxis: {
                    title: { text: 'Valor de Ventas ($)' }
                },
                tooltip: { shared: true, crosshairs: true },
                series: series
            });

            // Calcular resumen de ventas
            let totalVentas = 0;
            let totalCantidadVentas = 0;
            let categoriaMasVendida = { name: '', cantidad: 0 };

            seriesCantidad.forEach(serie => {
                let sumaCantidad = serie.data.reduce((acc, val) => acc + val, 0);
                totalCantidadVentas += sumaCantidad;

                if (sumaCantidad > categoriaMasVendida.cantidad) {
                    categoriaMasVendida = { name: serie.name, cantidad: sumaCantidad };
                }
            });

            series.forEach(serie => {
                let sumaVentas = serie.data.reduce((acc, val) => acc + val, 0);
                totalVentas += sumaVentas;
            });

            // Actualizar resumen en HTML
            document.getElementById('summary2').innerHTML = `
                <h5>Resumen de Ventas (${timeframe}):</h5>
                <ul>
                    <li>Categoría con más ventas: <b>${categoriaMasVendida.name || 'N/A'}</b> con ${categoriaMasVendida.cantidad.toLocaleString()} ventas realizadas.</li>
                    <li>Total de ventas registradas:  <b>${totalCantidadVentas.toLocaleString()}</b></li>
                    <li>Valor total vendido: <b>$${totalVentas.toLocaleString()}</b></li>
                    <li>Periodo analizado: <b>${timeframe}</b></li>
                </ul>
            `;
        })
        .catch(error => console.error("Error al obtener datos:", error));
};


// Esperar a que el DOM esté cargado antes de ejecutar las funciones
window.addEventListener('DOMContentLoaded', () => {
    if (typeof idprov !== "undefined" && idprov) {
        updateChart('Diario', idprov);
        updateChartCt('Diario', idprov);
    } else {
        console.error("No se encontró idprov en la sesión.");
    }

    document.getElementById('timeframe').addEventListener('change', function () {
        updateChart(this.value, idprov);
    });

    document.getElementById('timeframeSelect').addEventListener('change', function () {
        updateChartCt(this.value, idprov);
    });
});



// // Función para obtener datos de ventas desde PHP
// async function fetchSalesData() {
//     const response = await fetch('../controller/get_sales_data_prov.php?mode=heatmap');
//     const salesData = await response.json();

//     const processedData = salesData.map(item => {
//         const date = new Date(item.date);
//         const normalizedDate = Date.UTC(
//             date.getUTCFullYear(),
//             date.getUTCMonth(),
//             date.getUTCDate()
//         );

//         return {
//             date: normalizedDate,
//             sales: item.value || 0
//         };
//     });
//     return processedData;
// }

// async function generateChartData() {
//     const salesData = await fetchSalesData();
//     const chartData = [];
//     const weekdays = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];

//     if (salesData.length === 0) return [];

//     let minDate = new Date(salesData[0].date);
//     minDate = new Date(Date.UTC(
//         minDate.getUTCFullYear(),
//         minDate.getUTCMonth(),
//         minDate.getUTCDate()
//     ));

//     let currentDate = new Date(minDate);
//     let salesMap = new Map(salesData.map(d => [d.date, d.sales]));

//     while (currentDate.getTime() <= salesData[salesData.length - 1].date) {
//         let dateKey = currentDate.getTime();
//         let sales = salesMap.get(dateKey) || 0;

//         chartData.push({
//             x: currentDate.getUTCDay(),
//             y: Math.floor((currentDate - minDate) / (7 * 24 * 60 * 60 * 1000)),
//             value: sales,
//             date: dateKey,
//             custom: { day: weekdays[currentDate.getUTCDay()] }
//         });

//         currentDate.setUTCDate(currentDate.getUTCDate() + 1);
//     }

//     return chartData;
// }

// // Crear el gráfico después de obtener los datos
// generateChartData().then(chartData => {
//     Highcharts.chart('container3', {
//         chart: { type: 'heatmap' },
//         title: { text: 'Rendimiento de Ventas', align: 'left' },
//         subtitle: { text: 'Según el día de la semana', align: 'left' },
//         xAxis: { categories: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'] },
//         yAxis: { title: { text: 'Semanas' }, reversed: true },
//         series: [{ name: 'Ventas', borderWidth: 1, data: chartData }]
//     });
// });
