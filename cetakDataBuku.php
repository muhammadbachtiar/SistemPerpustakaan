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

    $dataBuku = select("SELECT * FROM databuku ORDER BY idBuku DESC;");
?>

<!DOCTYPE html>
<html>

<head>
	<title> Sistem Perpustakaan Digital - Cetak Buku </title>
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
            <div class="col-12">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="text-xl font-weight-bold text-primary text-uppercase text-center mb-1">
                                    Data Buku</div>
                                    <div class="text-xl font-weight-bold text-primary text-uppercase text-center mb-1">
                                    Sistem Perpustakaan Digital</div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul Buku</th>
                                        <th>Penulis</th>
                                        <th>Penerbit</th>
                                        <th>Tahun Terbit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($dataBuku as $buku) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $buku['judul']; ?></td>
                                            <td><?= $buku['penulis']; ?></td>
                                            <td><?= $buku['penerbit']; ?></td>
                                            <td><?= $buku['tahunTerbit']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>