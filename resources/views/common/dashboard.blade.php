<style>
    .card-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0;
    }

    .cntr {
        width: 95%;
        margin: auto;
    }

    .info-card {
        flex: 1 1 33%;
        padding: 20px;
        text-align: center;
        border: 1px solid #e0e0e0;
        border-top: 4px solid #f39c12;
        /* Top border color to match the header in your image */
        border-radius: 0;
        background-color: #f9f9f9;
    }

    .info-card .icon {
        font-size: 2em;
        margin-bottom: 10px;
    }

    .info-card .number {
        font-size: 1.5em;
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
    }

    .info-card h5 {
        font-size: 1em;
        color: #666;
        margin-top: 0;
    }

    .chart-cntr {
        background: white;
        padding: 10px;
        margin: auto 10px;
        border-radius: 10px;
    }

    /* Custom colors for each card's icon */
    .card-1 .icon {
        color: #007bff;
    }

    /* Blue */
    .card-2 .icon {
        color: #6c757d;
    }

    /* Gray */
    .card-3 .icon {
        color: #34495e;
    }

    /* Dark Blue */
    .card-4 .icon {
        color: #e74c3c;
    }

    /* Red */
    .card-5 .icon {
        color: #d35400;
    }

    /* Orange */
    .card-6 .icon {
        color: #f39c12;
    }

    /* Light Orange */
    /* Skeleton Loader */
    .skeleton-loader {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .skeleton-card {
        height: 120px;
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
        border-radius: 8px;
    }

    /* Shimmer Effect */
    @keyframes shimmer {
        0% {
            background-position: -200% 0;
        }

        100% {
            background-position: 200% 0;
        }
    }
</style>
<x-layout>
    <div class="cntr mt-5">
        <!-- Skeleton Loader -->
        <div id="skeleton" class="skeleton-loader">
            <div class="row">
                <div class="col-md-4">
                    <div class="skeleton-card"></div>
                </div>
                <div class="col-md-4">
                    <div class="skeleton-card"></div>
                </div>
                <div class="col-md-4">
                    <div class="skeleton-card"></div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="skeleton-card"></div>
                </div>
                <div class="col-md-4">
                    <div class="skeleton-card"></div>
                </div>
                <div class="col-md-4">
                    <div class="skeleton-card"></div>
                </div>
            </div>
        </div>

        <!-- Statistics Content -->
        <div id="content" style="display: none;">
            <div class="card-container row">
                <!-- First Row -->
                <div class="info-card card-1 col-md-4">
                    <i class="fas fa-box icon"></i>
                    <div class="number" id="colis-count">0</div>
                    <h5>PARCELS</h5>
                </div>
                <div class="info-card card-2 col-md-4">
                    <i class="fas fa-paper-plane icon"></i>
                    <div class="number" id="bons-envoie-count">0</div>
                    <h5>Delivered Parcels</h5>
                </div>
                <div class="info-card card-4 col-md-4">
                    <i class="fas fa-money-bill-wave icon"></i>
                    <div class="number text-danger" id="bons-paiement-livreur-count">0</div>
                    <h5>PAYMENT <br>For Parcels</h5>
                </div>
            </div>
            <div class="card-container row mt-3">
                <!-- Second Row -->
                <div class="info-card card-3 col-md-4">
                    <i class="fas fa-money-bill-wave icon"></i>
                    <div class="number" id="bons-distribution-count">0</div>
                    <h5>NOT PAYED</h5>
                </div>

                <div class="info-card card-5 col-md-4">
                    <i class="fas fa-file-invoice icon"></i>
                    <div class="number text-danger" id="bons-paiement-ville-count">0</div>
                    <h5>NOT DELIVERED</h5>
                </div>
                <div class="info-card card-6 col-md-4">
                    <i class="fas fa-undo icon"></i>
                    <div class="number" id="bon-retour-ville-count" style="color: #f39c12;">0</div>
                    <h5>RETURNED</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="chart-cntr mt-5">

        <h3 class="text-center mb-4">Data Insights</h3>
        <div class="row align-items-center">
            <!-- Bar Chart -->
            <div class="col-md-6">
                <canvas id="barChart"></canvas>
            </div>
            <!-- Doughnut Chart -->
            <div class="col-md-6">
                <canvas id="doughnutChart"></canvas>
            </div>
        </div>
    </div>

    </div>
</x-layout>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Bar Chart
    document.addEventListener("DOMContentLoaded", () => {
        const skeleton = document.getElementById("skeleton");
        const content = document.getElementById("content");

        // Simulated API call
        fetch('/api/parcels')
            .then(response => response.json())
            .then(data => {
                // Update statistics with API data
                document.getElementById("colis-count").textContent = data.length;
                document.getElementById("bons-envoie-count").textContent = data.filter(e => e.status ===
                    "Livré").length;
                document.getElementById("bons-distribution-count").textContent = data.filter(e => e
                    .etat !== "Payé").length;
                document.getElementById("bons-paiement-livreur-count").textContent = data.filter(e => e
                    .etat === "Payé").length;
                document.getElementById("bons-paiement-ville-count").textContent = data.filter(e => e
                    .status !==
                    "Livré").length;
                document.getElementById("bon-retour-ville-count").textContent = data.filter(e => e
                    .returned).length;

                // Hide skeleton and show content
                skeleton.style.display = "none";
                content.style.display = "block";
                return data
            }).then(async (data)=>{
         const localData = await fetch(`/api/parcelsLocal`)
    .then(response => response.json());
    let totale = 0
    localData.map(e=>{
        totale+=e.totale_d
    })
    const barCtx = document.getElementById('barChart').getContext('2d');
                new Chart(barCtx, {
                    type: 'bar',
                    data: {
                        labels: ['PARCELS',
                            'Delivered Parcels',
                            'PAYMENT',
                            'NOT PAYED',
                            'NOT DELIVERED',
                            'RETURNED',
                        ],
                        datasets: [{
                            label: 'Count',
                            data: [data.length+totale,
                                data.filter(e => e.status ===
                                    "Livré").length+totale,
                               
                                data.filter(e => e
                                    .etat === "Payé").length,
                                    data.filter(e => e
                                    .etat !== "Payé").length,
                                data.filter(e => e
                                    .status !==
                                    "Livré").length,
                                data.filter(e => e
                                    .returned).length,
                            ],
                            backgroundColor: ['#007bff', '#6c757d', '#34495e', '#e74c3c',
                                '#d35400', '#f39c12'
                            ],
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Doughnut Chart
                const doughnutCtx = document.getElementById('doughnutChart').getContext('2d');
                new Chart(doughnutCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['PARCELS',
                            'Delivered Parcels',
                            'PAYMENT',
                            'NOT PAYED',
                            'NOT DELIVERED',
                            'RETURNED',
                        ],
                        datasets: [{
                            data: [data.length+totale,
                                data.filter(e => e.status ===
                                    "Livré").length+totale,
                                    data.filter(e => e
                                    .etat === "Payé").length,
                                    data.filter(e => e
                                        .etat !== "Payé").length,
                                data.filter(e => e
                                    .status !==
                                    "Livré").length,
                                data.filter(e => e
                                    .returned).length,
                            ],
                            backgroundColor: ['#007bff', '#6c757d', '#34495e', '#e74c3c',
                                '#d35400', '#f39c12'
                            ],
                        }]
                    },
                    options: {
                        responsive: true,
                    }
                });
    document.getElementById("colis-count").textContent=+document.getElementById("colis-count").textContent+totale
     document.getElementById("bons-envoie-count").textContent= +document.getElementById("bons-envoie-count").textContent+totale
    });

    })
</script>
