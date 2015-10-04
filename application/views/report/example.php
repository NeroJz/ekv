    <div class="row-fluid">
      <div class="span12" style="background-color: blue;">
        <div class="row-fluid" id="chart_container" align="center">
		</div>
        <div class="row-fluid">
          <div class="span6" style="background-color: green;">Fluid 6</div>
          <div class="span6" style="background-color: yellow;">Fluid 6</div>
        </div>
      </div>
    </div>

<script src="<?=base_url()?>assets/js/highcharts.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/js/exporting.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/js/themes/grid.js" type="text/javascript"></script>
<script>
	$(function () {
        $('#chart_container').highcharts({
            chart: {
                type: 'bar',
                height: 500,
            },
            title: {
                text: 'Historic World Population by Region'
            },
            subtitle: {
                text: 'Source: Wikipedia.org'
            },
            xAxis: {
                categories: ['Africa', 'America', 'Asia', 'Europe', 'Oceania'],
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Population (millions)',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' millions'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -100,
                y: 100,
                floating: false,
                borderWidth: 1,
                backgroundColor: '#FFFFFF',
                shadow: true
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Year 1800',
                data: [107, 31, 635, 203, 2]
            }, {
                name: 'Year 1900',
                data: [133, 156, 947, 408, 6]
            }, {
                name: 'Year 2008',
                data: [973, 914, 4054, 732, 34]
            }]
        });
    });
</script>