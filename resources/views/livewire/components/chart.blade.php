<div>
    <div wire:ignore>
        <div id="{{ $chartId }}" class="apex-chart" chartId="{{ $chartId }}"></div>
    </div>

    @script
    <script>
        let options = @json($chartOptions);
        let chart; // Declare chart in a higher scope

        let timeout = setTimeout(() => {
            clearInterval(checkApexCharts); // Stop interval after timeout
            console.error("ApexCharts failed to load after 10 seconds.");
        }, 10000); // Timeout in 10 seconds

        let checkApexCharts = setInterval(() => {
            if (typeof ApexCharts !== 'undefined') {
                clearInterval(checkApexCharts); // Stop interval
                clearTimeout(timeout); // Stop timeout if successful
                console.log("ApexCharts loaded successfully!");

                // Initialize chart and assign it to the higher-scope variable
                chart = new ApexCharts(document.querySelector("#{{ $chartId }}"), options);
                chart.render();
            } else {
                console.warn("ApexCharts not loaded yet, retrying...");
            }
        }, 50); // Check every 100ms

        $wire.on('update-chart', (event) => {
            if (event[0].chartId == "{{ $chartId }}") {
                if (chart) {
                    chart.updateOptions(event[0].chartOptions); // Update chart options
                } else {
                    console.error("Chart is not initialized yet.");
                }
            }
        });

    </script>
    @endscript
</div>
