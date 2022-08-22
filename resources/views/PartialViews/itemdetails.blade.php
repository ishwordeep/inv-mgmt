<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        @foreach($itemDetails as $item)
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="card-counter success">
                <i class="fa fa-building"></i>
                <span class="count-numbers" id="">{{$item->item_qty}} Units</span>
                <span class="count-name">{{isset($item->store_id) ? $item->storeEntity->name_en : ''}}</span>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="container-fluid m-0 p-0 pb-5 px-3 mt-3" style="background: pink;">
    <div class="row">
        <div class="dashboard-heading">
            <h3 class="text-center">
                Sales Overview
            </h3>
        </div>
        <div style="height:500px;width:600px;">
            <canvas id="myChart" width="400" height="400"></canvas>
        </div>
    </div>
</div>


    <script src="{{ asset('js/chart.min.js') }}"></script>
    <script>
        const labels = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
        ];

        const data = {
            labels: labels,
            datasets: [{
                    label: 'Item A',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: [0, 10, 5, 2, 20, 30, 45],
                },
                {
                    label: 'Item B',
                    backgroundColor: 'rgb(55, 9, 32)',
                    borderColor: 'rgb(55, 9, 32)',
                    data: [0, 30, 52, 12, 70, 230, 45],
                },
                // {
                //     label: 'Item C',
                //     backgroundColor: 'rgb(5, 99, 132)',
                //     borderColor: 'rgb(5, 99, 132)',
                //     data: [0, 10, 92, 12, 220, 20, 45],
                // }
            ]
        };

        const config = {
            type: 'line',
            data: data,
            options: {
                animations: {
                    tension: {
                        duration: 2000,
                        easing: 'linear',
                        from: 1,
                        to: 0,
                        loop: false
                    }
                },
                plugins: {
                    title: {
                display: true,
                text: 'Sales Chart'
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        let label = context.dataset.label || '';

                        if (label) {
                            label += ': ';
                        }
                        if (context.parsed.y !== null) {
                            label += new Intl.NumberFormat('en-US').format(context.parsed.y);
                        }
                        return label;
                    }
                }
            },
           
        }
            }
        };

        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
    </script>
