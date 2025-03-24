<div class="wrapper row">
    <div class="counter col_fourth">
        <i class="bi bi-cart-check-fill bi-bal"></i>
        <h2 class="timer count-title count-number" data-to="<?= $dtTotalProductVend ?>" data-speed="1500"></h2>
        <p class="count-text ">Productos Vendidos</p>
    </div>

    <div class="counter col_fourth">
        <i class="bi bi-currency-dollar bi-bal"></i>
        <h2 class="timer count-title count-number" data-to="<?= $dtTotalComCul ?>" data-speed="1500"></h2>
        <p class="count-text ">Compras Culminadas</p>
    </div>

    <div class="counter col_fourth">
        <i class="bi bi-person-fill-add bi-bal"></i>
        <h2 class="timer count-title count-number" data-to="<?= $dtTotalClientPt ?>" data-speed="1500"></h2>
        <p class="count-text ">Clientes Potenciales</p>
    </div>

    <div class="counter col_fourth end">
        <i class="bi bi-rocket-takeoff-fill bi-bal"></i>
        <h2 class="timer count-title count-number" data-to="<?= $dtTotalPedsPrv ?>" data-speed="1500"></h2>
        <p class="count-text ">Pedidos Realizados</p>
    </div>
</div>
<!-- Carga de scripts solo una vez -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<section class="sect-grf">
    <div class="row bx-graf-bl">
        <div class="col">
            <figure class="highcharts-figure">
                <div id="container"></div>
                <div>
                    <label for="timeframe">Intervalo de tiempo:</label>
                    <select id="timeframe" class="form-select">
                        <option value="Diario">Diario</option>
                        <option value="Semanal">Semanal</option>
                        <option value="Mensual">Mensual</option>
                        <option value="Anual">Anual</option>
                    </select>
                </div>
            </figure>
        </div>
        <div class="col bx-des-hc">
            <div class="highcharts-description" id="summary"></div>
        </div>
    </div>

    <div class="row bx-graf-bl">
        <div class="col bx-des-hc">
            <p class="highcharts-description" id="summary2">Aquí va la descripción...</p>
        </div>
        <div class="col">
            <figure class="highcharts-figure">
                <div id="container2"></div>
            </figure>
            <label for="timeframeSelect">Intervalo de tiempo:</label>
            <select id="timeframeSelect" class="form-select">
                <option value="Diario">Diario</option>
                <option value="Semanal">Semanal</option>
                <option value="Mensual">Mensual</option>
                <option value="Anual">Anual</option>
            </select>
        </div>
    </div>
</section>
<?php if ($dtMProductVend) { ?>
    <section>
        <div class="row mt-5">
            <div class="col">
                <h2>Productos más vendidos</h2>
                <div class="row bx-items-mprdv">
                    <?php foreach ($dtMProductVend as $dt) { ?>
                        <div class="col col-sm-2 item-mprdv">
                            <img src="../<?= $dt['imgpro'] ?>" alt="../<?= $dt['nompro'] ?>">
                            <div class="bx-items-mprd_bx-ft">
                                <h5><?= $dt['nompro'] ?></h5>
                                <div>
                                    <p class="p-vend">Vendidos: <span><?= $dt['productvend'] ?></span></p>
                                    <p class="p-cat"><?= $dt['nomval'] ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
<section>
    <div class="row mt-5">
        <div class="col">
            <h2>Reportes</h2>
            <div class="row bx-items-mprdv">
                <div id="chart_div" style="width: 100%; height: 500px;"></div>

                <form action="../controller/reporte_ventas.php" method="POST" id="reporteForm">
                    <input type="hidden" name="chart_image" id="chart_image">
                    <input type="hidden" name="idprov" value="<?= $_SESSION['idprov'] ?>">
                    <!-- Cambia por el id del proveedor -->
                    <button type="submit" id="reporteBtn">Reporte de Ventas</button>
                </form>

            </div>
        </div>
    </div>
</section>
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    const idprov = "<?php echo $_SESSION['idprov'] ?? ''; ?>";

    google.charts.load('current', { 'packages': ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Mes', 'Ventas'],
            <?php foreach ($dtVentasMes as $row) {
                echo "['" . $row['mes'] . "', " . $row['total_ventas'] . "],";
            } ?>
        ]);

        var options = { title: 'Ventas por Mes', curveType: 'function', legend: { position: 'bottom' } };
        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);

        // Escuchar clic en el botón y asegurarse de que la imagen esté lista antes de enviar el formulario
        document.getElementById('reporteBtn').addEventListener('click', function (event) {
            event.preventDefault(); // Evita el envío inmediato

            setTimeout(() => {
                var imgUri = chart.getImageURI();
                if (imgUri) {
                    document.getElementById('chart_image').value = imgUri;
                    console.log("Imagen generada: ", imgUri);
                    document.getElementById('reporteForm').submit(); // Envía el formulario cuando la imagen esté lista
                } else {
                    console.error("No se pudo generar la imagen del gráfico.");
                }
            }, 2000); // Espera más tiempo para asegurarse de que la imagen se genere
        });
    }

</script>