<?php
date_default_timezone_set('Asia/Jakarta');

function select($query)
{
    // panggil koneksi database
    global $db;

    $result = mysqli_query($db, $query);
    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

function add_anggota($post)
{
    global $db;

    $IdAnggota              = strtoupper(strip_tags($post['IdAnggota']));
    $NamaAnggota            = strip_tags($post['NamaAnggota']);
    $jenisKelamin           = strip_tags($post['jenisKelamin']);
    $FotoAnggota            = upload_document("FotoAnggota");
    $AlamatAnggota          = strip_tags($post['AlamatAnggota']);

    //Pemeriksaan data yang diinput
    $checkQuery = "SELECT COUNT(*) as total FROM dataanggota WHERE idAnggota = '$IdAnggota'";
    $checkResult = mysqli_query($db, $checkQuery);
    $row = mysqli_fetch_assoc($checkResult);
    $totalData = $row['total'];

     // Cek jumlah data yang ditemukan
     if ($totalData > 0) {
    
        return mysqli_affected_rows($db) == 0;
            
    } else {

        // query tambah data
        $query = "INSERT INTO dataanggota VALUES(null, '$IdAnggota', '$FotoAnggota', '$NamaAnggota', '$jenisKelamin', '$AlamatAnggota')";
        mysqli_query($db, $query);

        return mysqli_affected_rows($db);
    }
}

function update_anggota($post)
{
    global $db;

    $idDataAnggota   = strip_tags($post['idDataAnggota']);
    $NamaAnggota   = strip_tags($post['NamaAnggota']);
    $jenisKelamin   = strip_tags($post['jenisKelamin']);
    $profileBefore   = strip_tags($post['profileBefore']);
    $AlamatAnggota   = strip_tags($post['AlamatAnggota']);

    $profile = getUploadedFile("FotoAnggota", $profileBefore);

    // query hapus data skor kondisi
    $query = "UPDATE dataanggota SET nama = '$NamaAnggota', foto = '$profile', jenisKelamin = '$jenisKelamin', alamat = '$AlamatAnggota' WHERE idDataAnggota = $idDataAnggota";
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

function delete_anggota($post)
{
    global $db;

    $idDataAnggota   = strip_tags($post['idDataAnggota']);
    $profileBefore   = strip_tags($post['profileBefore']);

    delete_document($profileBefore);

    // query hapus data skor kondisi
    $query = "DELETE FROM dataanggota WHERE idDataAnggota = $idDataAnggota";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

function add_buku($post)
{
    global $db;

    $judul            = strip_tags($post['judul']);
    $penulis          = strip_tags($post['penulis']);
    $penerbit         = strip_tags($post['penerbit']);
    $tahunTerbit      = strip_tags($post['tahunTerbit']);

    //Pemeriksaan data yang diinput
    $checkQuery = "SELECT COUNT(*) as total FROM databuku WHERE judul = '$penulis'";
    $checkResult = mysqli_query($db, $checkQuery);
    $row = mysqli_fetch_assoc($checkResult);
    $totalData = $row['total'];

     // Cek jumlah data yang ditemukan
     if ($totalData > 0) {
    
        return mysqli_affected_rows($db) == 0;
            
    } else {

        // query tambah data
        $query = "INSERT INTO databuku VALUES(null, '$judul', '$penulis', '$penerbit', '$tahunTerbit')";
        mysqli_query($db, $query);

        return mysqli_affected_rows($db);
    }
}

function update_buku($post)
{
    global $db;

    $idBuku           = strip_tags($post['idBuku']);
    $judul            = strip_tags($post['judul']);
    $penulis          = strip_tags($post['penulis']);
    $penerbit         = strip_tags($post['penerbit']);
    $tahunTerbit      = strip_tags($post['tahunTerbit']);


    // query hapus data skor kondisi
    $query = "UPDATE databuku SET judul = '$judul', penulis = '$penulis', penerbit = '$penerbit', tahunTerbit = '$tahunTerbit' WHERE idBuku = $idBuku";
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

function delete_buku($post)
{
    global $db;

    $idBuku           = strip_tags($post['idBuku']);

    // query hapus data skor kondisi
    $query = "DELETE FROM databuku WHERE idBuku = $idBuku";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}



function add_Peminjaman($post)
{
    global $db;

    $idTransaksi      = strtoupper(strip_tags($post['idTransaksi']));
    $idAnggota        = strip_tags($post['peminjam']);
    $idBuku           = strip_tags($post['buku']);
    $waktuPeminjaman  = strip_tags($post['waktuPinjam']);

    //Pemeriksaan data yang diinput
    $checkQuery = "SELECT COUNT(*) as total FROM laporantranskasi WHERE idTransaksi = '$idTransaksi'";
    $checkResult = mysqli_query($db, $checkQuery);
    $row = mysqli_fetch_assoc($checkResult);
    $totalData = $row['total'];

     // Cek jumlah data yang ditemukan
     if ($totalData > 0) {
    
        return mysqli_affected_rows($db) == 0;
            
    } else {

        // query tambah data
        $query = "INSERT INTO laporantranskasi VALUES(null, '$idTransaksi', '$idAnggota', '$idBuku', '$waktuPeminjaman', '', 0)";
        mysqli_query($db, $query);

        return mysqli_affected_rows($db);
    }
}

function return_buku($post)
{
    global $db;

    $id_transaksi           = strip_tags($post['id_transaksi']);
    $waktuPengembalian      = date('Y-m-d H:i:s');

    // query hapus data skor kondisi
    $query = "UPDATE laporantranskasi SET waktuPengembalian = '$waktuPengembalian', statusPengembalian = 1 WHERE id_transaksi = $id_transaksi";
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}



// fungsi mengupload foto Profile
function upload_document($attributename)
{
    $namaFile   = $_FILES[$attributename]['name'];
    $ukuranFile = $_FILES[$attributename]['size'];
    $error      = $_FILES[$attributename]['error'];
    $tmpName    = $_FILES[$attributename]['tmp_name'];

    if (!empty($_FILES[$attributename]['name'])) {
        // check ukuran file 2 MB
        if ($ukuranFile > 105500000) {
            // pesan gagal
            echo "<script>
                    alert('Ukuran File Max 2 MB');
                    document.location.href = 'index.php';
                </script>";
        }

        $file_name  = pathinfo($namaFile, PATHINFO_FILENAME);
        $file_ext   = pathinfo($namaFile, PATHINFO_EXTENSION);
        $timestamp  = time();

        // generate nama file baru
        $namaFileBaru = $file_name . '_' . $timestamp . '.' . $file_ext;

        // pindahkan ke folder local
        move_uploaded_file($tmpName, 'file/img/' . $namaFileBaru);
        return $namaFileBaru;
    } else {

        return '';
    }

}

// fungsi menghapus foto Profile
function delete_document($targetFile) {
    $filePath = 'file/img/' . $targetFile;

    if (file_exists($filePath)) {
        unlink($filePath);
    } 
}

function getUploadedFile($fieldName, $previousFile)
{
    if ($_FILES[$fieldName]['error'] == 4) {
        return $previousFile;
    } else {
        // Melakukan penghapusan file lama pada server
        if($previousFile != ''){
            delete_document($previousFile);
        }
        // Lakukan upload file dan kembalikan nama file yang diupload
        return upload_document($fieldName);
    }
}