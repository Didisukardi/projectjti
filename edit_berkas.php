<?php include('koneksi.php');
if(isset($_GET['id'])){
    $id= $_GET['id'];
    $query="SELECT * FROM laporan where id ='$id'";
    $result= mysqli_query($koneksi,$query);
    if(!$result){
        die('Query Error:'.mysqli.errno($koneksi)." - ".mysqli_error($koneksi));
    }
    $data = mysqli_fetch_assoc($result);

    if(!count($data)){
        echo"<script>alert('Data Tidak ditemukan pada tabel.');window.location='Utama.php';</script>";

    }

}else{
    echo"<script>alert('Masukkan ID yang ingin di Edit');window.location='Utama.php';</script>";
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Engineer</title>
      <style type="text/css">
        *{
            font-family:"Trebuchet Ms";
        }
        h1{
            text-transform:uppercase;
            color:salmon;
        }
        .base{
            width:400px;
            padding:20px;
            margin-left:auto;
            margin-right:auto;
            background-color: #ededed;
        }
        label{
            margin-top:10px;
            float:left;
            text-align:left;
            width:100%;
        }
        input{
            padding:6px;
            width:100%;
            box-sizing:border-box;
            background-color:#f8f8f8;
            border:2px solid #ccc;
            outline-color:salmon;
        }
        button{
            background-color:salmon;
            color:#fff;
            padding:10px;
            font-size:12px;
            border:0;
            margin-top:20px;
        }
        .download-link {
    background-color: #4CAF50;
    color: white;
    padding: 8px 16px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    border-radius: 5px;
    font-size: 14px;
    }

    .download-icon {
    font-size: 20px;
    margin-right: 5px;
    }


      </style>
</head>
<body>
    <center><h1>Edit Problem <?php echo $data ['Petugas'] ;?></h1></center>
    <form method="POST" action="proses_edit.php" enctype="multipart/form-data">
<section class="base">
        <div>
            <label>Petugas</label>
            <input type="text" name="Petugas" autofocus="" required="" value="<?php echo $data ['Petugas'] ;?>" />
            <input type="hidden" name="id" value="<?php echo $data ['id'];?>"/>
        </div>
        <div>
            <label>Kode Error</label>
            <input type="text" name="Kode_Error" value="<?php echo $data ['Kode_Error'] ;?>" />
        </div>
        <div>
            <label>Deskripsi</label>
            <input type="text" name="Deskripsi" required="" value="<?php echo $data ['Deskripsi'] ;?>" />
        </div>

        <div>
            <labe>No Tiket</label>
            <input type="text" name="No_Tiket" required="" value="<?php echo $data ['No_Tiket'] ;?>" />
        </div>

        <div>
            <label>Jam</label>
            <input type="datetime-local" name="Jam" required=""  value="<?php echo $data ['Jam'] ;?>" />
        </div>

        <div>
            <labe>Berkas</label>
            <input type="file" name="Berkas" value="<?php echo $data ['Berkas'] ;?>" />
                    <?php
    // Tampilkan nama file yang tersimpan di database jika tersedia
    if (!empty($data['Berkas'])) {
        echo '<a href="berkas/' . $data['Berkas'] . '" download class="download-link">';
        echo '<span class="download-icon">⬇️</span> ' . $data['Berkas'] . '</a>';
    } else {
        echo '<i style="font-size: 11px; color: red;">Tidak ada berkas yang terkait.</i>';
    }
    ?>
            
            <i style="floa:left;font-size:11px;color:red;">Abaikan jika tidak ingin merubah berkas anda</i>
        </div>
        <div>
            <br>
            <button type="submit">Simpan Perubahan</button>
        </div>
</section>
</form>

</body>
</html>

