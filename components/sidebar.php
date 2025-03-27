<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="dist/img/restek.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">RESTEK PIDS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
        <a href="#" class="d-block"><?php echo $_SESSION['nama_lengkap'] ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form --zz
      <div csssslass="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> -->
      <div class="col text-center mt-3 " style="width: auto">
        <p id="currentDate" style="margin:auto; color:#fff; font-size: 14px;"></p>
        <p id="waktu" style="margin:auto; color:#fff; font-size: 14px;"></p>
      </div>
        <hr style="border-color: gray"/>
      

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="?hal=dashboard" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?hal=train_log" class="nav-link">
              <!-- <i class="nav-icon fas fa-th"></i> -->
              <i class="nav-icon fas fa-map"></i>
              <p>
                Train Log
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?hal=parameter" class="nav-link">
              <!-- <i class="nav-icon fas fa-th"></i> -->
              <i class="nav-icon fas fa-database"></i>
              <p>
                Parameter
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?hal=grafik" class="nav-link">
              <i class="nav-icon fas fa-chart-line"></i>
              <p>
                Grafik
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?hal=perangkat" class="nav-link">
              <i class="nav-icon fas fa-puzzle-piece"></i>
              <p>
                Perangkat
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?hal=pengguna" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Pengguna
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Log out
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>


  <script>
          //timer
          var myVar = setInterval(myTimer ,1000);
          function myTimer() {
            var d = new Date();
            document.getElementById("waktu").innerHTML = d.toLocaleTimeString();
          }

          //date
          $(document).ready(() => {
            let month = [
              "Januari", "Febuari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            ],
            day = [
              "Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"
            ],
            date = new Date();
            date.setDate(date.getDate());
            $("#currentDate").html(
              `${day[date.getDay()]}<br>${
                month[date.getMonth()]
              } ${date.getDate()}, ${date.getFullYear()}`
            );
          });

      </script>