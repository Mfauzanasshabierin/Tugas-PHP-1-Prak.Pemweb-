<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "data_mahasiswa";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $conn->real_escape_string($_POST['nama']);
    $nim = $conn->real_escape_string($_POST['nim']);
    $prodi = $conn->real_escape_string($_POST['prodi']);

    if (!empty($nama) && !empty($nim) && !empty($prodi)) {
        $insertQuery = "INSERT INTO mahasiswa (nama, nim, prodi) VALUES ('$nama', '$nim', '$prodi')";
        if ($conn->query($insertQuery) === TRUE) {
            echo "<script>alert('Data berhasil ditambahkan!');</script>";
        } else {
            echo "<script>alert('Gagal menambahkan data.');</script>";
        }
    } else {
        echo "<script>alert('Semua kolom harus diisi!');</script>";
    }
}

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

$query = "SELECT * FROM mahasiswa LIMIT $start, $limit";
$result = $conn->query($query);

$countQuery = "SELECT COUNT(*) AS total FROM mahasiswa";
$countResult = $conn->query($countQuery);
$totalRows = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $limit);

// HTML & CSS
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            padding: 20px 0;
            color: #007BFF;
        }
        .form-container {
            width: 90%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .form-container input[type="text"] {
            width: calc(33% - 20px);
            margin: 0 10px 10px 0;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-container input[type="submit"] {
            padding: 10px 20px;
            color: white;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .form-container input[type="submit"]:hover {
            background-color: #0056b3;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th {
            background-color: #007BFF;
            color: white;
            padding: 12px;
            text-align: center;
        }
        td {
            padding: 10px;
            text-align: center;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #eaf4ff;
        }
        .pagination {
            text-align: center;
            margin: 20px 0;
        }
        .pagination a {
            display: inline-block;
            margin: 0 5px;
            padding: 10px 15px;
            color: white;
            background-color: #007BFF;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .pagination a.active, .pagination a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Data Mahasiswa</h1>
    <div class="form-container">
        <form method="POST" action="">
            <input type="text" name="nama" placeholder="Nama Mahasiswa" required>
            <input type="text" name="nim" placeholder="NIM Mahasiswa" required>
            <input type="text" name="prodi" placeholder="Program Studi" required>
            <input type="submit" value="Tambah">
        </form>
    </div>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>NIM</th>
                <th>Prodi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['nama']}</td>
                        <td>{$row['nim']}</td>
                        <td>{$row['prodi']}</td>
                    </tr>";
                }
            }
            $emptyRows = $limit - $result->num_rows;
            for ($i = 0; $i < $emptyRows; $i++) {
                echo "<tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
    <div class="pagination">
        <?php
        if ($page > 1) {
            echo "<a href='?page=" . ($page - 1) . "'>Previous</a>";
        }
        for ($i = 1; $i <= $totalPages; $i++) {
            $active = $i == $page ? "class='active'" : "";
            echo "<a href='?page=$i' $active>$i</a>";
        }
        if ($page < $totalPages) {
            echo "<a href='?page=" . ($page + 1) . "'>Next</a>";
        }
        ?>
    </div>
</body>
</html>
<?php
$conn->close();
?>