<?php

session_start();

// membatasi halaman sebelum login
if (!isset($_SESSION["login"])) {
  echo "<script>
            alert('Silahkan Login Terlebih Dahulu');
            document.location.href = 'login.php';
          </script>";
  exit;
}

$title = 'Sistem Peprustakaan Digital - Data Buku';

include 'layout/header.php';

// check apakah tombol tambah ditekan
if (isset($_POST['tambah'])) {
    if (add_buku($_POST) > 0) {
        echo "<script>
                alert('Data Berhasil Ditambahkan');
                document.location.href = 'dataBuku.php';
              </script>";
    }elseif (add_buku($_POST) == 0) {
        echo "<script>
                    alert('ID Anggota sudah ada');
                    document.location.href = 'dataBuku.php';
                  </script>";
    }else {
        echo "<script>
                alert('Data Gagal Ditambahkan');
                document.location.href = 'dataBuku.php';
              </script>";
    }
}

// check apakah ubah hapus ditekan
if (isset($_POST['ubah'])) {
    if (update_buku($_POST) > 0) {
        echo "<script>
                alert('Data Berhasil Diubah');
                document.location.href = 'dataBuku.php';
              </script>";
    }else {
        echo "<script>
                alert('Data Gagal Diubah');
                document.location.href = 'dataBuku.php';
              </script>";
    }
}

// check apakah tombol hapus ditekan
if (isset($_POST['hapus'])) {
    if (delete_buku($_POST) > 0) {
        echo "<script>
                alert('Data Berhasil Dihapus');
                document.location.href = 'dataBuku.php';
              </script>";
    }else {
        echo "<script>
                alert('Data Gagal Dihapus');
                document.location.href = 'dataBuku.php';
              </script>";
    }
}

$dataBuku = select("SELECT * FROM databuku ORDER BY idBuku DESC;");

?>

<!-- Main Content -->
<div id="content">

<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

<!-- Sidebar Toggle (Topbar) -->
<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
</button>

<!-- Topbar Navbar -->
<ul class="navbar-nav ml-auto">

    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
    <li class="nav-item dropdown no-arrow d-sm-none">
        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-search fa-fw"></i>
        </a>
        <!-- Dropdown - Messages -->
        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
            aria-labelledby="searchDropdown">
            <form class="form-inline mr-auto w-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small"
                        placeholder="Search for..." aria-label="Search"
                        aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </li>

    <div class="topbar-divider d-none d-sm-block"></div>

    <!-- Nav Item - User Information -->
    <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['nama'] ?></span>
            <img class="img-profile rounded-circle"
                src="assets/img/undraw_profile.svg">
        </a>
    </li>

</ul>

</nav>
<!-- End of Topbar -->

<!-- Begin Page Content -->
<div class="container-fluid">

     <!-- Page Heading -->
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-2 text-gray-800">Halaman Data Buku</h1>
            <p class="mb-4">Daftar data buku yang tersedia pada Sistem Perpustakaan Digital.</p>
        </div>
        <div>
            <a href="#" class="btn btn-success btn-icon-split btn-sm" data-toggle="modal" data-target="#tambahBuku">
                <span class="icon">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah Data Buku</span>
            </a>
            <a target="_blank" href="cetakDataBuku.php" class="btn btn-info btn-icon-split btn-sm">
                <span class="icon">
                    <i class="fas fa-print"></i>
                </span>
                <span class="text">Cetak Data Buku</span>
            </a>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card border-bottom-primary shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Buku</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Buku</th>
                            <th>Penulis</th>
                            <th>Penerbit</th>
                            <th>Tahun Terbit</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Judul Buku</th>
                            <th>Penulis</th>
                            <th>Penerbit</th>
                            <th>Tahun Terbit</th>
                            <th>Aksi</th>
                        </tr>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($dataBuku as $buku) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $buku['judul']; ?></td>
                                <td><?= $buku['penulis']; ?></td>
                                <td><?= $buku['penerbit']; ?></td>
                                <td><?= $buku['tahunTerbit']; ?></td>
                                <td>
                                    <a href="#" class="btn btn-success btn-icon-split btn-sm" data-toggle="modal" data-target="#ubahBuku<?= $buku['idBuku']; ?>">
                                        <span class="icon">
                                            <i class="fas fa-pen"></i>
                                        </span>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-icon-split btn-sm" data-toggle="modal" data-target="#hapusBuku<?= $buku['idBuku']; ?>">
                                        <span class="icon">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php include 'layout/footer.php'; ?>

<!-- Tambah Buku Modal -->
<div class="modal fade" id="tambahBuku" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Buku </h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="user" action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="judul" name="judul" placeholder="Judul Buku" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="penulis" name="penulis" placeholder="Penulis" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="penerbit" name="penerbit" placeholder="Penerbit" required>
                    </div>
                    <div class="form-group">
                        <input type="number" min="1000" max="3000" class="form-control form-control-user" id="tahunTerbit" name="tahunTerbit" placeholder="Tahun Terbit" required>
                    </div>
                    <hr>
                    <button type="submit" name="tambah" class="btn btn-success btn-user btn-block"><b>Submit</b></button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php foreach ($dataBuku as $buku) : ?>

<!-- Ubah Buku Modal -->
<div class="modal fade" id="ubahBuku<?= $buku['idBuku']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Buku </h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="user" action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="judul" name="judul" placeholder="Judul Buku" value="<?= $buku['judul']; ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="penulis" name="penulis" placeholder="Penulis" value="<?= $buku['penulis']; ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="penerbit" name="penerbit" placeholder="Penerbit" value="<?= $buku['penerbit']; ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="number" min="1000" max="3000" class="form-control form-control-user" id="tahunTerbit" name="tahunTerbit" placeholder="Tahun Terbit" value="<?= $buku['tahunTerbit']; ?>" required>
                    </div>
                    <input type="hidden" type="number" id="idBuku" name="idBuku" value="<?php echo $buku['idBuku']; ?>" required readonly>
                    <hr>
                    <button type="ubah" name="ubah" class="btn btn-success btn-user btn-block"><b>Submit</b></button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Hapus Buku Modal-->
<div class="modal fade" id="hapusBuku<?= $buku['idBuku']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yakin ingin menghapus data Buku? </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Setelah klik tombol Hapus data buku <?= $buku['judul']; ?> akan dihapus dari daftar
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" data-dismiss="modal">Cancel</button>
                    <form class="user" action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" type="number" id="idBuku" name="idBuku" value="<?php echo $buku['idBuku']; ?>" required readonly>
                        <button type="submit" name="hapus" class="btn btn-danger"><b>Hapus</b></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php endforeach; ?>
