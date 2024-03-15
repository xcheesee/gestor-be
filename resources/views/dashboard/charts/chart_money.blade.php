{{-- Usar caso seja necessário mais recursos como formatador --}}
<script type="text/javascript">
    // Initialize the echarts instance based on the prepared dom
    var myChart = echarts.init(document.getElementById('{{ $div_id }}'));

    // Specify the configuration items and data for the chart
    var option = {
      title: {
        text: @php echo json_encode($options['title']['text']); @endphp
      },
      tooltip: {
        trigger: 'item',
        formatter: function (value){
            return value.name+"<br> "+formataDinheiro(value.data);
        }
      },
      toolbox:{"show":true,"feature":{"mark":{"show":true},"dataView":{"show":true,"readOnly":true},"saveAsImage":{"show":true}}},
      legend: @php if(array_key_exists('legend',$options)) echo json_encode($options['legend']); @endphp,
      xAxis: @php echo json_encode($options['xAxis']); @endphp,
      yAxis: @php echo json_encode($options['yAxis']); @endphp,
      series: @php echo json_encode($options['series']); @endphp
    };

    //var option = @php echo json_encode($options); @endphp;

    // Display the chart using the configuration items and data just specified.
    myChart.setOption(option);
</script>
