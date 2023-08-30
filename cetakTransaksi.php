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

	include "config/app.php";

    $idPeminjaman   = $_GET['id'];
    $dataPeminjaman = select("SELECT laporantranskasi.*, dataanggota.idAnggota as anggotaID, dataanggota.nama, databuku.judul 
                                FROM laporantranskasi 
                                JOIN dataanggota ON laporantranskasi.idAnggota = dataanggota.idDataAnggota 
                                JOIN databuku ON laporantranskasi.idBuku = databuku.idBuku 
                                WHERE laporantranskasi.id_transaksi = '$idPeminjaman'")[0];
?>

<!DOCTYPE html>
<html>

<head>
	<title> Sistem Perpustakaan Digital - Cetak Nota Peminjaman </title>
    <!-- Custom fonts for this template-->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

	<style type="text/css">
		body {
			font-family: Arial;
		}

		@media print {
			.no-print {
				display: none;
			}
		}

		table {
			border-collapse: collapse;
		}

        .isiTabelCenter {
            padding: 5px; 
            border: 1px solid;
            text-align: center;
        }

        #logo {
            width: 100px;
            height: auto;
            border: 1px solid #ccc; 
            border-radius: 5px;
        }
	</style>
</head>
<center><strong><a href="#" class="no-print" onclick="window.print();">Cetak/Print</a></strong></center>
    <body>
    <div class="container-fluid">
        <div class="col-12">
            <div class="col-6">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <img id="logo" src="assets/img/perpustakaan.jpg">
                        </div>
                        <div class="col-9">
                            <div class="text-xl font-weight-bold text-primary text-uppercase text-center mb-1">
                                Laporan Transaksi</div>
                                <div class="text-xl font-weight-bold text-primary text-uppercase text-center mb-1">
                                Sistem Perpustakaan Digital</div>
                        </div>
                    </div>
                    <hr>
                    <div class="col-12">
                        <table class="table" id="dataTable" width="100%" cellspacing="0">
                            <tr>
                                <th>ID Transaksi</th>
                                <th><?= $dataPeminjaman['idTransaksi']; ?></th>
                            </tr>
                            <tr>
                                <th>ID Anggota</th>
                                <th><?= $dataPeminjaman['anggotaID']; ?></th>
                            </tr>
                            <tr>
                                <th>Nama </th>
                                <th><?= $dataPeminjaman['nama']; ?></th>
                            </tr>
                            <tr>
                                <th>Judul Buku</th>
                                <th><?= $dataPeminjaman['judul']; ?></th>
                            </tr>
                            <tr>
                                <th>Waktu Pinjam</th>
                                <th><?= $dataPeminjaman['waktuPeminjaman']; ?></th>
                            </tr>
                            <tr>
                                <th>Waktu Kembali</th>
                                <th><?= $dataPeminjaman['waktuPengembalian']; ?></th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>