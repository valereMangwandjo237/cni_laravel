<div style="width: 40%; margin: auto;">
        <h3>Répartition des documents</h3>
        <canvas id="pieChart"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('pieChart').getContext('2d');

        const data = {
            labels: ['CNI', 'Passeport', 'Récépissé', 'Invalide'],
            datasets: [{
                data: [45, 25, 20, 10],
                backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545'],
            }]
        };

        const total = data.datasets[0].data.reduce((a, b) => a + b, 0);

        const pieChart = new Chart(ctx, {
            type: 'pie',
            data: data,
            options: {
                responsive: true,
                animation: {
                    duration: 5000, // 💡 ralentit l'apparition
                    easing: 'easeOutBounce' // facultatif, pour effet fluide
                },
                plugins: {
                    datalabels: {
                        color: '#fff',
                        font: {
                            weight: 'bold',
                            size: 14
                        },
                        formatter: (value, context) => {
                            let percentage = (value / total * 100).toFixed(1);
                            return percentage + '%';
                        }
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    </script>
