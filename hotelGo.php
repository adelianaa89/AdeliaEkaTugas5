<?php
// Inisialisasi variabel untuk menyimpan nilai input dan error
$nama = $email = $nomor = $kamar = $pembayaran = $tanggalIn = $tanggalOut = "";
$namaErr = $emailErr = $nomorErr = $pembayaranErr = $tanggalInErr = $tanggalOutErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi Nama
    $nama = trim($_POST["nama"]);
    if (empty($nama)) {
        $namaErr = "Nama wajib diisi";
    }

// Validasi Email
$email = trim($_POST["email"]);
if (empty($email)) {
    $emailErr = "Email wajib diisi";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $emailErr = "Format email tidak valid";
} elseif (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|co\.id)$/", $email)) {
    $emailErr = "Email harus menggunakan domain .com atau .co.id";
}


    // Validasi Nomor Telepon
    $nomor = trim($_POST["nomor"]);
    if (empty($nomor)) {
        $nomorErr = "Nomor Telepon wajib diisi";
    } elseif (!ctype_digit($nomor)) {
        $nomorErr = "Nomor Telepon harus berupa angka";
    } elseif (strlen($nomor) != 11) {
        $nomorErr = "Nomor Telepon harus terdiri dari 11 digit";
    }
    

    // Menyimpan pilihan pembayaran tanpa validasi khusus
    $pembayaran = $_POST["pembayaran"];

    // Menyimpan pilihan kamar tanpa validasi khusus
    $kamar = $_POST["kamar"];

    // Validasi Tanggal Check-in
    $tanggalIn = $_POST["checkin"];
    if (empty($tanggalIn)) {
        $tanggalInErr = "Tanggal Check-in wajib diisi";
    }

    // Validasi Tanggal Check-out
    $tanggalOut = $_POST["checkout"];
    if (empty($tanggalOut)) {
        $tanggalOutErr = "Tanggal Check-out wajib diisi";
    } elseif ($tanggalOut <= $tanggalIn) {
        $tanggalOutErr = "Check-out harus setelah Check-in";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemesanan Kamar</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h2>Form Pemesanan Kamar</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" value="<?php echo $nama; ?>">
                <span class="error"><?php echo $namaErr ? "* $namaErr" : ""; ?></span>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" value="<?php echo $email; ?>">
                <span class="error"><?php echo $emailErr ? "* $emailErr" : ""; ?></span>
            </div>

            <div class="form-group">
                <label for="nomor">Nomor Telepon:</label>
                <input type="text" id="nomor" name="nomor" value="<?php echo $nomor; ?>">
                <span class="error"><?php echo $nomorErr ? "* $nomorErr" : ""; ?></span>
            </div>

            <div class="form-group">
                <label for="kamar">Pilih Kamar:</label>
                <select id="kamar" name="kamar">
                    <option value="VIP" <?php echo ($kamar == "VIP") ? "selected" : ""; ?>>VIP</option>
                    <option value="Luxury" <?php echo ($kamar == "Luxury") ? "selected" : ""; ?>>Luxury</option>
                    <option value="Standar" <?php echo ($kamar == "Standar") ? "selected" : ""; ?>>Standar</option>
                </select>
            </div>

            <div class="form-group">
                <label for="pembayaran">Pembayaran:</label>
                <select id="pembayaran" name="pembayaran">
                    <option value="Kartu Debit" <?php echo ($pembayaran == "Kartu Debit") ? "selected" : ""; ?>>Kartu Debit</option>
                    <option value="ePayment" <?php echo ($pembayaran == "ePayment") ? "selected" : ""; ?>>ePayment</option>
                    <option value="Cash" <?php echo ($pembayaran == "Cash") ? "selected" : ""; ?>>Cash</option>
                </select>
            </div>

            <div class="form-group">
                <label for="tanggalIn">Check In:</label>
                <input type="date" id="tanggalIn" name="checkin" value="<?php echo $tanggalIn; ?>">
                <span class="error"><?php echo $tanggalInErr ? "* $tanggalInErr" : ""; ?></span>
            </div>

            <div class="form-group">
                <label for="tanggalOut">Check Out:</label>
                <input type="date" id="tanggalOut" name="checkout" value="<?php echo $tanggalOut; ?>">
                <span class="error"><?php echo $tanggalOutErr ? "* $tanggalOutErr" : ""; ?></span>
            </div>

            <div class="button-container">
                <button type="submit">Continue</button>
            </div>
        </form>
    </div>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && !$namaErr && !$emailErr && !$nomorErr && !$pembayaranErr && !$tanggalInErr && !$tanggalOutErr) { ?>
        <div class="container">
            <h3>Data Pembelian:</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th width="15%">Nama</th>
                            <th width="15%">Email</th>
                            <th width="15%">Nomor Telepon</th>
                            <th width="10%">Kamar</th>
                            <th width="10%">Pembayaran</th>
                            <th width="15%">Check In</th>
                            <th width="15%">Check Out</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $nama; ?></td>
                            <td><?php echo $email; ?></td>
                            <td><?php echo $nomor; ?></td>
                            <td><?php echo $kamar; ?></td>
                            <td><?php echo $pembayaran; ?></td>
                            <td><?php echo $tanggalIn; ?></td>
                            <td><?php echo $tanggalOut; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>
</body>

</html>
