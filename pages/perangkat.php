<?php

$alert = "";

if(isset($_POST['tambah'])){
  $sql_tambah = "INSERT INTO train_tracking.devices (device_id, train_name) VALUES ('{$_POST['device_id']}', '{$_POST['train_name']}')";
  mysqli_query($db, $sql_tambah);

  $alert = "tambah";
}

if(isset($_GET['hapus'])){
  $sql_hapus = "UPDATE train_tracking.devices SET status='0' WHERE device_id='{$_GET['hapus']}'";
  mysqli_query($db, $sql_hapus);

  $alert = "hapus";
}

if(isset($_POST['ubah'])){
  $sql_ubah = "UPDATE train_tracking.devices SET device_id='{$_POST['device_id']}', train_name='{$_POST['train_name']}' WHERE device_id='{$_POST['old_device_id']}'";
  mysqli_query($db, $sql_ubah);

  $alert = "ubah";
}

$sql = "SELECT * FROM train_tracking.devices WHERE status='1'";
$result = mysqli_query($db, $sql);

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Perangkat</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

        <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <?php if($alert == "tambah"){ ?>
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Berhasil</h5>
            Data sudah ditambahkan.
          </div>
        <?php } else if($alert == "hapus"){ ?>
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Berhasil</h5>
            Data sudah dihapus.
          </div>
        <?php } else if($alert == "ubah"){ ?>
          <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Berhasil</h5>
            Data sudah diubah.
          </div>
          <?php } ?>

        <div class="row">
          <!-- /.col-md-6 -->
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h5 class="m-0">Perangkat Terdaftar</h5>
              </div>
              <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Device ID</th>
                    <th>Train ID</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php while($row = mysqli_fetch_array($result)){  ?>
                    <tr>
                      <td><?php echo $row['device_id'] ?></td>
                      <td><?php echo $row['train_name'] ?></td>
                      <td><a href="?hal=perangkat_ubah&ubah=<?php echo $row['device_id'] ?>" class="btn btn-warning">Ubah</a> <a href="?hal=perangkat&hapus=<?php echo $row['device_id'] ?>" class="btn btn-danger">Hapus</a></td>
                    </tr>
                  <?php } ?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Device ID</th>
                    <th>Train ID</th>
                    <th></th>
                  </tr>
                  </tfoot>
                </table>
                
              </div>
            </div>
          <!-- FORM TAMBAH / EDIT -->
          <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Tambah Perangkat Baru</h5>
              </div>
              <form method="POST" action="?hal=perangkat">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="device_id">Device ID</label>
                      <input type="text" class="form-control"  name="device_id" placeholder="Masukkan Device ID">
                    </div>
                    <div class="form-group">
                      <label for="train_name">Train Name</label>
                      <input type="text" class="form-control"  name="train_name" placeholder="Masukkan Nama Kereta">
                    </div>
                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary" name="tambah">Tambah</button>
                  </div>
                </form>
              
          </div>
        </div>
      </div>
</div>
    
</div>
</div>