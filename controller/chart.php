<?php
setlocale(LC_TIME, 'id_ID.utf8');
// Koneksi ke database
$host = "localhost";
$username = "root";
$password = "";
$database = "foodcourt";
$conn = new mysqli($host, $username, $password, $database);

// Query SQL
$sql = "SELECT DATE(waktu_bayar) as tanggal, SUM(total_harga) as total_penjualan
                FROM keranjang
                WHERE waktu_bayar >= CURDATE() - INTERVAL 6 DAY AND status = 5
                GROUP BY DATE(waktu_bayar)
                ORDER BY tanggal ASC
                ";

$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        'tanggal' => $row['tanggal'],
        'total_penjualan' => $row['total_penjualan']
    ];
}

// Tutup koneksi
$conn->close();

// Mengirim data ke JavaScript
echo json_encode($data);
