
{{-- <div class="row d-flex justify-content-center m-3" style="height: 400px;">
    <div id="chart1" class="col d-grid gap-2" style="height: 400px;"></div>
</div> --}}
<script type="text/javascript">
    // Initialize the echarts instance based on the prepared dom
    var myChart = echarts.init(document.getElementById('{{ $div_id }}'));

    // Specify the configuration items and data for the chart
    // var option = {
    //   title: {
    //     text: 'Nico & Nicky: Idade da Turminha'
    //   },
    //   tooltip: {},
    //   legend: {
    //     data: ['idade']
    //   },
    //   xAxis: {
    //     data: ['Nico', 'Nicky', 'Nicão', 'Rabinho', 'Pixixiu', 'Fraja']
    //   },
    //   yAxis: {},
    //   series: [
    //     {
    //       name: 'idade',
    //       type: 'bar',
    //       data: [2, 4, 7, 2, 0.5, 0.83]
    //     }
    //   ]
    // };

    var option = @php echo json_encode($options); @endphp;

    // var option = {
    //     "title":{
    //         "text":"Nico & Nicky: Idade da Turminha"
    //     },
    //     "tooltip":[],
    //     "legend":{
    //         "data":["idade"]
    //     },
    //     "xAxis":{
    //         "data":["Nico","Nicky","Nic\u00e3o","Rabinho","Pixixiu","Fraja"]
    //     },
    //     "yAxis": {},
    //     "series":{
    //         "name":"idade",
    //         "type":"bar",
    //         "data":[2,4,7,2,0.5,0.83]
    //     }
    // };

    // Display the chart using the configuration items and data just specified.
    myChart.setOption(option);
</script>
