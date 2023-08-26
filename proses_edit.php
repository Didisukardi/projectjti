<?php
include('koneksi.php');
$id = $_POST['id'];
$Petugas = $_POST['Petugas'];
$Kode_Error = $_POST['Kode_Error'];
$Deskripsi = $_POST['Deskripsi'];
$No_Tiket = $_POST['No_Tiket'];
$waktu = $_POST['Jam']; // Ini diasumsikan sebagai input datetime
// Format waktu ke format MySQL (YYYY-MM-DD HH:MI:SS)
$waktu_mysql = date("Y-m-d H:i:s", strtotime($waktu));

$Berkas = $_FILES['Berkas']['name'];
if ($Berkas != "") {
    $ekstensi_diperbolehkan = array('png', 'jpg', 'rar', 'zip');
    $x = explode('.', $Berkas);
    $ekstensi = strtolower(end($x));
    $file_tmp = $_FILES['Berkas']['tmp_name'];
    $angka_acak = rand(1, 999);
    $nama_berkas_baru = $angka_acak . '-' . $Berkas;

    if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {

        move_uploaded_file($file_tmp, 'berkas/' . $nama_berkas_baru);
        $query = "UPDATE laporan SET Petugas= '$Petugas', Kode_Error='$Kode_Error', Deskripsi='$Deskripsi', No_Tiket='$No_Tiket', jam='$waktu_mysql', Berkas='$nama_berkas_baru' ";
        $query .= "WHERE id='$id'";
        $result = mysqli_query($koneksi, $query);

        if (!$result) {
            die("Query Error:" . mysqli_errno($koneksi) . "-" . mysqli_error($koneksi));
        } else {
            echo "<script>alert('Data Berhasil diubah');window.location='Utama.php';</script>";
        }
    } else {

        echo "<script>alert('ekstensi hanya bisa jpg, png, rar, zip!');window.location='edit_berkas.php';</script>";
    }
} else {
    $query = "UPDATE laporan SET Petugas= '$Petugas', Kode_Error='$Kode_Error', Deskripsi='$Deskripsi', No_Tiket='$No_Tiket', jam='$waktu_mysql' ";
    $query .= "WHERE id='$id'";
    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        die("Query Error:" . mysqli_errno($koneksi) . "-" . mysqli_error($koneksi));
    } else {
        echo "<script>alert('Anda tidak Merubah Berkas');window.location='Utama.php';</script>";
    }
}
?>
