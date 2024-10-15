<!DOCTYPE html>

<?php $murid = [
    ["12345", "Raka", "Laki-laki", "3WD1", "Jakarta"],
    ["67890", "Nana", "Perempuan", "3SE1", "Surabaya"],
    ["11223", "Gibran", "Laki-laki", "3WD1", "Jakarta"],
    ["54321", "Gabriel", "Laki-laki", "3WD2", "Bandung"],
    ["98765", "Gabriella", "Perempuan", "3SE2", "Yogyakarta"],
    ["13579", "Udin", "Laki-laki", "3WD1", "Semarang"],
    ['45678', 'Rani', 'Perempuan', '3SE1', 'Surabaya'],
]; ?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Murid</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Data Murid</h2>
        <table class="table table-striped table-bordered" id="myTable">
            <thead class="table-dark">
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Kelas</th>
                    <th>Kota Asal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($murid as $muridlist): ?>
                <tr>
                    <td><?php echo $muridlist[0]; ?></td>
                    <td><?php echo $muridlist[1]; ?></td>
                    <td><?php echo $muridlist[2]; ?></td>
                    <td><?php echo $muridlist[3]; ?></td>
                    <td><?php echo $muridlist[4]; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Siswa</h5>
                        <p class="card-text"><?php echo count($murid); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Kelas</h5>
                        <p class="card-text"><?php echo count(array_unique(array_column($murid, 3))); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Kota Asal</h5>
                        <p class="card-text"><?php echo count(array_unique(array_column($murid, 4))); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-4 justify-content-center">
            <div class="col-md-4">
                <select id="chartFilter" class="form-select">
                    <option value="jenisKelamin">Jenis Kelamin</option>
                    <option value="kelas">Kelas</option>
                    <option value="kotaAsal">Kota Asal</option>
                </select>
            </div>
        </div>
        <div class="row mb-4 justify-content-center">
            <div class="col-md-8 text-center">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();

        const ctx = document.getElementById('myChart').getContext('2d');
        let myChart;

        function updateChart(filterType) {
            const data = <?php echo json_encode($murid); ?>;
            const counts = {};

            data.forEach(student => {
                let key;
                switch(filterType) {
                    case 'jenisKelamin':
                        key = student[2];
                        break;
                    case 'kelas':
                        key = student[3];
                        break;
                    case 'kotaAsal':
                        key = student[4];
                        break;
                }
                counts[key] = (counts[key] || 0) + 1;
            });

            const chartData = {
                labels: Object.keys(counts),
                datasets: [{
                    label: 'Jumlah Siswa',
                    data: Object.values(counts),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            };

            if (myChart) {
                myChart.destroy();
            }

            myChart = new Chart(ctx, {
                type: 'bar',
                data: chartData,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Data Siswa'
                        }
                    }
                }
            });
        }

        $('#chartFilter').change(function() {
            updateChart($(this).val());
        });

        // Initial chart
        updateChart('jenisKelamin');
    });
    </script>
</body>
</html>