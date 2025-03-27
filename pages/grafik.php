<?php
// Koneksi ke database (Pastikan $db sudah terkoneksi)


// Ambil data dari tabel raw_data
$sql = "SELECT log_time, gps_speed, accelero_speed, accelero_ax, accelero_ay, accelero_az, accelero_gx, accelero_gy, accelero_gz, magnetometer_heading FROM train_tracking.raw_data ORDER BY log_time ASC";
$result = mysqli_query($db, $sql);

$waktu = [];
$gps_speed = [];
$accelero_speed = [];
$magnetometer_heading = [];
$accelero_ax = [];
$accelero_ay = [];
$accelero_az = [];
$accelero_gx = [];
$accelero_gy = [];
$accelero_gz = [];

while ($row = mysqli_fetch_assoc($result)) {
    // Ubah format waktu agar lebih singkat
    $waktu[] = date("H:i:s", strtotime($row['log_time']));
    $gps_speed[] = $row['gps_speed'];
    $accelero_speed[] = $row['accelero_speed'];
    $magnetometer_heading[] = $row['magnetometer_heading'];
    $accelero_ax[] = $row['accelero_ax'];
    $accelero_ay[] = $row['accelero_ay'];
    $accelero_az[] = $row['accelero_az'];
    $accelero_gx[] = $row['accelero_gx'];
    $accelero_gy[] = $row['accelero_gy'];
    $accelero_gz[] = $row['accelero_gz'];
}

// Konversi array PHP ke format JSON agar bisa digunakan di JavaScript
$waktu = json_encode($waktu);
$gps_speed = json_encode($gps_speed, JSON_NUMERIC_CHECK);
$accelero_speed = json_encode($accelero_speed, JSON_NUMERIC_CHECK);
$magnetometer_heading = json_encode($magnetometer_heading, JSON_NUMERIC_CHECK);
$accelero_ax = json_encode($accelero_ax, JSON_NUMERIC_CHECK);
$accelero_ay = json_encode($accelero_ay, JSON_NUMERIC_CHECK);
$accelero_az = json_encode($accelero_az, JSON_NUMERIC_CHECK);
$accelero_gx = json_encode($accelero_gx, JSON_NUMERIC_CHECK);
$accelero_gy = json_encode($accelero_gy, JSON_NUMERIC_CHECK);
$accelero_gz = json_encode($accelero_gz, JSON_NUMERIC_CHECK);
?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Grafik</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- /.col-md-6 -->
          <div class="col-lg-12">
          <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Speed</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="areaChart1" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <div class="row">
          <!-- /.col-md-6 -->
          <div class="col-lg-12">
          <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Magnetometer Heading</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="areaChart3" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <div class="row">
          <!-- /.col-md-6 -->
          <div class="col-lg-12">
          <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Accelerometer</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="areaChart4" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <div class="row">
          <!-- /.col-md-6 -->
          <div class="col-lg-12">
          <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Gyroscope</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="areaChart5" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

   <!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>

<script>
$(function () {
    // Ambil data dari PHP ke dalam JavaScript
    var waktu = <?php echo $waktu; ?>;
    var gps_speed = <?php echo $gps_speed; ?>;
    var accelero_speed = <?php echo $accelero_speed; ?>;
    var magnetometer_heading = <?php echo $magnetometer_heading; ?>;
    var accelero_ax = <?php echo $accelero_ax; ?>;
    var accelero_ay = <?php echo $accelero_ay; ?>;
    var accelero_az = <?php echo $accelero_az; ?>;
    var accelero_gx = <?php echo $accelero_gx; ?>;
    var accelero_gy = <?php echo $accelero_gy; ?>;
    var accelero_gz = <?php echo $accelero_gz; ?>;

    var areaChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: { display: true },
        scales: {
            xAxes: [{ gridLines: { display: false } }],
            yAxes: [{ gridLines: { display: true } }]
        }
    };

    var speedChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: { display: true },
        scales: {
            xAxes: [{ gridLines: { display: false } }],
            yAxes: [{ gridLines: { display: true } }]
        }
    };

    var acceleroChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: { display: true },
        scales: {
            xAxes: [{ gridLines: { display: false } }],
            yAxes: [{ gridLines: { display: true } }]
        }
    };

    var gyroChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: { display: true },
        scales: {
            xAxes: [{ gridLines: { display: false } }],
            yAxes: [{ gridLines: { display: true } }]
        }
    };

    // Speed Chart (Menggabungkan GPS Speed dan Accelero Speed)
    var ctx = $('#areaChart1').get(0).getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: waktu,
            datasets: [
                {
                    label: 'GPS Speed',
                    backgroundColor: 'rgba(60,141,188,0.2)',
                    borderColor: 'rgba(60,141,188,1)',
                    pointRadius: false,
                    data: gps_speed
                },
                {
                    label: 'Accelero Speed',
                    backgroundColor: 'rgba(255,99,132,0.2)',
                    borderColor: 'rgba(255,99,132,1)',
                    pointRadius: false,
                    data: accelero_speed
                }
            ]
        },
        options: speedChartOptions
    });




    // Magnetometer Heading Chart
    var ctx3 = $('#areaChart3').get(0).getContext('2d');
    new Chart(ctx3, {
        type: 'line',
        data: {
            labels: waktu,
            datasets: [{
                label: 'Magnetometer Heading',
                backgroundColor: 'rgba(255,244,13,0.2)',
                borderColor: 'rgba(255,244,13,1)',
                pointRadius: false,
                data: magnetometer_heading
            }]
        },
        options: areaChartOptions
    });

    var ctx4 = $('#areaChart4').get(0).getContext('2d');
    new Chart(ctx4, {
        type: 'line',
        data: {
            labels: waktu,
            datasets: [
                {
                    label: 'Accelero ax',
                    backgroundColor: 'rgba(255,206,86,0.2)',
                    borderColor: 'rgba(255,206,86,1)',
                    pointRadius: false,
                    data: accelero_ax
                },
                {
                    label: 'Accelero ay',
                    backgroundColor: 'rgba(75,192,192,0.2)',
                    borderColor: 'rgba(75,192,192,1)',
                    pointRadius: false,
                    data: accelero_ay
                },
                {
                    label: 'Accelero az',
                    backgroundColor: 'rgba(153,102,255,0.2)',
                    borderColor: 'rgba(153,102,255,1)',
                    pointRadius: false,
                    data: accelero_az
                }
            ]
        },
        options: acceleroChartOptions
    });

    var ctx5 = $('#areaChart5').get(0).getContext('2d');
    new Chart(ctx5, {
        type: 'line',
        data: {
            labels: waktu,
            datasets: [
                {
                    label: 'gyro gx',
                    backgroundColor: 'rgba(255,159,64,0.2)',
                    borderColor: 'rgba(255,159,64,1)',
                    pointRadius: false,
                    data: accelero_gx
                },
                {
                    label: 'gyro gy',
                    backgroundColor: 'rgba(54,162,235,0.2)',
                    borderColor: 'rgba(54,162,235,1)',
                    pointRadius: false,
                    data: accelero_gy
                },
                {
                    label: 'gyro gz',
                    backgroundColor: 'rgba(231,76,60,0.2)',
                    borderColor: 'rgba(231,76,60,1)',
                    pointRadius: false,
                    data: accelero_gz
                }
            ]
        },
        options: gyroChartOptions
    });

});

</script>