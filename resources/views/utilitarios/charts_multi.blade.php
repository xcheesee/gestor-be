<script>
    var options =
    {
        chart: {
            type: '{!! $chart->type() !!}',
            height: {!! $chart->height() !!},
            width: '{!! $chart->width() !!}',
            toolbar: {!! $chart->toolbar() !!},
            zoom: {!! $chart->zoom() !!},
            fontFamily: '{!! $chart->fontFamily() !!}',
            foreColor: '{!! $chart->foreColor() !!}',
            sparkline: {!! $chart->sparklines() !!},
            @if(property_exists($chart,'stacked')) stacked: {!! $chart->stacked !!} @endif
        },
        plotOptions: {
            bar: {!! $chart->horizontal() !!}
        },
        colors: {!! $chart->colors() !!},
        series: {!! $chart->dataset() !!},
        dataLabels: {!! $chart->dataLabels() !!},
        @if($chart->labels())
            labels: {!! json_encode($chart->labels(), true) !!},
        @endif
        title: {
            text: "{!! $chart->title() !!}"
        },
        subtitle: {
            text: '{!! $chart->subtitle() !!}',
            align: '{!! $chart->subtitlePosition() !!}'
        },
        xaxis: {
            categories: {!! $chart->xAxis() !!}
        },
        yaxis: [
          {
            seriesName: '{!! $chart->altY1["series"] !!}',
            axisTicks: {
              show: true,
            },
            axisBorder: {
              show: true,
            },
            title: {
              text: '{!! $chart->altY1["title"] !!}'
            },
            tooltip: {
              enabled: true
            }
          },
          {
            seriesName: '{!! $chart->altY2["series"] !!}',
            opposite: true,
            axisTicks: {
              show: true,
            },
            axisBorder: {
              show: true,
            },
            title: {
              text: '{!! $chart->altY2["title"] !!}'
            },
            tooltip: {
              enabled: true
            }
          }
        ],
        grid: {!! $chart->grid() !!},
        markers: {!! $chart->markers() !!},
        @if($chart->stroke())
            stroke: {!! $chart->stroke() !!},
        @endif
    }

    var chart = new ApexCharts(document.querySelector("#{!! $chart->id() !!}"), options);
    chart.render();
</script>
