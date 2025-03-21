// Calcular totales de ventas por intervalo de tiempo
const calculateTotals = (data) => {
    return Object.entries(data).reduce((totals, [timeframe, categories]) => {
        totals[timeframe] = categories[0].data.map((_, i) =>
            categories.reduce((sum, category) => sum + category.data[i], 0)
        );
        return totals;
    }, {});
};

const updateChart = (timeframe, idprov) => {
    fetch(`../controller/get_sales_data_prov.php?timeframe=${timeframe}&idprov=${idprov}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error("Error:", data.error);
                return;
            }

            const categories = data.map(item => item.periodo);
            const salesData = data.map(item => parseFloat(item.ventas));

            Highcharts.chart('container', {
                title: { text: 'Ventas Totales' },
                subtitle: { text: `Intervalo: ${timeframe}` },
                yAxis: { title: { text: 'Ventas' } },
                xAxis: { categories },
                series: [{ name: 'Total', data: salesData }]
            });

            document.getElementById('summary').innerHTML = generateSummary(timeframe, salesData);
        })
        .catch(error => console.error("Error al obtener datos:", error));
};

// Obtener `idprov` de la URL o de otro lugar donde lo tengas almacenado
if (idprov) {
    console.log("ID del proveedor:", idprov);
    updateChart('Anual', idprov);
    updateChartCt('Anual', idprov);
} else {
    console.error("No se encontró idprov en la sesión.");
}


// Inicializar gráfico con datos anuales para el proveedor
window.addEventListener('DOMContentLoaded', () => {
    updateChart('Anual', idprov);

    document.getElementById('timeframe').addEventListener('change', function () {
        updateChart(this.value, idprov);
    });
});

// Función para generar el resumen de ventas
function generateSummary(timeframe, sales) {
    if (sales.length === 0) return "<p>No hay datos disponibles.</p>";

    const totalSales = sales.reduce((sum, value) => sum + value, 0);
    const maxSales = Math.max(...sales);
    const minSales = Math.min(...sales);
    const growth = ((sales[sales.length - 1] - sales[0]) / sales[0] * 100).toFixed(2);
    const maxIndex = sales.indexOf(maxSales);
    const minIndex = sales.indexOf(minSales);

    return `
        <h5>Resumen de Ventas (${timeframe}):</h5>
        <div class="bx-des-gf">
        <ul>
            <li>Total de ventas: <b>${totalSales.toLocaleString()}</b></li>
            <li>Mayor venta: <b>${maxSales.toLocaleString()}</b> en ${maxIndex + 1}</li>
            <li>Menor venta: <b>${minSales.toLocaleString()}</b> en ${minIndex + 1}</li>
            <li>Crecimiento: <b>${growth}%</b></li>
        </ul>
        <div class="bx-crec-tv">
            <img src="../IMG/grafico-de-linea.png" alt="">
            <h4>${growth}%</h4>
            <p>Crecimiento</p>
        </div>
        </div>
    `;
}

// Inicializar gráfico con datos anuales
window.addEventListener('DOMContentLoaded', () => {
    updateChart('Anual');

    document.getElementById('timeframe').addEventListener('change', function () {
        updateChart(this.value);
    });
});

// Función para actualizar el gráfico de ventas por categoría
const updateChartCt = (timeframe, idprov) => {
    fetch(`../controller/get_sales_data_prov.php?timeframe=${timeframe}&groupByCategory=true&idprov=${idprov}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error("Error:", data.error);
                return;
            }

            Highcharts.chart('container2', {
                chart: { type: 'spline' },
                title: { text: `Ventas Por Categoría (${timeframe})` },
                xAxis: {
                    categories: data.categories,
                    title: { text: 'Periodo' }
                },
                yAxis: {
                    title: { text: 'Valor de Ventas ($)' }
                },
                tooltip: { shared: true, crosshairs: true },
                series: data.series
            });

            let totalVentas = 0;
            let totalCantidadVentas = 0;
            let categoriaMasVendida = { name: '', cantidad: 0 };

            if (data.seriesCantidad) {
                data.seriesCantidad.forEach(serie => {
                    let sumaCantidad = serie.data.reduce((acc, val) => acc + val, 0);
                    totalCantidadVentas += sumaCantidad;

                    if (sumaCantidad > categoriaMasVendida.cantidad) {
                        categoriaMasVendida = { name: serie.name, cantidad: sumaCantidad };
                    }
                });
            }

            if (data.series) {
                data.series.forEach(serie => {
                    let sumaVentas = serie.data.reduce((acc, val) => acc + val, 0);
                    totalVentas += sumaVentas;
                });
            }

            document.getElementById('summary2').innerHTML = `
                <h5>Resumen de Ventas (${timeframe}):</h5>
                <ul>
                    <li>Categoría con más ventas: <b>${categoriaMasVendida.name || 'N/A'}</b> con  ${categoriaMasVendida.cantidad.toLocaleString()} ventas realizadas.</li>
                    <li>Total de ventas registradas:  <b>${totalCantidadVentas.toLocaleString()}</b></li>
                    <li>Valor total vendido: <b>$${totalVentas.toLocaleString()}</b></li>
                    <li>Periodo analizado: <b>${timeframe}</b></li>
                </ul>
            `;
        })
        .catch(error => console.error("Error al obtener datos:", error));
};

// Inicializar gráfico con datos anuales para el proveedor
updateChartCt('Anual', idprov);

document.getElementById('timeframeSelect').addEventListener('change', function () {
    updateChartCt(this.value, idprov);
});


// Función para obtener datos de ventas desde PHP
async function fetchSalesData() {
    const response = await fetch('../controller/get_sales_data_prov.php?mode=heatmap');
    const salesData = await response.json();

    const processedData = salesData.map(item => {
        const date = new Date(item.date);
        const normalizedDate = Date.UTC(
            date.getUTCFullYear(),
            date.getUTCMonth(),
            date.getUTCDate()
        );

        return {
            date: normalizedDate,
            sales: item.value || 0
        };
    });
    return processedData;
}

async function generateChartData() {
    const salesData = await fetchSalesData();
    const chartData = [];
    const weekdays = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];

    if (salesData.length === 0) return [];

    let minDate = new Date(salesData[0].date);
    minDate = new Date(Date.UTC(
        minDate.getUTCFullYear(),
        minDate.getUTCMonth(),
        minDate.getUTCDate()
    ));

    let currentDate = new Date(minDate);
    let salesMap = new Map(salesData.map(d => [d.date, d.sales]));

    while (currentDate.getTime() <= salesData[salesData.length - 1].date) {
        let dateKey = currentDate.getTime();
        let sales = salesMap.get(dateKey) || 0;

        chartData.push({
            x: currentDate.getUTCDay(),
            y: Math.floor((currentDate - minDate) / (7 * 24 * 60 * 60 * 1000)),
            value: sales,
            date: dateKey,
            custom: { day: weekdays[currentDate.getUTCDay()] }
        });

        currentDate.setUTCDate(currentDate.getUTCDate() + 1);
    }

    return chartData;
}

// Crear el gráfico después de obtener los datos
generateChartData().then(chartData => {
    Highcharts.chart('container3', {
        chart: { type: 'heatmap' },
        title: { text: 'Rendimiento de Ventas', align: 'left' },
        subtitle: { text: 'Según el día de la semana', align: 'left' },
        xAxis: { categories: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'] },
        yAxis: { title: { text: 'Semanas' }, reversed: true },
        series: [{ name: 'Ventas', borderWidth: 1, data: chartData }]
    });
});
