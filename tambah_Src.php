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
        #progress-container {
            width: 100%;
            background-color: #f8f8f8;
            margin-top: 20px;
            padding: 5px;
            border: 1px solid #ccc;
            /* Ubah ini menjadi "block" agar progress bar terlihat */
            display: block;
        }

        #progress-bar {
            width: 0;
            height: 20px;
            background-color: salmon;
        }
     
</style>
</head>
<body>
    <center><h1>Tambah Koder Error</h1></center>
    <form method="POST" action="proses_tambah.php" enctype="multipart/form-data" id="upload-form">
        <section class="base">
            <div>        

            <label>Petugas</label>
            <input type="text" name="Petugas" autofocus="" required="" />
        </div>
        <div>
            <label>Kode Error</label>
            <input type="text" name="Kode_Error" required=""/>
        </div>
        <div>
            <label>Deskripsi</label>
            <input type="text" name="Deskripsi" required=""/>
        </div>
        <div>
            <label>No.Tiket</label>
            <input type="text" name="No_Tiket" required="" />
        </div>

        <div>
    <label>Jam</label>
    <input type="datetime-local" name="Jam" required="" />
</div>

        <div>
            <label>Berkas</label>
            <input type="file" name="Berkas" required="" />
        </div>
        <div id="progress-container">
    <div id="progress-bar">
        <span id="progress-percent">0%</span>
    </div>
    <button type="submit">Simpan</button>
</div>

               
        </section>
    </form>
    <script>
    // Fungsi untuk mengunggah file dengan AJAX
        function uploadFile() {
            var formData = new FormData(document.getElementById("upload-form"));
            var progressBar = document.getElementById("progress-bar");
            var progressContainer = document.getElementById("progress-container");
            var progressPercent = document.getElementById("progress-percent");
            var xhr = new XMLHttpRequest();

            xhr.open("POST", "proses_tambah.php", true);
            xhr.upload.onprogress = function(event) {
                if (event.lengthComputable) {
                    var percentComplete = (event.loaded / event.total) * 100;
                    progressBar.style.width = percentComplete + "%";
                    progressPercent.innerText = Math.round(percentComplete) + "%"; // Perbarui teks persentase
                }
            };

            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Penanganan setelah pengunggahan selesai
                    alert("File berhasil diunggah!");
                    progressBar.style.width = "0%";
                    progressPercent.innerText = "0%"; // Reset teks persentase
                    // Sembunyikan progress bar kembali
                    progressContainer.style.display = "none";
                     // Arahkan pengguna ke halaman utama.php
                     window.location.href = "Utama.php";
                } else {
                    // Penanganan jika terjadi kesalahan
                    alert("Terjadi kesalahan saat mengunggah file.");
                }
            };

            xhr.send(formData);

            // Tampilkan progress bar
            progressContainer.style.display = "block";
        }

        // Tambahkan event listener untuk form submit
        document.getElementById("upload-form").addEventListener("submit", function(event) {
            event.preventDefault();
            uploadFile();
        });


        
    </script>
</body>
</html>