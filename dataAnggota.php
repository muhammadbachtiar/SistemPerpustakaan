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

$title = 'Sistem Peprustakaan Digital - Data Anggota';

include 'layout/header.php';

// check apakah tombol tambah ditekan
if (isset($_POST['tambah'])) {
    if (add_anggota($_POST) > 0) {
        echo "<script>
                alert('Data Berhasil Ditambahkan');
                document.location.href = 'dataAnggota.php';
              </script>";
    }elseif (add_anggota($_POST) == 0) {
        echo "<script>
                    alert('ID Anggota sudah ada');
                    document.location.href = 'dataAnggota.php';
                  </script>";
    }else {
        echo "<script>
                alert('Data Gagal Ditambahkan');
                document.location.href = 'dataAnggota.php';
              </script>";
    }
}

// check apakah ubah hapus ditekan
if (isset($_POST['ubah'])) {
    if (update_anggota($_POST) > 0) {
        echo "<script>
                alert('Data Berhasil Diubah');
                document.location.href = 'dataAnggota.php';
              </script>";
    }else {
        echo "<script>
                alert('Data Gagal Diubah');
                document.location.href = 'dataAnggota.php';
              </script>";
    }
}

// check apakah tombol hapus ditekan
if (isset($_POST['hapus'])) {
    if (delete_anggota($_POST) > 0) {
        echo "<script>
                alert('Data Berhasil Dihapus');
                document.location.href = 'dataAnggota.php';
              </script>";
    }else {
        echo "<script>
                alert('Data Gagal Dihapus');
                document.location.href = 'dataAnggota.php';
              </script>";
    }
}

$dataAnggota = select("SELECT * FROM dataanggota ORDER BY idDataAnggota DESC;");

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
            <h1 class="h3 mb-2 text-gray-800">Halaman Data Anggota</h1>
            <p class="mb-4">Daftar data anggota yang terdaftar pada Sistem Perpustakaan Digital.</p>
        </div>
        <div>
            <a href="#" class="btn btn-success btn-icon-split btn-sm" data-toggle="modal" data-target="#tambahAnggota">
                <span class="icon">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah Data Anggota</span>
            </a>
            <a target="_blank" href="cetakDataAnggota.php" class="btn btn-info btn-icon-split btn-sm">
                <span class="icon">
                    <i class="fas fa-print"></i>
                </span>
                <span class="text">Cetak Data Anggota</span>
            </a>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card border-bottom-primary shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Anggota</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Anggota</th>
                            <th>Nama</th>
                            <th>Foto Profile</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>ID Anggota</th>
                            <th>Nama</th>
                            <th>Foto Profile</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($dataAnggota as $anggota) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $anggota['idAnggota']; ?></td>
                                <td><?= $anggota['nama']; ?></td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#profile<?= $anggota['idDataAnggota']; ?>">
                                        <?= $anggota['foto']; ?>
                                    </a>
                                </td>
                                <td><?= $anggota['jenisKelamin']; ?></td>
                                <td><?= $anggota['alamat']; ?></td>
                                <td>
                                    <a target="_blank" href="cetakKartuAnggota.php?id=<?= $anggota['idDataAnggota']; ?>" class="btn btn-info btn-icon-split btn-sm">
                                        <span class="icon">
                                            <i class="fas fa-print"></i>
                                        </span>
                                    </a>
                                    <a href="#" class="btn btn-success btn-icon-split btn-sm" data-toggle="modal" data-target="#ubahAnggota<?= $anggota['idDataAnggota']; ?>">
                                        <span class="icon">
                                            <i class="fas fa-pen"></i>
                                        </span>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-icon-split btn-sm" data-toggle="modal" data-target="#hapusAnggota<?= $anggota['idDataAnggota']; ?>">
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

<!-- Tambah Anggota Modal -->
<div class="modal fade" id="tambahAnggota" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Anggota </h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="user" action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="IdAnggota" name="IdAnggota" placeholder="ID Anggota" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="NamaAnggota" name="NamaAnggota" placeholder="Nama Anggota" required>
                    </div>
                    <div class="form-group">
                        <label for="jenisKelamin" class="form-label">Jenis Kelamin</label>
                        <select name="jenisKelamin" id="jenisKelamin" class="form-control action" required>
                            <option value="Pria">Pria</option>
                            <option value="Wanita">Wanita</option>
                        </select>
                    </div>
                    <p id="fileErrorMessage" style="color: red;"></p>
                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input form-control-user" id="FotoAnggota" name="FotoAnggota" onchange="validateFile()" required>
                            <label class="custom-file-label" for="FotoAnggota">Pilih file Foto Anggota</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" style="height:calc(8.25rem + 2px);" id="AlamatAnggota" name="AlamatAnggota" placeholder="Alamat Anggota" required></textarea>
                    </div>
                    <hr>
                    <button type="submit" name="tambah" class="btn btn-success btn-user btn-block"><b>Submit</b></button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName);
    });
});

function validateFile() {
        // Mendapatkan file yang dipilih pada input
        var fileInput = document.getElementById('FotoAnggota');
        var file = fileInput.files[0];

        // Mengecek ekstensi file
        var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
        if (!allowedExtensions.exec(file.name)) {
            document.getElementById('fileErrorMessage').innerHTML = 'File yang dipilih bukan dalam format JPG, JPEG, atau PNG.';
            fileInput.value = ''; // Mengosongkan input file
        } else {
            document.getElementById('fileErrorMessage').innerHTML = '';
        }
    }
</script>


<?php foreach ($dataAnggota as $anggota) : ?>

    <!-- Detail Profile Modal-->
    <div class="modal fade" id="profile<?= $anggota['idDataAnggota']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Foto Profile </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="p-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="text-center">
                                    <p class="h5 text-gray-900 mb-4">Nama Anggota : <?= $anggota['nama']; ?> </p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <img src="file/img/<?= $anggota['foto']; ?>" alt="gambar profile anggota <?= $anggota['nama']; ?> " class="gambar-perpustakaan">
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

    <!-- Ubah Anggota Modal -->
    <div class="modal fade" id="ubahAnggota<?= $anggota['idDataAnggota']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Anggota </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="p-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="text-center">
                                    <p class="h5 text-gray-900 mb-4">ID Anggota : <?= $anggota['idAnggota']; ?> </p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <img id="gambarAnggota<?= $anggota['idDataAnggota']; ?>" src="file/img/<?= $anggota['foto']; ?>" alt="gambar profile anggota <?= $anggota['nama']; ?> " class="gambar-perpustakaan">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <form class="user" action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="NamaAnggota" name="NamaAnggota" placeholder="Nama Anggota" value="<?= $anggota['nama']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="jenisKelamin" class="form-label">Jenis Kelamin</label>
                            <select name="jenisKelamin" id="jenisKelamin" class="form-control action" required>
                                <option value="Pria" <?= $anggota['jenisKelamin'] == 'Pria' ? 'selected' : '' ?>>Pria</option>
                                <option value="Wanita" <?= $anggota['jenisKelamin'] == 'Wanita' ? 'selected' : '' ?>>Wanita</option>
                            </select>
                        </div>
                        <p id="fileErrorMessage<?= $anggota['idDataAnggota']; ?>" style="color: red;"></p>
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input form-control-user" id="FotoAnggota<?= $anggota['idDataAnggota']; ?>" name="FotoAnggota" onchange="validateFile<?= $anggota['idDataAnggota']; ?>(); updateGambar<?= $anggota['idDataAnggota']; ?>(this);">
                                <label class="custom-file-label scriptgetter<?= $anggota['idDataAnggota']; ?>" for="FotoAnggota"><?= $anggota['foto']; ?></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" style="height:calc(8.25rem + 2px);" id="AlamatAnggota" name="AlamatAnggota" placeholder="Alamat Anggota" required><?= $anggota['alamat']; ?></textarea>
                        </div>
                        <input type="hidden" type="number" id="idDataAnggota" name="idDataAnggota" value="<?php echo $anggota['idDataAnggota']; ?>" required readonly>
                            <input type="hidden" id="profileBefore" name="profileBefore" value="<?php echo $anggota['foto']; ?>" required readonly>
                        <hr>
                        <button type="ubah" name="ubah" class="btn btn-success btn-user btn-block"><b>Submit</b></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('.scriptgetter<?= $anggota['idDataAnggota']; ?>').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.scriptgetter<?= $anggota['idDataAnggota']; ?>').html(fileName);
        });
    });

    function validateFile<?= $anggota['idDataAnggota']; ?>() {
            // Mendapatkan file yang dipilih pada input
            var fileInput = document.getElementById('FotoAnggota<?= $anggota['idDataAnggota']; ?>');
            var file = fileInput.files[0];

            // Mengecek ekstensi file
            var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
            if (!allowedExtensions.exec(file.name)) {
                document.getElementById('fileErrorMessage<?= $anggota['idDataAnggota']; ?>').innerHTML = 'File yang dipilih bukan dalam format JPG, JPEG, atau PNG.';
                fileInput.value = ''; // Mengosongkan input file
            } else {
                document.getElementById('fileErrorMessage<?= $anggota['idDataAnggota']; ?>').innerHTML = '';
            }
        }

    function updateGambar<?= $anggota['idDataAnggota']; ?>(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#gambarAnggota<?= $anggota['idDataAnggota']; ?>').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>

    <!-- Hapus Anggota Modal-->
    <div class="modal fade" id="hapusAnggota<?= $anggota['idDataAnggota']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Yakin ingin menghapus data Anggota? </h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Setelah klik tombol Hapus data anggota <?= $anggota['nama']; ?> akan dihapus dari daftar
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" type="button" data-dismiss="modal">Cancel</button>
                        <form class="user" action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" type="number" id="idDataAnggota" name="idDataAnggota" value="<?php echo $anggota['idDataAnggota']; ?>" required readonly>
                            <input type="hidden" id="profileBefore" name="profileBefore" value="<?php echo $anggota['foto']; ?>" required readonly>
                            <button type="submit" name="hapus" class="btn btn-danger"><b>Hapus</b></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<?php endforeach; ?>


