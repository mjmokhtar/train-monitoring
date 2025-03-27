<?php

$awal = date("Y-m-01");
$akhir = date("Y-m-d", strtotime("+1 day"));

if(isset($_POST['tampil'])){
  $awal = $_POST['awal'];
  $akhir = $_POST['akhir'];
}

$sql = "SELECT * FROM train_tracking.train_logs WHERE timestamp BETWEEN '$awal' AND '$akhir'";
$result = mysqli_query($db, $sql);

?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Train Log</h1>
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
            <form method="POST" action="?hal=train_log">
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
              <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Device ID</th>
                                        <th>Timestamp</th>
                                        <th>Latitude</th>
                                        <th>Longitude</th>
                                        <th>Speed</th>
                                        <th>Heading</th>
                                        <th>Station ID</th>
                                        <th>Next Station</th>
                                        <th>Distance to Station</th>
                                        <th>ETA (Minutes)</th>
                                        <th>Source</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php while ($row = mysqli_fetch_array($result)) { ?>
                                        <tr>
                                            
                                            <td><?php echo $row['device_id']; ?></td>
                                            <td><?php echo $row['timestamp']; ?></td>
                                            <td><?php echo $row['latitude']; ?></td>
                                            <td><?php echo $row['longitude']; ?></td>
                                            <td><?php echo $row['speed']; ?></td>
                                            <td><?php echo $row['heading']; ?></td>
                                            <td><?php echo $row['station_id']; ?></td>
                                            <td><?php echo $row['station_name']; ?></td>
                                            <td><?php echo $row['distance_to_station']; ?></td>
                                            <td><?php echo $row['eta_minutes']; ?></td>
                                            <td><?php echo $row['source']; ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        
                                        <th>Device ID</th>
                                        <th>Timestamp</th>
                                        <th>Latitude</th>
                                        <th>Longitude</th>
                                        <th>Speed</th>
                                        <th>Heading</th>
                                        <th>Station ID</th>
                                        <th>Station Name</th>
                                        <th>Distance to Station</th>
                                        <th>ETA (Minutes)</th>
                                        <th>Source</th>
                                    </tr>
                                </tfoot>
                            </table>
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