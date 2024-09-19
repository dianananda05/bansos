<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Data Penerima Bansos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Preview Data Penerima Bantuan Sosial</h2>
    <table class="table table-bordered">
        <tr>
            <th>Nama</th>
            <td><?= $data['nama'] ?></td>
        </tr>
        <tr>
            <th>NIK</th>
            <td><?= $data['nik'] ?></td>
        </tr>
        <tr>
            <th>Nomor Kartu Keluarga</th>
            <td><?= $data['no_kk'] ?></td>
        </tr>
        <tr>
            <th>Provinsi</th>
            <td><?= $data['provinsi_nama'] ?></td>
        </tr>
        <tr>
            <th>Kab/Kota</th>
            <td><?= $data['kabupaten_nama'] ?></td>
        </tr>
        <tr>
            <th>Kecamatan</th>
            <td><?= $data['kecamatan_nama'] ?></td>
        </tr>
        <tr>
            <th>Kelurahan/Desa</th>
            <td><?= $data['kelurahan_nama'] ?></td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td><?= $data['alamat'] ?></td>
        </tr>
        <tr>
            <th>RT</th>
            <td><?= $data['rt'] ?></td>
        </tr>
        <tr>
            <th>RW</th>
            <td><?= $data['rw'] ?></td>
        </tr>
        <tr>
            <th>Penghasilan Sebelum Pandemi</th>
            <td><?= $data['penghasilan_sebelum'] ?></td>
        </tr>
        <tr>
            <th>Penghasilan Setelah Pandemi</th>
            <td><?= $data['penghasilan_setelah'] ?></td>
        </tr>
        <tr>
            <th>Alasan Membutuhkan Bantuan</th>
            <td><?= $data['alasan'] ?></td>
        </tr>
    </table>
</div>
</body>
</html>
