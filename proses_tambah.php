<?php
include ('koneksi.php');
ini_set("post_max_size", "7G");
ini_set("upload_max_filesize", "7G");
ini_set("max_execution_time", 0);

$Petugas=$_POST['Petugas'];
$Kode_Error=$_POST['Kode_Error'];
$Deskripsi=$_POST['Deskripsi'];
$No_Tiket=$_POST['No_Tiket'];
$waktu = $_POST['Jam']; // Ini diasumsikan sebagai input datetime
// Format waktu ke format MySQL (YYYY-MM-DD HH:MI:SS)
$waktu_mysql = date("Y-m-d H:i:s", strtotime($waktu));

$Berkas=$_FILES['Berkas']['name'];


if($Berkas !=""){
    $ekstensi_diperbolehkan= array('png','jpg','rar', 'zip');
    $x = explode('.', $Berkas);
    $ekstensi=strtolower(end($x));
    $file_tmp=$_FILES['Berkas']['tmp_name'];
    $angka_acak= rand(1,999);
    $nama_berkas_baru= $angka_acak.'-'.$Berkas;

    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){

      move_uploaded_file($file_tmp,'berkas/'.$nama_berkas_baru) ;
        $query = "INSERT INTO laporan (Petugas, Kode_Error, Deskripsi, No_Tiket, jam, Berkas) VALUES('$Petugas', '$Kode_Error', '$Deskripsi', '$No_Tiket', '$waktu_mysql', '$nama_berkas_baru')";
        $result = mysqli_query($koneksi, $query);
      
        if (!$result){
            die("query Error:".mysqli_errno($koneksi)."-".mysqli_error($koneksi));
        
        } else{
            echo"<script>alert('Data Berhasil ditambahkan!');window.location='Utama.php';</script>";
        }

    }else{
        
        echo "<script>alert('ekstensi gambar hanya bisa jpg, png, rar, zip!');window.location='tambah_Src.php';</script>";

    }
}else{
        
        $query = "INSERT INTO laporan (Petugas, Kode_Error, Deskripsi, No_Tiket, jam) VALUES ('$Petugas', '$Kode_Error', '$Deskripsi', '$No_Tiket', '$waktu_mysql')";
 
        $result= mysqli_query($koneksi, $query);

        if (!$result){
            die("Query Error:".mysqli_errno($koneksi)."-".mysqli_error($koneksi));
        } else{
            echo"<script>alert('Data Berhasil ditambahkan!');window.location='Utama.php';</script>";
        }
    }



    ?>


