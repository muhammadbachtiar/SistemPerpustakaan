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

$title = 'Sistem Peprustakaan Digital - Laporan Transaksi';

include 'layout/header.php';

// check apakah tombol tambah ditekan
if (isset($_POST['tambah'])) {
    if (add_Pengembalian($_POST) > 0) {
        echo "<script>
                alert('Data Berhasil Ditambahkan');
                document.location.href = 'transaksiPengembalian.php';
              </script>";
    }elseif (add_Pengembalian($_POST) == 0) {
        echo "<script>
                    alert('ID Transaksi sudah ada');
                    document.location.href = 'transaksiPengembalian.php';
                  </script>";
    }else {
        echo "<script>
                alert('Data Gagal Ditambahkan');
                document.location.href = 'transaksiPengembalian.php';
              </script>";
    }
}

// check apakah tombol return ditekan
if (isset($_POST['return'])) {
    if (return_buku($_POST) > 0) {
        echo "<script>
                alert('Transaksi Pengembalian berhasil ditambahkan');
                document.location.href = 'transaksiPengembalian.php';
              </script>";
    }else {
        echo "<script>
                alert('Transaksi Pengembalian gagal ditambahkan');
                document.location.href = 'transaksiPengembalian.php';
              </script>";
    }
}

$dataBuku = select("SELECT * FROM databuku ORDER BY idBuku DESC;");
$dataPeminjam = select("SELECT * FROM dataanggota ORDER BY idDataAnggota DESC;");
$dataPengembalian = select("SELECT laporantranskasi.*, dataanggota.*, dataanggota.idAnggota as IDAnggota, databuku.* 
                            FROM laporantranskasi 
                            JOIN dataanggota ON laporantranskasi.idAnggota = dataanggota.idDataAnggota 
                            JOIN databuku ON laporantranskasi.idBuku = databuku.idBuku 
                            WHERE laporantranskasi.statusPengembalian = 1
                            ORDER BY laporantranskasi.idTransaksi DESC;");
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
            <h1 class="h3 mb-2 text-gray-800">Halaman Laporan Transaksi</h1>
            <p class="mb-4">Daftar data laporan transaksi pada Sistem Perpustakaan Digital.</p>
        </div>
        <div>
            <a target="_blank" href="cetakLaporanTransaksi.php" class="btn btn-info btn-icon-split btn-sm">
                <span class="icon">
                    <i class="fas fa-print"></i>
                </span>
                <span class="text">Cetak Laporan Transaksi</span>
            </a>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card border-bottom-primary shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Transaksi</th>
                            <th>Nama</th>
                            <th>Judul Buku</th>
                            <th>Waktu Peminjaman</th>
                            <th>Tanggal Pengembalian</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>ID Transaksi</th>
                            <th>Nama</th>
                            <th>Judul Buku</th>
                            <th>Waktu Peminjaman</th>
                            <th>Waktu Pengembalian</th>
                            <th>Aksi</th>
                        </tr>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($dataPengembalian as $pengembalian) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $pengembalian['idTransaksi']; ?></td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#profile<?= $pengembalian['id_transaksi']; ?>">
                                        <?= $pengembalian['nama']; ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#detailBuku<?= $pengembalian['id_transaksi']; ?>">
                                        <?= $pengembalian['judul']; ?>
                                    </a>
                                </td>
                                <td><?= $pengembalian['waktuPeminjaman']; ?></td>
                                <td><?= $pengembalian['waktuPengembalian']; ?></td>
                                <td>
                                <div>
                                    <a target="_blank" href="cetakTransaksi.php?id=<?= $pengembalian['id_transaksi']; ?>" class="btn btn-info btn-icon-split btn-sm">
                                        <span class="icon">
                                            <i class="fas fa-print"></i>
                                        </span>
                                        <span class="text">Cetak Transaksi</span>
                                    </a>
                                </div>
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

<!-- Tambah Pengembalian Modal -->
<div class="modal fade" id="tambahPengembalian" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Transaksi Pengembalian</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="user" action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="idTransaksi" name="idTransaksi" placeholder="ID Transaksi" required>
                    </div>
                    <div class="form-group">
                        <label for="peminjam" class="form-label">Pilih Anggota Peminjam</label>
                        <select name="peminjam" id="peminjam" class="form-control">
                            <?php 
                            foreach ($dataPeminjam as $peminjam) : ?> 
                                <option value="<?= $peminjam['idDataAnggota']; ?>"><?= $peminjam['nama']; ?> (<?= $peminjam['idAnggota']; ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="buku" class="form-label">Pilih Buku yang dipinjam</label>
                        <select name="buku" id="buku" class="form-control">
                            <?php 
                            foreach ($dataBuku as $buku) : ?> 
                                <option value="<?= $buku['idBuku']; ?>"><?= $buku['judul']; ?> (<?= $buku['penulis']; ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="waktuPinjam" class="form-label">Waktu Pinjam</label>
                        <input type="datetime-local" class="form-control form-control-user" id="waktuPinjam" name="waktuPinjam" placeholder="Waktu Pinjam" required>
                    </div>
                    <hr>
                    <button type="submit" name="tambah" class="btn btn-success btn-user btn-block"><b>Submit</b></button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php foreach ($dataPengembalian as $pengembalian) : ?>

<!-- Detail Profile Modal-->
<div class="modal fade" id="profile<?= $pengembalian['id_transaksi']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Profile Anggota </h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="p-4">
                    <div class="row">
                        <div class="col-lg-12">
                            <img src="file/img/<?= $pengembalian['foto']; ?>" alt="gambar profile anggota <?= $pengembalian['nama']; ?> " class="gambar-perpustakaan">
                        </div>
                        <div class="col-lg-12">
                            <table class="table" id="dataTable" width="100%" cellspacing="0" style="margin-top: 5%;">
                                <tr>
                                    <th>ID Anggota</th>
                                    <th><?= $pengembalian['idAnggota']; ?></th>
                                </tr>
                                <tr>
                                    <th>Nama </th>
                                    <th><?= $pengembalian['nama']; ?></th>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin </th>
                                    <th><?= $pengembalian['jenisKelamin']; ?></th>
                                </tr>
                                <tr>
                                    <th>Alamat </th>
                                    <th><?= $pengembalian['alamat']; ?></th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Detail Buku Modal-->
<div class="modal fade" id="detailBuku<?= $pengembalian['id_transaksi']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Buku </h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="p-4">
                        <div class="col-lg-12">
                            <table class="table" id="dataTable" width="100%" cellspacing="0" style="margin-top: 5%;">
                                <tr>
                                    <th>Judul</th>
                                    <th><?= $pengembalian['judul']; ?></th>
                                </tr>
                                <tr>
                                    <th>Penulis</th>
                                    <th><?= $pengembalian['penulis']; ?></th>
                                </tr>
                                <tr>
                                    <th>Penerbit</th>
                                    <th><?= $pengembalian['penerbit']; ?></th>
                                </tr>
                                <tr>
                                    <th>Tahun terbit</th>
                                    <th><?= $pengembalian['tahunTerbit']; ?></th>
                                </tr>
                            </table>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php endforeach; ?>
