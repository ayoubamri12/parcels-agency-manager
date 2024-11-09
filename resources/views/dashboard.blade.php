<style>
    .card-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 0;
    }
    .cntr{
        width: 95%;
        margin: auto;
    }
    .info-card {
      flex: 1 1 33%;
      padding: 20px;
      text-align: center;
      border: 1px solid #e0e0e0;
      border-top: 4px solid #f39c12; /* Top border color to match the header in your image */
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
    .chart-cntr{
        background: white;
        padding: 10px;
        margin:auto 10px;
        border-radius: 10px;    
    }
    /* Custom colors for each card's icon */
    .card-1 .icon { color: #007bff; } /* Blue */
    .card-2 .icon { color: #6c757d; } /* Gray */
    .card-3 .icon { color: #34495e; } /* Dark Blue */
    .card-4 .icon { color: #e74c3c; } /* Red */
    .card-5 .icon { color: #d35400; } /* Orange */
    .card-6 .icon { color: #f39c12; } /* Light Orange */
  </style>
<x-layout>
    <div class="cntr mt-5">
        <div class="card-container row">
          <!-- First Row -->
          <div class="info-card card-1 col-md-4">
            <i class="fas fa-box icon"></i>
            <div class="number">0</div>
            <h5>COLIS</h5>
          </div>
          <div class="info-card card-2 col-md-4">
            <i class="fas fa-paper-plane icon"></i>
            <div class="number">41</div>
            <h5>BONS D'ENVOIE</h5>
          </div>
          <div class="info-card card-3 col-md-4">
            <i class="fas fa-file-invoice icon"></i>
            <div class="number">214</div>
            <h5>BONS DE DISTRIBUTION</h5>
          </div>
        </div>
        <div class="card-container row mt-3">
          <!-- Second Row -->
          <div class="info-card card-4 col-md-4">
            <i class="fas fa-money-bill-wave icon"></i>
            <div class="number text-danger">93</div>
            <h5>BONS DE PAYMENT <br>POUR LIVREUR</h5>
          </div>
          <div class="info-card card-5 col-md-4">
            <i class="fas fa-money-bill-wave icon"></i>
            <div class="number text-danger">17</div>
            <h5>BONS DE PAYMENT <br>POUR VILLE</h5>
          </div>
          <div class="info-card card-6 col-md-4">
            <i class="fas fa-undo icon"></i>
            <div class="number" style="color: #f39c12;">12</div>
            <h5>BON DE RETOUR <br>POUR VILLE</h5>
          </div>
        </div>
        <!-- Charts Section -->
<div class="chart-cntr mt-5">
 
        <h3 class="text-center mb-4">Data Insights</h3>
        <div class="row">
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
  const barCtx = document.getElementById('barChart').getContext('2d');
  new Chart(barCtx, {
    type: 'bar',
    data: {
      labels: ['Colis', 'Bons d\'Envoie', 'Bons de Distribution', 'Bons de Paiement Livreur', 'Bons de Paiement Ville', 'Bon de Retour Ville'],
      datasets: [{
        label: 'Count',
        data: [0, 41, 214, 93, 17, 12],
        backgroundColor: ['#007bff', '#6c757d', '#34495e', '#e74c3c', '#d35400', '#f39c12'],
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
      labels: ['Colis', 'Bons d\'Envoie', 'Bons de Distribution', 'Bons de Paiement Livreur', 'Bons de Paiement Ville', 'Bon de Retour Ville'],
      datasets: [{
        data: [0, 41, 214, 93, 17, 12],
        backgroundColor: ['#007bff', '#6c757d', '#34495e', '#e74c3c', '#d35400', '#f39c12'],
      }]
    },
    options: {
      responsive: true,
    }
  });
</script>