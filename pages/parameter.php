<?php

$awal = date("Y-m-01");
$akhir = date("Y-m-d", strtotime("+1 day"));

if(isset($_POST['tampil'])){
  $awal = $_POST['awal'];
  $akhir = $_POST['akhir'];
}

$sql = "SELECT * FROM train_tracking.raw_data WHERE log_time BETWEEN '$awal' AND '$akhir'";
$result = mysqli_query($db, $sql);

?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Parameter Raw data</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
            <div class="card-header">
            <form method="POST" action="?hal=parameter">
    <div class="row g-3 align-items-end">
        <!-- Input tanggal awal -->
        <div class="col-md-3">
            <label for="awal" class="form-label fw-bold">Dari</label>
            <input type="date" id="awal" class="form-control" name="awal" value="<?php echo $awal; ?>">
        </div>

        <!-- Input tanggal akhir -->
        <div class="col-md-3">
            <label for="akhir" class="form-label fw-bold">Sampai</label>
            <input type="date" id="akhir" class="form-control" name="akhir" value="<?php echo $akhir; ?>">
        </div>

        <!-- Tombol Tampil -->
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100" name="tampil">Tampil</button>
        </div>
    </div>
</form>

              </div>
              <div class="card-body">
              <div class="table-responsive">

              <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Timestamp</th>
                                        <th>Device ID</th>
                                        <th>Latitude</th>
                                        <th>Longitude</th>
                                        <th>Altitde</th>
                                        <th>GPS Speed</th>
                                        <th>Accelero ax</th>
                                        <th>Accelero ay</th>
                                        <th>Accelero az</th>
                                        <th>Accelero gx</th>
                                        <th>Accelero gy</th>
                                        <th>Accelero gz</th>
                                        <th>Accelero Speed</th>
                                        <th>Heading</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php while ($row = mysqli_fetch_array($result)) { ?>
                                        <tr>    
                                          <td><?php echo $row['log_time']; ?></td>
                                          <td><?php echo $row['sensor_id']; ?></td>
                                          <td><?php echo $row['gps_lat']; ?></td>
                                          <td><?php echo $row['gps_lon']; ?></td>
                                          <td><?php echo $row['gps_alt']; ?></td>
                                          <td><?php echo $row['gps_speed']; ?></td>
                                          <td><?php echo $row['accelero_ax']; ?></td>
                                          <td><?php echo $row['accelero_ay']; ?></td>
                                          <td><?php echo $row['accelero_az']; ?></td>
                                          <td><?php echo $row['accelero_gx']; ?></td>
                                          <td><?php echo $row['accelero_gy']; ?></td>
                                          <td><?php echo $row['accelero_gz']; ?></td>
                                          <td><?php echo $row['accelero_speed']; ?></td>
                                          <td><?php echo $row['magnetometer_heading']; ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Timestamp</th>
                                        <th>Device ID</th>
                                        <th>Latitude</th>
                                        <th>Longitude</th>
                                        <th>Altitde</th>
                                        <th>GPS Speed</th>
                                        <th>Accelero ax</th>
                                        <th>Accelero ay</th>
                                        <th>Accelero az</th>
                                        <th>Accelero gx</th>
                                        <th>Accelero gy</th>
                                        <th>Accelero gz</th>
                                        <th>Accelero Speed</th>
                                        <th>Heading</th>
                                    </tr>
                                </tfoot>
                            </table>
                                </div>
              </div>
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

  <script>
  $(function () {
    $("#example1").DataTable({
      // "responsive": true, "lengthChange": true, "autoWidth": true,
      "scrollX": true,
        "paging": true,
        "ordering": true,
        "info": true,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>