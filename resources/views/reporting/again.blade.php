
<div style="height:500px;width:600px;">
    <canvas id="myChart"></canvas>
</div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
