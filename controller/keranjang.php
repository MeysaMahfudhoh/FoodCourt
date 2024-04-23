<?php

namespace Midtrans;

use mysqli;

session_start();
include 'koneksi.php';


if (isset($_GET['id_keranjang']) && !empty($_GET['id_keranjang'])) {
    $id_keranjang = $conn->real_escape_string($_GET['id_keranjang']);
}

$query = "SELECT * FROM keranjang where id = $id_keranjang";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
$jenis = 'Dine In';

date_default_timezone_set('Asia/Jakarta');
$tanggal = date('Y-m-d H:i:s');
$update = "UPDATE keranjang SET status = 2 , waktu_bayar = '$tanggal', meja ='$id_keranjang', jenis='$jenis'  WHERE id = $id_keranjang";
$conn->query($update);

// var_dump($data['total_harga']);

// $id_keranjang = $data['id'];
$id_user = $data['id_user'];

$query2 = "SELECT * FROM user where id = $id_user";
$result2 = mysqli_query($conn, $query2);
$data2 = mysqli_fetch_assoc($result2);

$sql = "SELECT keranjang_detail.id, menu.nama_menu, keranjang_detail.total, keranjang_detail.jumlah
FROM keranjang_detail 
INNER JOIN menu ON menu.id = keranjang_detail.id_menu  where keranjang_detail.id_keranjang = $id_keranjang";
$result3 = $conn->query($sql);
// var_dump($result3);
$item_details = array();
if ($result3->num_rows > 0) {
    while ($row = $result3->fetch_assoc()) {
        $item_detail = array(
            'id' => $row['id'],
            'price' => $row['total'],
            'quantity' => $row['jumlah'],
            'name' => $row['nama_menu']
        );
        $item_details[] = $item_detail;
        // var_dump($item1_details);
    }
}
// else {
// echo "Tidak ada data yang ditemukan";
// }



require_once dirname(__FILE__) . '/../midtrans/Midtrans.php';
// Set Your server key
// can find in Merchant Portal -> Settings -> Access keys
Config::$serverKey = 'SB-Mid-server-v3PQ3VtoznMAyIQ_p7MQ5aVo';

// non-relevant function only used for demo/example purpose
printExampleWarningMessage();

// Uncomment for production environment
// Config::$isProduction = true;

// Uncomment to enable sanitization
// Config::$isSanitized = true;

// Uncomment to enable 3D-Secure
// Config::$is3ds = true;

// Required
$transaction_details = array(
    'order_id' => rand(),
    'gross_amount' => $data['total_harga'], // no decimal allowed for creditcard
);

// Optional
// $item1_details = array(
//     'id' => 'a1',
//     'price' => 50000,
//     'quantity' => 2,
//     'name' => "Apple"
// );



// Optional
// $item_details = array ($item1_details, $item2_details);

// Optional
// $billing_address = array(
//     'first_name'    => "Andri",
//     'last_name'     => "Litani",
//     'address'       => "Mangga 20",
//     'city'          => "Jakarta",
//     'postal_code'   => "16602",
//     'phone'         => "081122334455",
//     'country_code'  => 'IDN'
// );

// Optional
// $shipping_address = array(
//     'first_name'    => "Obet",
//     'last_name'     => "Supriadi",
//     'address'       => "Manggis 90",
//     'city'          => "Jakarta",
//     'postal_code'   => "16601",
//     'phone'         => "08113366345",
//     'country_code'  => 'IDN'
// );

// Optional
$customer_details = array(
    'first_name'    => $data2['username'],
    'email'         => $data2['email'],

    // 'last_name'     => "Litani",
    // 'phone'         => "081122334455",
    // 'billing_address'  => $billing_address,
    // 'shipping_address' => $shipping_address
);

// Fill SNAP API parameter
$params = array(
    'transaction_details' => $transaction_details,
    'customer_details' => $customer_details,
    'item_details' => $item_details,
);

try {
    // Get Snap Payment Page URL
    $paymentUrl = Snap::createTransaction($params)->redirect_url;

    // Redirect to Snap Payment Page
    header('Location: ' . $paymentUrl);
    // exit();
    // echo "<script>window.open('$paymentUrl', '_blank');</script>";
} catch (\Exception $e) {
    echo $e->getMessage();
}

function printExampleWarningMessage()
{
    if (strpos(Config::$serverKey, 'your ') != false) {
        echo "<code>";
        echo "<h4>Please set your server key from sandbox</h4>";
        echo "In file: " . __FILE__;
        echo "<br>";
        echo "<br>";
        echo htmlspecialchars('Config::$serverKey = \'<your server key>\';');
        die();
    }
}
