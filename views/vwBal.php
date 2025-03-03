<div class="wrapper row">
    <div class="counter col_fourth">
        <i class="bi bi-cart-check-fill bi-bal"></i>
        <h2 class="timer count-title count-number" data-to="<?=$dtProductVend?>" data-speed="1500"></h2>
        <p class="count-text ">Productos Vendidos</p>
    </div>

    <div class="counter col_fourth">
        <i class="bi bi-currency-dollar bi-bal"></i>
        <h2 class="timer count-title count-number" data-to="<?=$dtComision?>" data-speed="1500"></h2>
        <p class="count-text ">Ingresos Totales</p>
    </div>

    <div class="counter col_fourth">
        <i class="bi bi-person-fill-add bi-bal"></i>
        <h2 class="timer count-title count-number" data-to="<?=$dtClientes?>" data-speed="1500"></h2>
        <p class="count-text ">Clientes Registrados</p>
    </div>

    <div class="counter col_fourth end">
        <i class="bi bi-rocket-takeoff-fill bi-bal"></i>
        <h2 class="timer count-title count-number" data-to="<?=$dtPedEnv?>" data-speed="1500"></h2>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    (function ($) {
	$.fn.countTo = function (options) {
		options = options || {};
		
		return $(this).each(function () {
			// set options for current element
			var settings = $.extend({}, $.fn.countTo.defaults, {
				from:            $(this).data('from'),
				to:              $(this).data('to'),
				speed:           $(this).data('speed'),
				refreshInterval: $(this).data('refresh-interval'),
				decimals:        $(this).data('decimals')
			}, options);
			
			// how many times to update the value, and how much to increment the value on each update
			var loops = Math.ceil(settings.speed / settings.refreshInterval),
				increment = (settings.to - settings.from) / loops;
			
			// references & variables that will change with each update
			var self = this,
				$self = $(this),
				loopCount = 0,
				value = settings.from,
				data = $self.data('countTo') || {};
			
			$self.data('countTo', data);
			
			// if an existing interval can be found, clear it first
			if (data.interval) {
				clearInterval(data.interval);
			}
			data.interval = setInterval(updateTimer, settings.refreshInterval);
			
			// initialize the element with the starting value
			render(value);
			
			function updateTimer() {
				value += increment;
				loopCount++;
				
				render(value);
				
				if (typeof(settings.onUpdate) == 'function') {
					settings.onUpdate.call(self, value);
				}
				
				if (loopCount >= loops) {
					// remove the interval
					$self.removeData('countTo');
					clearInterval(data.interval);
					value = settings.to;
					
					if (typeof(settings.onComplete) == 'function') {
						settings.onComplete.call(self, value);
					}
				}
			}
			
			function render(value) {
				var formattedValue = settings.formatter.call(self, value, settings);
				$self.html(formattedValue);
			}
		});
	};
	
	$.fn.countTo.defaults = {
		from: 0,               // the number the element should start at
		to: 0,                 // the number the element should end at
		speed: 1000,           // how long it should take to count between the target numbers
		refreshInterval: 100,  // how often the element should be updated
		decimals: 0,           // the number of decimal places to show
		formatter: formatter,  // handler for formatting the value before rendering
		onUpdate: null,        // callback method for every time the element is updated
		onComplete: null       // callback method for when the element finishes updating
	};
	
	function formatter(value, settings) {
		return value.toFixed(settings.decimals);
	}
}(jQuery));

jQuery(function ($) {
  // custom formatting example
  $('.count-number').data('countToOptions', {
	formatter: function (value, options) {
	  return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
	}
  });
  
  // start all the timers
  $('.timer').each(count);  
  
  function count(options) {
	var $this = $(this);
	options = $.extend({}, options || {}, $this.data('countToOptions') || {});
	$this.countTo(options);
  }
});
</script>
