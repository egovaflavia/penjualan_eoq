<?php include 'components/koneksi.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cetak</title>
    <?php include 'components/head.php' ?>
</head>

<body>
    <div class="container">
        <div id="page-wrapper">
            <?php
            $no = 1;
            $id = $_GET['idpemesanan'];
            $get = $koneksi->query("SELECT * FROM detail LEFT JOIN penjualan ON detail.id_penjualan=penjualan.id_penjualan
                                            LEFT JOIN barang ON detail.kd_barang=barang.kd_barang
                                            LEFT JOIN kategori ON barang.id_kategori=kategori.id_kategori
                                            LEFT JOIN pelanggan ON penjualan.id_pelanggan=pelanggan.id_pelanggan 
                                            LEFT JOIN ongkos_kirim ON penjualan.id_ongkir=ongkos_kirim.id_ongkir 
                                            WHERE penjualan.id_penjualan = $id");
            $pelanggan = $get->fetch_object();
            ?>
            <div class="row">
                <div class="span12">
                    <div class="well well-small">
                        <h1>Nota Pembelian </h1>
                        <hr class="soften" />
                        <table border="0">
                            <tr>
                                <td width="150px">Nama Pemesan</td>
                                <td width="10px">:</td>
                                <td width="500px"><?php echo $pelanggan->username ?></td>
                                <td width="150px">Tujuan Pengiriman</td>
                                <td width="10px">:</td>
                                <td><?php echo $pelanggan->kota ?></td>
                            </tr>
                            <tr>
                                <td>No Telp.</td>
                                <td>:</td>
                                <td><?php echo $pelanggan->no_telp ?></td>
                                <td>Ongkos Kirim</td>
                                <td>:</td>
                                <td>Rp. <?php echo number_format($pelanggan->tarif) ?></td>
                            </tr>
                            <tr>
                                <td>Tanggal Pemesanan</td>
                                <td>:</td>
                                <td><?php echo $pelanggan->tgl_penjualan ?></td>
                                <td>Alamat Lengkap</td>
                                <td>:</td>
                                <td><?php echo $pelanggan->alamt ?></td>
                            </tr>

                        </table>


                        <br>
                        <table class="table table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th width="15px">No</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $id = $_GET['idpemesanan'];
                                $get = $koneksi->query("SELECT * FROM detail
                                                LEFT JOIN penjualan ON detail.id_penjualan=penjualan.id_penjualan
                                                LEFT JOIN barang ON detail.kd_barang=barang.kd_barang
                                                LEFT JOIN kategori ON barang.id_kategori=kategori.id_kategori
                                                LEFT JOIN pelanggan ON penjualan.id_pelanggan=pelanggan.id_pelanggan 
                                                LEFT JOIN ongkos_kirim ON penjualan.id_ongkir=ongkos_kirim.id_ongkir 
                                                WHERE penjualan.id_penjualan = '$id'");
                                while ($row = $get->fetch_object()) {
                                    $subtotal = 0;
                                    $subtotal = $row->jml_beli * $row->harga;
                                    $total += $subtotal;

                                ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?php echo $row->nm_barang ?></td>
                                        <td><?php echo $row->nm_kategori ?></td>
                                        <td><?php echo $row->jml_beli ?></td>
                                        <td><?php echo $row->harga ?></td>
                                        <td>Rp. <?php echo number_format($subtotal) ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">Ongkos Kirim</td>
                                    <td>Rp. <?php echo number_format($pelanggan->tarif) ?></td>
                                </tr>
                                <tr>
                                    <td colspan="5">Total</td>
                                    <td>Rp. <?php echo number_format($total + $pelanggan->tarif) ?></td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="span5">
                            <div class="alert alert-info">
                                Total Yang Akan Di Bayarkan Adalah Rp.
                                <strong><?php echo number_format($total + $pelanggan->tarif) ?></strong> <br>
                                Silahkan Transfer ke salah satu rekening :
                                <ul>
                                    <li>BRI : 5521293019203</li>
                                    <li>Mandiri : 2231234</li>
                                    <li>BCA : 13212341</li>
                                </ul>
                            </div>
                        </div>
                        <div class="clr"></div>
                    </div>
                </div>
            </div>
        </div><!-- /#page-wrapper -->
    </div>
    <script>
        window.print();
    </script>
</body>

</html>