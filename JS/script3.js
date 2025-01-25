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
    Highcharts.chart('container', {
        title: {
            text: 'Ventas Totales'
        },
        subtitle: {
            text: `Intervalo: ${timeframe}`
        },
        yAxis: {
            title: {
                text: 'Ventas'
            }
        },
        xAxis: {
            categories: timeframe === 'Anual'
                ? ['2016', '2017', '2018', '2019', '2020', '2021']
                : timeframe === 'Mensual'
                    ? ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio']
                    : timeframe === 'Semanal'
                        ? ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4', 'Semana 5', 'Semana 6']
                        : ['Lun', 'Mar', 'Miérc', 'Juev', 'Vier', 'Sáb', 'Dom']
        },
        series: [
            {
                name: 'Total',
                data: totalData[timeframe]
            }
        ]
    });
};

// Función para generar texto automático
function generateSummary(timeframe) {
    const sales = totalData[timeframe]; // Usar los datos totales
    const totalSales = sales.reduce((sum, value) => sum + value, 0);
    const maxSales = Math.max(...sales);
    const minSales = Math.min(...sales);
    const growth = ((sales[sales.length - 1] - sales[0]) / sales[0] * 100).toFixed(2);
    const maxIndex = sales.indexOf(maxSales);
    const minIndex = sales.indexOf(minSales);

    return `
        <strong>Resumen de Ventas (${timeframe}):</strong><br>
        - Total de ventas: ${totalSales.toLocaleString()} unidades.<br>
        - Mayor venta: ${maxSales.toLocaleString()} unidades en el período ${maxIndex + 1}.<br>
        - Menor venta: ${minSales.toLocaleString()} unidades en el período ${minIndex + 1}.<br>
        - Crecimiento: ${growth}% desde el inicio hasta el final del período.
    `;
}

// Inicializar gráfico con datos anuales
updateChart('Anual');

// Cambiar intervalo al seleccionar una opción
// Generar texto inicial para el resumen (predeterminado: Anual)
document.getElementById('summary').innerHTML = generateSummary('Anual');

// Cambiar intervalo al seleccionar una opción
document.getElementById('timeframe').addEventListener('change', function () {
    const selectedTimeframe = this.value;
    updateChart(selectedTimeframe);
    document.getElementById('summary').innerHTML = generateSummary(selectedTimeframe);
});




// Data retrieved https://en.wikipedia.org/wiki/List_of_cities_by_average_temperature
Highcharts.chart('container2', {
    chart: {
        type: 'spline'
    },
    title: {
        text: 'Ventas Por Categoría'
    },
    subtitle: {
        text: 'Source: ' +
            '<a href="https://en.wikipedia.org/wiki/List_of_cities_by_average_temperature" ' +
            'target="_blank">Wikipedia.com</a>'
    },
    xAxis: {
        categories: [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ],
        accessibility: {
            description: 'Months of the year'
        }
    },
    yAxis: {
        title: {
            text: 'Ventas'
        },
        labels: {
            format: '{value}°'
        }
    },
    tooltip: {
        crosshairs: true,
        shared: true
    },
    plotOptions: {
        spline: {
            marker: {
                radius: 4,
                lineColor: '#666666',
                lineWidth: 1
            }
        }
    },
    series: [{
        name: 'Tokyo',
        marker: {
            symbol: 'square'
        },
        data: [5.2, 5.7, 8.7, 13.9, 18.2, 21.4, 25.0, {
            y: 26.4,
            accessibility: {
                description: 'Sunny symbol, this is the warmest point in the ' +
                    'chart.'
            }
        }, 22.8, 17.5, 12.1, 7.6]

    }, {
        name: 'Bergen',
        marker: {
            symbol: 'diamond'
        },
        data: [{
            y: 1.5,
            accessibility: {
                description: 'Snowy symbol, this is the coldest point in the ' +
                    'chart.'
            }
        }, 1.6, 3.3, 5.9, 10.5, 13.5, 14.5, 14.4, 11.5, 8.7, 4.7, 2.6]
    }]
});

//Head Map
const data = [{
    date: '2023-07-01',
    temperature: 19.1
},
{
    date: '2023-07-02',
    temperature: 15.3
},
{
    date: '2023-07-03',
    temperature: 16.4
},
{
    date: '2023-07-04',
    temperature: 16.0
},
{
    date: '2023-07-05',
    temperature: 17.9
},
{
    date: '2023-07-06',
    temperature: 15.8
},
{
    date: '2023-07-07',
    temperature: 21.1
},
{
    date: '2023-07-08',
    temperature: 23.3
},
{
    date: '2023-07-09',
    temperature: 24.8
},
{
    date: '2023-07-10',
    temperature: 25.1
},
{
    date: '2023-07-11',
    temperature: 18.2
},
{
    date: '2023-07-12',
    temperature: 14.4
},
{
    date: '2023-07-13',
    temperature: 19.3
},
{
    date: '2023-07-14',
    temperature: 20.2
},
{
    date: '2023-07-15',
    temperature: 15.8
},
{
    date: '2023-07-16',
    temperature: 16.1
},
{
    date: '2023-07-17',
    temperature: 15.7
},
{
    date: '2023-07-18',
    temperature: 19.2
},
{
    date: '2023-07-19',
    temperature: 18.6
},
{
    date: '2023-07-20',
    temperature: 18.3
},
{
    date: '2023-07-21',
    temperature: 15.0
},
{
    date: '2023-07-22',
    temperature: 14.7
},
{
    date: '2023-07-23',
    temperature: 18.8
},
{
    date: '2023-07-24',
    temperature: 17.7
},
{
    date: '2023-07-25',
    temperature: 17.4
},
{
    date: '2023-07-26',
    temperature: 17.6
},
{
    date: '2023-07-27',
    temperature: 18.1
},
{
    date: '2023-07-28',
    temperature: 18.2
},
{
    date: '2023-07-29',
    temperature: 20.3
},
{
    date: '2023-07-30',
    temperature: 16.4
},
{
    date: '2023-07-31',
    temperature: 17.0
}];

const weekdays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

// The function takes in a dataset and calculates how many empty tiles needed
// before and after the dataset is plotted.
function generateChartData(data) {

    // Calculate the starting weekday index (0-6 of the first date in the given
    // array)
    const firstWeekday = new Date(data[0].date).getDay(),
        monthLength = data.length,
        lastElement = data[monthLength - 1].date,
        lastWeekday = new Date(lastElement).getDay(),
        lengthOfWeek = 6,
        emptyTilesFirst = firstWeekday,
        chartData = [];

    // Add the empty tiles before the first day of the month with null values to
    // take up space in the chart
    for (let emptyDay = 0; emptyDay < emptyTilesFirst; emptyDay++) {
        chartData.push({
            x: emptyDay,
            y: 5,
            value: null,
            date: null,
            custom: {
                empty: true
            }
        });
    }

    // Loop through and populate with temperature and dates from the dataset
    for (let day = 1; day <= monthLength; day++) {
        // Get date from the given data array
        const date = data[day - 1].date;
        // Offset by thenumber of empty tiles
        const xCoordinate = (emptyTilesFirst + day - 1) % 7;
        const yCoordinate = Math.floor((firstWeekday + day - 1) / 7);
        const id = day;

        // Get the corresponding temperature for the current day from the given
        // array
        const temperature = data[day - 1].temperature;

        chartData.push({
            x: xCoordinate,
            y: 5 - yCoordinate,
            value: temperature,
            date: new Date(date).getTime(),
            custom: {
                monthDay: id
            }
        });
    }

    // Fill in the missing values when dataset is looped through.
    const emptyTilesLast = lengthOfWeek - lastWeekday;
    for (let emptyDay = 1; emptyDay <= emptyTilesLast; emptyDay++) {
        chartData.push({
            x: (lastWeekday + emptyDay) % 7,
            y: 0,
            value: null,
            date: null,
            custom: {
                empty: true
            }
        });
    }
    return chartData;
}
const chartData = generateChartData(data);

Highcharts.chart('container3', {
    chart: {
        type: 'heatmap'
    },

    title: {
        text: 'Rendimiento de Ventas',
        align: 'left'
    },

    subtitle: {
        text: 'Según el día de la semana',
        align: 'left'
    },

    accessibility: {
        landmarkVerbosity: 'one'
    },

    tooltip: {
        enabled: true,
        outside: true,
        zIndex: 20,
        headerFormat: '',
        pointFormat: '{#unless point.custom.empty}{point.date:%A, %b %e, ' +
            '%Y}{/unless}',
        nullFormat: 'No data'
    },

    xAxis: {
        categories: weekdays,
        opposite: true,
        lineWidth: 26,
        offset: 13,
        lineColor: 'rgba(27, 26, 37, 0.2)',
        labels: {
            rotation: 0,
            y: 20,
            style: {
                textTransform: 'uppercase',
                fontWeight: 'bold'
            }
        },
        accessibility: {
            description: 'weekdays',
            rangeDescription: 'X Axis is showing all 7 days of the week, ' +
                'starting with Sunday.'
        }
    },

    yAxis: {
        min: 0,
        max: 5,
        accessibility: {
            description: 'weeks'
        },
        visible: false
    },

    legend: {
        align: 'right',
        layout: 'vertical',
        verticalAlign: 'middle'
    },

    colorAxis: {
        min: 0,
        stops: [
            [0.2, 'lightblue'],
            [0.4, '#CBDFC8'],
            [0.6, '#F3E99E'],
            [0.9, '#F9A05C']
        ],
        labels: {
            format: '{value} °C'
        }
    },

    series: [{
        keys: ['x', 'y', 'value', 'date', 'id'],
        data: chartData,
        nullColor: 'rgba(196, 196, 196, 0.2)',
        borderWidth: 2,
        borderColor: 'rgba(196, 196, 196, 0.2)',
        dataLabels: [{
            enabled: true,
            format: '{#unless point.custom.empty}{point.value:.1f}°{/unless}',
            style: {
                textOutline: 'none',
                fontWeight: 'normal',
                fontSize: '1rem'
            },
            y: 4
        }, {
            enabled: true,
            align: 'left',
            verticalAlign: 'top',
            format: '{#unless ' +
                'point.custom.empty}{point.custom.monthDay}{/unless}',
            backgroundColor: 'whitesmoke',
            padding: 2,
            style: {
                textOutline: 'none',
                color: 'rgba(70, 70, 92, 1)',
                fontSize: '0.8rem',
                fontWeight: 'bold',
                opacity: 0.5
            },
            x: 1,
            y: 1
        }]
    }]
});
