// Datos para diferentes intervalos de tiempo
const salesData = {
    Anual: [
        { name: 'Categoría 1', data: [43934, 48656, 65165, 81827, 112143, 142383] },
        { name: 'Categoría 2', data: [24916, 37941, 29742, 29851, 32490, 30282] }
    ],
    Mensual: [
        { name: 'Categoría 1', data: [1000, 1200, 1100, 1500, 1800, 1700] },
        { name: 'Categoría 2', data: [800, 700, 900, 850, 950, 870] }
    ],
    Semanal: [
        { name: 'Categoría 1', data: [200, 220, 250, 270, 300, 310] },
        { name: 'Categoría 2', data: [150, 140, 160, 170, 180, 190] }
    ],
    Diario: [
        { name: 'Categoría 1', data: [200, 220, 250, 270, 300, 310, 4] },
        { name: 'Categoría 2', data: [150, 140, 160, 170, 180, 190, 89] }
    ]
};

// Calcular totales de ventas por intervalo de tiempo
const calculateTotals = (data) => {
    return Object.entries(data).reduce((totals, [timeframe, categories]) => {
        totals[timeframe] = categories[0].data.map((_, i) =>
            categories.reduce((sum, category) => sum + category.data[i], 0)
        );
        return totals;
    }, {});
};

const totalData = calculateTotals(salesData);

// Función para actualizar el gráfico
const updateChart = (timeframe) => {
    fetch(`../controller/get_sales_data.php?timeframe=${timeframe}`)
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




// Data retrieved https://en.wikipedia.org/wiki/List_of_cities_by_average_temperature
const updateChartCt = (timeframe) => {
    fetch(`../controller/get_sales_data.php?timeframe=${timeframe}&groupByCategory=true`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error("Error:", data.error);
                return;
            }

            // Generar gráfico con Highcharts (solo mostrando el total en dinero)
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

            // Procesar datos para obtener información relevante
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

            // Actualizar la descripción con cantidad de ventas y total en dinero
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



// Cargar ventas anuales por defecto
updateChartCt('Anual');

// Cambiar gráfico según selección
document.getElementById('timeframeSelect').addEventListener('change', function () {
    updateChartCt(this.value);
});

//HEATMAP
// Función para obtener datos de ventas desde PHP
async function fetchSalesData() {
    const response = await fetch('../controller/get_sales_data.php?mode=heatmap');
    const salesData = await response.json();

    console.log("Datos recibidos:", salesData);

    // Si la respuesta contiene más de un array, tomamos el primero (el heatmap)
    if (Array.isArray(salesData) && Array.isArray(salesData[0])) {
        return salesData[0].map(item => ({
            date: item.date,
            sales: item.value // Ajustar la clave según los datos devueltos
        }));
    }

    return salesData.map(item => ({
        date: item.date,
        sales: item.value
    }));
}


// Función para generar los datos para el heatmap
async function generateChartData() {
    const salesData = await fetchSalesData();

    // Convertimos los datos al formato del heatmap
    const firstWeekday = new Date(salesData[0].date).getDay();
    const emptyTilesFirst = firstWeekday;
    const chartData = [];

    for (let emptyDay = 0; emptyDay < emptyTilesFirst; emptyDay++) {
        chartData.push({
            x: emptyDay,
            y: 5,
            value: null,
            date: null,
            custom: { empty: true }
        });
    }

    for (let i = 0; i < salesData.length; i++) {
        const date = salesData[i].date;
        const sales = salesData[i].sales;
        const xCoordinate = (emptyTilesFirst + i) % 7;
        const yCoordinate = Math.floor((firstWeekday + i) / 7);

        chartData.push({
            x: xCoordinate,
            y: 5 - yCoordinate,
            value: sales,
            date: new Date(date).getTime(),
            custom: { monthDay: i + 1 }
        });
    }

    return chartData;
}


// Crear el gráfico después de obtener los datos
generateChartData().then(chartData => {
    Highcharts.chart('container3', {
        chart: { type: 'heatmap' },
        title: { text: 'Rendimiento de Ventas', align: 'left' },
        subtitle: { text: 'Según el día de la semana', align: 'left' },
        accessibility: {
            enabled: false,
            description: null
        },
        xAxis: {
            categories: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
            title: { text: 'Día de la Semana' }
        },
        yAxis: { visible: false },
        colorAxis: {
            min: 0,
            stops: [
                [0.2, 'lightblue'],
                [0.5, '#CBDFC8'],
                [0.8, '#F3E99E'],
                [1, '#F9A05C']
            ],
            labels: { format: '{value} ventas' }
        },
        tooltip: {
            headerFormat: '',
            pointFormat: '<b>{point.custom.day}</b>: {point.value} ventas'
        },
        series: [{
            name: 'Ventas',
            borderWidth: 1,
            data: chartData,
            dataLabels: {
                enabled: true,
                format: '{point.value} ventas',
                style: { textOutline: 'none', fontSize: '12px' }
            }
        }]
    });
    
});

