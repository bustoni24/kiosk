<style>
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    border-top: none;
}
h2 {
    font-size: 25px;
    font-weight: 700;
}
h5{
    margin: 0;
}
table.back-head{
    background-color: #f58220;  
}
</style>

<table class="table testing" style="width:100%;">
    <thead class="back-head">
        <tr>
            <th style="text-align: left;vertical-align: middle;color: #fff;background-color: #f58220; padding: 10px;">
                <h2 style="font-size: 22px;;font-weight:700;">e-Ticket</h2>
            </th>
            <th style="text-align: right;vertical-align: middle;background-color: #f58220; padding:10px;">
                <img src="<?= Constant::newLogoIcon(); ?>" style="width: 200px;"/>
            </th>
        </tr>
        <tr>
            <td colspan="2"></td>
        </tr>
    </thead>
</table>

<table class="table" style="width: 100%;">
    <tbody>
        <tr>
            <th colspan="3">
                <h4>Efisiensi eTicket (Tanda Terima)</h4>
            </th>
        </tr>
        <tr>
            <td colspan="3">
                <p>Ini adalah Tanda Terima eTicket. Untuk masuk ke Terminal / Titik Keberangkatan dan melakukan check-in, Anda harus menunjukkan tanda terima perjalanan ini.</p>
            </td>
        </tr>
        <tr><td colspan="3"><br/></td></tr>
        <tr>
            <th colspan="2">
                <h4>Detail Pesanan</h4>
            </th>
            <td rowspan="7" style="text-align: center;vertical-align: middle;">
            <div class="qrcode-container" style="width: 50%;">
                <?php
                $qr_data = $this->encode($data['booking_id']);
                try{
                    $qr_widget = $this->widget('application.extensions.qrcode.QRCodeGenerator',array(
                        'data' => $qr_data,
                        'filename' => $data['file_name'].".png",
                        'subfolderVar' => false,
                        'matrixPointSize' => 4,
                        'displayImage'=>true,
                        'errorCorrectionLevel'=>'L',
                    ));
                }
                catch (Exception $e){
                        echo json_encode($e->getMessage());// error here
                }
                ?>
            </div>
            <br/>
                <h5 style="font-weight:900px;"><?= $data['label_perjalanan'] ?></h5>
            </td>
        </tr>
        <?php if (isset($data['tipe']) && !empty($data['tipe'])): ?>
        <tr>
            <th width="40%">
                <h3><?= in_array($data['tipe'], [Constant::SEARCH_BOARDING]) ? 'Tiket Keberangkatan' : 'Tiket Kepulangan' ?></h3>
            </th>
            <th></th>
        </tr>
        <?php endif; ?>
        <tr>
            <th>
                <h5>Dibeli dari</h5>
            </th>
            <td>
                KIOSK
            </td>
        </tr>
        <tr>
            <th>
                <h5>Tanggal dikeluarkan</h5>
            </th>
            <td>
            <?= $data['date']; ?>
            </td>
        </tr>
    </tbody>
</table>

<table class="table" style="width: 100%;">
    <tbody>
        <tr>
            <th colspan="4">
                <h4>Detail Penumpang</h4>
            </th>
        </tr>
        <tr>
            <th width="50px">
                No
            </th>
            <th width="50%">
                Nama Penumpang
            </th>
            <th>
                Kode Booking
            </th>
        </tr>
        <?php foreach ($data['passenger_details'] as $p) {
            ?>
            <tr>
                <td><?= $p['no']; ?></td>
                <td><?= $p['name']; ?></td>
                <td><?= $p['booking_code']; ?></td>
            </tr>
            <?php
        } ?>
    </tbody>
</table>

<table class="table" style="width: 100%;">
    <tbody>
        <tr>
            <th colspan="8">
                <h4>Detail Perjalanan</h4>
            </th>
        </tr>
        <tr>
            <th width="15%">
                ID Pesanan
            </th>
            <th width="25%">
                Keberangkatan
            </th>
            <th width="25%">
                Tujuan
            </th>
            <th width="15%">
                Grup
            </th>
            <th width="20%">
                Kelas
            </th>
        </tr>
        <tr>
            <td><?= $data['booking_details']['booking_id']; ?></td>
            <td><?= $data['booking_details']['boarding']; ?></td>
            <td><?= $data['booking_details']['drop_off']; ?></td>
            <td><?= $data['booking_details']['group']; ?></td>
            <td><?= $data['booking_details']['class']; ?></td>
        </tr>
    </tbody>
</table>

<table class="table" style="width: 100%;">
    <tbody>
        <tr>
            <th colspan="4">
                <h4>Pembagian Kursi</h4>
            </th>
        </tr>
        <tr>
            <th>No. Tiket</th>
            <th>Naik</th>
            <th>Turun</th>
            <th>Detail</th>
        </tr>
        <?php 
        foreach ($data['seat_details'] as $seat) {
            if (!isset($seat['booking_id']))
                continue;
            ?>
             <tr>
                <td width="20%" style="padding-right: 10px;">
                    <?= $seat['booking_id']; ?>
                </td>
                <td width="20%">
                    <?= $seat['kota_berangkat']; ?>
                </td>
                <td width="20%">
                    <?= $seat['kota_tujuan']; ?>
                </td>
                <td width="40%" style="padding-top: 20px;">
                    <table class="table" style="width: 100%;">
                    <tr>
                        <th width="20%">Kursi</th>
                        <th width="80%">Nama</th>
                    </tr>
                    <?php foreach ($seat['passenger'] as $s) {
                        ?>
                        <tr>
                            <td width="20%"><?= $s['seat']; ?></td>
                            <td width="80%"><?= $s['name']; ?></td>
                        </tr>
                        <?php
                    } ?>
                    </table>
                </td>
            </tr>

            <?php
        } 
        ?>
    </tbody>
</table>

<table class="table" style="width: 100%;">
    <tbody>
        <tr>
            <th colspan="2">
                <h4>Detail Tarif</h4>
            </th>
        </tr>
        <tr>
            <td width="20%">
                Kursi
            </td>
            <td width="20%">
                Rp <?= $data['fare_details']['seat_price'] ?>
            </td>
        </tr>
        <tr>
            <td>Jumlah</td>
            <td><span style="margin-left: 50px;"><?= $data['fare_details']['count_passenger']; ?></span></td>
        </tr>
        <tr>
            <td width="20%">
                Total Harga
            </td>
            <td width="20%">
                Rp <?= $data['fare_details']['total_amount'] ?>
            </td>
        </tr>
    </tbody>
</table>