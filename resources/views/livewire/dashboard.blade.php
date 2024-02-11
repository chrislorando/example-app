@section('title')
{{ __('label.dashboard') }} 
@endsection

<div>
    <div class="chart-container">
        <canvas id="myChart"></canvas>
    </div>

    <div class="chart-container">
        <div class="row">
            <div class="col-lg-6">
                <canvas id="myChart2"></canvas>
            </div>
            <div class="col-lg-6">
                <canvas id="myChart3"></canvas>
            </div>
        </div>
    </div>
</div>

@script
<script>

    document.addEventListener('livewire:navigated', () => {
        ctx = document.getElementById('myChart');
        if(ctx){
            $wire.dispatch('chart');
        }
       
    })
   
    $wire.on('chart', () => {
        console.log(localStorage.getItem('theme'));
        var myChart = Chart.getChart("myChart");

        if(myChart != null){
            myChart.destroy();
        }

        ctx = document.getElementById('myChart');

        myChart = new Chart(ctx, {
            type: 'bar',
            data: {!! json_encode($data) !!},
            options: {
                responsive:true,
                maintainAspectRatio: true, 
                plugins: {
                    subtitle: {
                        display: true,
                        text: 'Custom Chart Subtitle'
                    },
                }
            },
        });

        ctx2 = document.getElementById('myChart2');

        myChart2 = new Chart(ctx2, {
            type: 'pie',
            data: {
                datasets: [{
                    data: [{id: 'Sales', nested: {value: 1500}}, {id: 'Purchases', nested: {value: 500}}]
                }],
                labels: [
                    'Red',
                    'Blue',
                ],
            },
            options: {
                parsing: {
                    key: 'nested.value'
                },
                responsive:true,
                maintainAspectRatio: true, 
                plugins: {
                    subtitle: {
                        display: true,
                        text: 'Custom Chart Subtitle'
                    },
                }
            }
        });

        ctx3 = document.getElementById('myChart3');

        myChart3 = new Chart(ctx3, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [{id: 'Sales', nested: {value: 500}}, {id: 'Purchases', nested: {value: 2500}}]
                }],
                labels: [
                    'Red',
                    'Blue',
                ],
            },
            options: {
                parsing: {
                    key: 'nested.value'
                },
                responsive:true,
                maintainAspectRatio: true, 
                plugins: {
                    subtitle: {
                        display: true,
                        text: 'Custom Chart Subtitle'
                    },
                }
            }
        });
    });

</script>
@endscript