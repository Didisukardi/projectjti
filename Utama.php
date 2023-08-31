
<?php
include('koneksi.php');

$limit = 10; // Jumlah data yang ingin ditampilkan per halaman
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Mendapatkan nomor halaman dari URL

$start = ($page - 1) * $limit; // Hitung mulai data untuk query

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $query = "SELECT *, TIME_FORMAT(jam, '%H:%i') AS jam_format FROM laporan 
              WHERE Petugas LIKE '%$search%' OR Kode_Error LIKE '%$search%' OR Deskripsi LIKE '%$search%' OR No_Tiket LIKE '%$search%'
              ORDER BY id ASC LIMIT $start, $limit";
} else {
    $query = "SELECT *, TIME_FORMAT(jam, '%H:%i') AS jam_format FROM laporan ORDER BY id ASC LIMIT $start, $limit";
}

$result = mysqli_query($koneksi, $query);
if (!$result) {
    die("Query Error : " . mysqli_errno($koneksi) . " -" . mysqli_error($koneksi));
}
$no = $start + 1; // Nomor urut dimulai dari data pertama di halaman

$total_pages_query = "SELECT COUNT(*) as total FROM laporan";
$total_pages_result = mysqli_query($koneksi, $total_pages_query);
if ($total_pages_result) {
    $total_rows = mysqli_fetch_assoc($total_pages_result)['total'];
    $total_pages = ceil($total_rows / $limit); // Hitung total halaman
} else {
    $total_pages = 1; // Jika tidak ada data, set total halaman menjadi 1
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
    table{
      border:1px solid #ddeeee;
      border-collapse:collapse;
      border-spacing:0;
      width:70%;
      margin:10px auto 10px auto; 
    }
    table thead th{
      background-color:#ddefef;
      border:1px solid #ddeeee;
      color: #336b6b;
      padding:10px;
      text-align:left;
      text-shadow:1px 1px 1px #fff;
    }
    table tbody td{
      border:1px solid #ddeeee;
      color: #333;
      padding:12px;

    }
    a{
      background-color:salmon;
      color:#fff;
      padding:10px;
      font-size:12px;
      text-decoration:none;

    }
    .action-buttons {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.action-buttons a {
    margin-right: 10px;
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


    .edit-link {
      padding: 5px 10px;
      background-color: #337ab7;
      color: #fff;
      text-decoration: none;
    }

    .delete-link {
      padding: 5px 10px;
      background-color: #d9534f;
      color: #fff;
      text-decoration: none;
    }
    .logout-button {
    position: fixed;
    top: 10px; /* Adjust the top position as needed */
    right: 10px; /* Adjust the right position as needed */
}

.logout-button a {
    background-color: salmon;
    color: #fff;
    padding: 10px;
    font-size: 12px;
    text-decoration: none;
}
/* Style for the search form */
.search-form {
    text-align: right;
    margin-right: 20px;
}


    </style>
</head>
<body>
    <center><h1>List Problem</h1></center>
    <center><a href="tambah_Src.php">+ &nbsp; Tambah Problem</a></center>
    <br>
    <div class="search-form" style="margin-bottom: 20px;">
        <form method="GET" action="Utama.php">
            <input type="text" name="search" placeholder="Search...">
            <button type="submit">Search</button>
        </form>
    </div>
<div class="logout-button">
    <a href="logout.php">Logout</a>
</div>
    
    </form>

    <table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Petugas</th>
            <th>Kode Error</th>
            <th>Deskripsi</th>
            <th>No Tiket</th>
            <th>Jam</th>
            <th>Berkas</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td><?php echo $no ?></td>
                <td><?php echo substr($row['Petugas'], 0, 20); ?> </td>
                <td><?php echo $row['Kode_Error']; ?></td>
                <td><?php echo $row['Deskripsi']; ?></td>
                <td><?php echo $row['No_Tiket']; ?></td>
                <td><?php echo $row['Jam']; ?></td>

                <td>
                    <a href="Berkas/<?php echo $row['Berkas']; ?>" download class="download-link">
                        <span class="download-icon">⬇️</span> Download File
                    </a>
                </td>

                <td>
                    <div class="action-buttons">
                        <a href="edit_berkas.php?id=<?php echo $row['id']; ?>" class="edit-link">Edit</a>
                        <a href="proses_hapus.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Anda yakin ingin menghapus data ini?')" class="delete-link">Hapus</a>
                    </div>
                </td>
            </tr>
        <?php
            $no++;
        }
        ?>
    </tbody>
</table>


 <!-- Tampilkan navigasi halaman -->
 <div style="text-align: center;">
        <?php
        if ($total_pages > 1) {
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $page) {
                    echo "<span>$i</span>";
                } else {
                    echo "<a href='Utama.php?page=$i'>$i</a>";
                }
            }
        }
        ?>
    </div>
</body>
</html>
