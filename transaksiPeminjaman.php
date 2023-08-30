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

$title = 'Sistem Peprustakaan Digital - Transaksi Peminjaman';

include 'layout/header.php';

// check apakah tombol tambah ditekan
if (isset($_POST['tambah'])) {
    if (add_Peminjaman($_POST) > 0) {
        echo "<script>
                alert('Data Berhasil Ditambahkan');
                document.location.href = 'transaksiPeminjaman.php';
              </script>";
    }elseif (add_Peminjaman($_POST) == 0) {
        echo "<script>
                    alert('ID Transaksi sudah ada');
                    document.location.href = 'transaksiPeminjaman.php';
                  </script>";
    }else {
        echo "<script>
                alert('Data Gagal Ditambahkan');
                document.location.href = 'transaksiPeminjaman.php';
              </script>";
    }
}

// check apakah tombol return ditekan
if (isset($_POST['return'])) {
    if (return_buku($_POST) > 0) {
        echo "<script>
                alert('Transaksi Pengembalian berhasil ditambahkan');
                document.location.href = 'transaksiPeminjaman.php';
              </script>";
    }else {
        echo "<script>
                alert('Transaksi Pengembalian gagal ditambahkan');
                document.location.href = 'transaksiPeminjaman.php';
              </script>";
    }
}

$dataBuku = select("SELECT * FROM databuku ORDER BY idBuku DESC;");
$dataPeminjam = select("SELECT * FROM dataanggota ORDER BY idDataAnggota DESC;");
$dataPeminjaman = select("SELECT laporantranskasi.*, dataanggota.idAnggota as anggotaID, dataanggota.nama, databuku.judul 
                            FROM laporantranskasi 
                            JOIN dataanggota ON laporantranskasi.idAnggota = dataanggota.idDataAnggota 
                            JOIN databuku ON laporantranskasi.idBuku = databuku.idBuku 
                            ORDER BY laporantranskasi.statusPengembalian ASC;");
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
            <h1 class="h3 mb-2 text-gray-800">Halaman Trantsaksi Peminjaman</h1>
            <p class="mb-4">Daftar data transaksi peminjaman buku pada Sistem Perpustakaan Digital.</p>
        </div>
        <div>
            <a href="#" class="btn btn-success btn-icon-split btn-sm" data-toggle="modal" data-target="#tambahPeminjaman">
                <span class="icon">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Transaksi Baru</span>
            </a>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card border-bottom-primary shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Peminjaman</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Transaksi</th>
                            <th>ID Anggota</th>
                            <th>Nama</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Status Peminjaman</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>ID Transaksi</th>
                            <th>ID Anggota</th>
                            <th>Nama</th>
                            <th>Judul Buku</th>
                            <th>Waktu Pinjam</th>
                            <th>Status Peminjaman</th>
                            <th>Aksi</th>
                        </tr>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($dataPeminjaman as $peminjaman) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $peminjaman['idTransaksi']; ?></td>
                                <td><?= $peminjaman['anggotaID']; ?></td>
                                <td><?= $peminjaman['nama']; ?></td>
                                <td><?= $peminjaman['judul']; ?></td>
                                <td><?= $peminjaman['waktuPeminjaman']; ?></td>
                                <td style="color: <?php echo ($peminjaman['statusPengembalian'] == 0) ? '#FFA500' : '#008000'; ?>">
                                    <?php if($peminjaman['statusPengembalian'] == 0) :?>
                                    Berlangsung
                                    <?php else :?>
                                    Selesai
                                    <?php endif ;?>
                                </td>
                                <td>
                                <div>
                                    <a target="_blank" href="cetakNotaPeminjaman.php?id=<?= $peminjaman['id_transaksi']; ?>" class="btn btn-info btn-icon-split btn-sm">
                                        <span class="icon">
                                            <i class="fas fa-print"></i>
                                        </span>
                                        <span class="text">Nota Peminjaman</span>
                                    </a>
                                    <?php if($peminjaman['statusPengembalian'] == 0) :?>
                                        <a href="#" class="btn btn-success btn-icon-split btn-sm" data-toggle="modal" data-target="#kembaliBuku<?= $peminjaman['id_transaksi']; ?>">
                                            <span class="icon">
                                                <i class="fas fa-backward"></i>
                                            </span>
                                            <span class="text">Pengembalian</span>
                                        </a>
                                    <?php endif ;?>
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

<!-- Tambah Peminjaman Modal -->
<div class="modal fade" id="tambahPeminjaman" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Transaksi Peminjaman</h5>
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

<?php foreach ($dataPeminjaman as $peminjaman) : ?>

<!-- Pengembalian Buku Modal-->
<div class="modal fade" id="kembaliBuku<?= $peminjaman['id_transaksi']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yakin ingin melakukan transaksi pengembalian? </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Setelah klik tombol "Kembalikan"  data transaksi peminjaman <?= $peminjaman['idTransaksi']; ?> akan dimasukan ke transaksi pengembalian
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" data-dismiss="modal">Cancel</button>
                    <form class="user" action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" type="number" id="id_transaksi" name="id_transaksi" value="<?php echo $peminjaman['id_transaksi']; ?>" required readonly>
                        <button type="submit" name="return" class="btn btn-primary"><b>Kembalikan</b></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php endforeach; ?>
