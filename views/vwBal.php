<div class="wrapper row">
    <div class="counter col_fourth">
        <i class="bi bi-cart-check-fill bi-bal"></i>
        <h2 class="timer count-title count-number" data-to="10425" data-speed="1500"></h2>
        <p class="count-text ">Productos Vendidos</p>
    </div>

    <div class="counter col_fourth">
        <i class="bi bi-currency-dollar bi-bal"></i>
        <h2 class="timer count-title count-number" data-to="25370000" data-speed="1500"></h2>
        <p class="count-text ">Ingresos Totales</p>
    </div>

    <div class="counter col_fourth">
        <i class="bi bi-person-fill-add bi-bal"></i>
        <h2 class="timer count-title count-number" data-to="3212" data-speed="1500"></h2>
        <p class="count-text ">Clientes Registrados</p>
    </div>

    <div class="counter col_fourth end">
        <i class="bi bi-rocket-takeoff-fill bi-bal"></i>
        <h2 class="timer count-title count-number" data-to="125" data-speed="1500"></h2>
        <p class="count-text ">Pedidos Enviados</p>
    </div>
</div>



<section class="sect-grf">
    <div class="row bx-graf-bl">
        <div class="col">
            <script src="https://code.highcharts.com/highcharts.js"></script>
            <script src="https://code.highcharts.com/modules/series-label.js"></script>
            <script src="https://code.highcharts.com/modules/exporting.js"></script>
            <script src="https://code.highcharts.com/modules/export-data.js"></script>
            <script src="https://code.highcharts.com/modules/accessibility.js"></script>

            <figure class="highcharts-figure">
                <div id="container"></div>
                <div>
                    <label for="timeframe">Intervalo de tiempo:</label>
                    <select id="timeframe" class="form-select">
                        <option value="Anual">Anual</option>
                        <option value="Mensual">Mensual</option>
                        <option value="Semanal">Semanal</option>
                        <option value="Diario">Diario</option>
                    </select>
                </div>

            </figure>

        </div>
        <div class="col bx-des-hc">
            <div class="highcharts-description" id="summary">
            </div>
        </div>
    </div>
    <div class="row bx-graf-bl">
        <div class="col bx-des-hc">
            <p class="highcharts-description">
                This chart shows how symbols and shapes can be used in charts.
                Highcharts includes several common symbol shapes, such as squares,
                circles and triangles, but it is also possible to add your own
                custom symbols. In this chart, custom weather symbols are used on
                data points to highlight that certain temperatures are warm while
                others are cold.
            </p>
        </div>
        <div class="col">
            <script src="https://code.highcharts.com/highcharts.js"></script>
            <script src="https://code.highcharts.com/modules/series-label.js"></script>
            <script src="https://code.highcharts.com/modules/exporting.js"></script>
            <script src="https://code.highcharts.com/modules/export-data.js"></script>
            <script src="https://code.highcharts.com/modules/accessibility.js"></script>

            <figure class="highcharts-figure">
                <div id="container2"></div>

            </figure>
        </div>
    </div>
    <div class="row bx-graf-bl">
        <div class="col">
            <script src="https://code.highcharts.com/highcharts.js"></script>
            <script src="https://code.highcharts.com/modules/heatmap.js"></script>
            <script src="https://code.highcharts.com/modules/exporting.js"></script>
            <script src="https://code.highcharts.com/modules/accessibility.js"></script>

            <figure class="highcharts-figure">
                <div id="container3"></div>
                <p class="highcharts-description">
                    Heatmap with over 31 data points, visualizing the temperature at 12AM
                    every day in July 2023. The blue colors indicate colder days, and the
                    orange colors indicate warmer days.
                </p>
            </figure>
        </div>
    </div>
</section>