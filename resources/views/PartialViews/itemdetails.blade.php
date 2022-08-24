<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
    integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" type="text/css" href="{{ asset('/css/dashboard.css') }}">

<style>
    .dashboard-heading {
        width: 100%;
        color: #192840 !important;
        margin: 20px 20px;
        padding-left: 10px;
    }
</style>


<div class="container-fluid m-0 p-0 pb-5 px-3 mb-3 mt-3" style="background: white;">
    <div class="row">
        <div class="dashboard-heading">
            <h3 class="text-center">
                Store wise Item Overview
            </h3>
        </div>
        @foreach ($itemDetails as $item)
            <div class="col-lg-4 col-md-6 col-xs-12">
                <div class="card-counter success">
                    <i class="fa fa-building"></i>
                    <span class="count-numbers" id="">{{ $item->item_qty }} Units</span>
                    <span class="count-name">{{ isset($item->store_id) ? $item->storeEntity->name_en : '' }}</span>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="container-fluid m-0 p-0 pb-5 px-3 mt-3">
    <div class="row">
        <div class="dashboard-heading">
            <h3 class="text-center">
                Sales Overview
            </h3>
        </div>
        <div style="height:500px;width:500px;" class="">
            <canvas id="myChart" width="400" height="400"></canvas>
        </div>
    </div>
</div>

<script src="{{ asset('js/chart.min.js') }}"></script>
<script>
    var storeWiseSales = '<?php echo isset($sales) ? json_encode($sales) : '[]'; ?>';
    storeWiseSales = JSON.parse(storeWiseSales);

    const labels = [];
    const salesdataa = [];

    for (i = 0; i < storeWiseSales.length; i++) {
        labels.push(storeWiseSales[i].store_id);
        salesdataa.push(storeWiseSales[i].salesdata);
    }

    const data = {
  labels: labels,
  datasets: [{
    label: 'My First Dataset',
    data: salesdataa,
    backgroundColor: [
      'rgba(255, 99, 132, 0.2)',
      'rgba(255, 159, 64, 0.2)',
      'rgba(255, 205, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(201, 203, 207, 0.2)'
    ],
    borderColor: [
      'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(75, 192, 192)',
      'rgb(54, 162, 235)',
      'rgb(153, 102, 255)',
      'rgb(201, 203, 207)'
    ],
    borderWidth: 1
  }]
};

    const config = {
        type: 'bar',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        },
    };

    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
</script>
