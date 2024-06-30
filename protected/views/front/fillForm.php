<style>
    .head-title {
        font-size: 1.5rem;
    }
</style>
<?= $this->renderPartial('_navbar', ['model' => $model, 'listTujuan' => $listTujuan, 'arrTujuan' => $arrTujuan], false); ?>

<div class="homepage">

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
            <div class="w-100">

            <div class="card">
                <div class="card-header">
                <h3 class="card-title text-bold">
                Masukkan data pemesan tiket
                </h3>
                </div>
            </div>
            
            </div>
        </div>
      </div><!-- /.container-fluid -->
</section>

<div class="row ie-h-align-center-fix justify-between">
    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xl-8 mt-3 mt-md-0">
        <div class="card">
            <div class="card-body">
            <form action="<?= Constant::baseUrl().'/'.$this->route ?>" method="post">
            <div class="tm-bg-white color-border layout-form">
                <div class="head-title">Info Pengambil Tiket</div>
                <div class="contact-form tm-p-4">
                    <div class="form-group">
                        <label class="col-sm-4">KTP/Passport (Pilih Salah Satu) <span>*</span></label>
                        <div class="col-sm-8">
                            <?= CHtml::textField("Booking[nik]", isset($post['Booking']['nik']) ? $post['Booking']['nik'] : '', ['class' => 'form-control', 'required' => true, 'placeholder' => 'NIK']) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Nama <span>*</span></label>
                        <div class="col-sm-8">
                            <?= CHtml::textField("Booking[nama]", isset($post['Booking']['nama']) ? $post['Booking']['nama'] : '', ['class' => 'form-control', 'required' => true, 'placeholder' => 'Nama']) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Email <span>*</span></label>
                        <div class="col-sm-8">
                            <?= CHtml::textField("Booking[email]", isset($post['Booking']['email']) ? $post['Booking']['email'] : '', ['class' => 'form-control', 'required' => true, 'placeholder' => 'Email']) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">No. HP <span>*</span></label>
                        <div class="col-sm-8">
                            <?= CHtml::textField("Booking[hp]", isset($post['Booking']['hp']) ? $post['Booking']['hp'] : '', ['class' => 'form-control', 'required' => true, 'placeholder' => 'No. HP']) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Akun Instagram </label>
                        <div class="col-sm-8">
                            <?= CHtml::textField("Booking[instagram]", isset($post['Booking']['instagram']) ? $post['Booking']['instagram'] : '', ['class' => 'form-control', 'required' => true, 'placeholder' => 'Akun Instagram']) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Jumlah Penumpang <span>*</span></label>
                        <div class="col-sm-8">
                            <?= CHtml::textField("Booking[jml_pnp_berangkat]", $post['jml_pnp_berangkat'], ['class' => 'form-control', 'required' => true, 'readonly' => true, 'placeholder' => 'Jumlah Penumpang']) ?>
                        </div>
                    </div>
                    <?php if (!empty($post['jml_pnp_pulang'])): ?>
                    <div class="form-group">
                        <label class="col-sm-4">Jumlah Penumpang Perjalanan Kembali<span>*</span></label>
                        <div class="col-sm-8">
                            <?= CHtml::textField("Booking[jml_penumpang_kembali]", $post['jml_pnp_pulang'], ['class' => 'form-control', 'readonly' => true, 'placeholder' => 'Jumlah Penumpang']) ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (!isset(Yii::app()->user->user_id)): ?>
            <div class="alert alert-info mt-10">Sebuah akun baru akan otomatis dibuat untuk anda nikmati lebih cepat layanan pemesanan tiket.</div>
            <?php endif; ?>

            <div class="alert alert-info mt-10">Untuk beberapa PO bus harga tiket bisa berubah-ubah tanpa adanya pemberitahuan sebelumnya ataupun mengenakan biaya tambahan. Setiap biaya tambahan akan dibebankan kepada penumpang bus.</div>

            <div class="tm-bg-white color-border layout-form mt-10">
                <?php 
                $i=1;
                foreach ($this->paramPost['FormSeat'][Constant::SEARCH_BOARDING]['kursi'] as $key => $seat) {
                    ?>
                    <div class="head-title">Informasi Penumpang<?= $i++ ?></div>
                <div class="row contact-form tm-p-4 justify-between">
                    <div class="col-sm-6">
                        <!-- <div class="form-group">
                            <label class="col-sm-4">KTP/Passport (Pilih Salah Satu) <span>*</span></label>
                            <div class="col-sm-8">
                                <?//= CHtml::textField("BookingDetail[nik][]", isset($post['BookingDetail']['nik'][$key]) ? $post['BookingDetail']['nik'][$key] : '', ['class' => 'form-control', 'required' => true, 'placeholder' => 'KTP/Passport (Pilih Salah Satu)']) ?>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label class="col-sm-4">Nama <span>*</span></label>
                            <div class="col-sm-8">
                                <?= CHtml::textField("BookingDetail[name][]", isset($post['BookingDetail']['name'][$key]) ? $post['BookingDetail']['name'][$key] : '', ['class' => 'form-control', 'required' => true, 'placeholder' => 'Nama']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label class="col-sm-4">Jenis Kelamin <span>*</span></label>
                            <div class="col-sm-8">
                                <?= CHtml::dropDownList('BookingDetail[gender][]', isset($post['BookingDetail']['gender'][$key]) ? $post['BookingDetail']['gender'][$key] : '', [
                                    'L' => 'Pria',
                                    'P' => 'Wanita'
                                ], ['class' => 'form-control']) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4">No. HP <span>*</span></label>
                            <div class="col-sm-8">
                            <?= CHtml::textField("BookingDetail[telp][]", isset($post['BookingDetail']['telp'][$key]) ? $post['BookingDetail']['telp'][$key] : '', ['class' => 'form-control', 'required' => true, 'placeholder' => 'No. HP']) ?>
                            </div>
                        </div>
                    </div>
                </div>
                    <?php
                } ?>
            </div>

            <div class="alert alert-success mt-10">Biaya Admin: Rp <?= Helper::getInstance()->getRupiah($post['admin_fee']); ?></div>
            <div class="alert alert-success mt-10">Total Pembayaran: Rp <?= Helper::getInstance()->getRupiah($post['total_bayar']); ?></div>

            <div class="alert alert-info mt-10">
                Silahkan segera melakukan pembayaran setelah memilih 'Lanjutkan Pembayaran' dengan batas waktu <?= (int)Setting::getValue("PUBLIC_TIME_PAY", 10) ?> menit
            </div>
            
            <div class="checkbox">
                <label>
                <?= CHtml::checkBox("Penumpang[agree]", true, ['required'=>true]) ?>
                Saya menyetujui kebijakan Efisiensi ticketing. Harap berada di tempat pemberangkatan setidaknya 30 menit sebelum jadwal keberangkatan. No Refund, No Reschedule.
                </label>
            </div>

            <button type="submit" class="btn btn-primary tm-btn-primary mt-10" style="font-size: 1.2rem;">Lanjutkan Pembayaran</button>
            </form>
            </div>
        </div>
        
    </div>

    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 mt-3 mt-md-0">
        <div class="card">
            <div class="card-body">
                    <div class="tm-bg-white color-border layout-form">
                    <div class="head-title">Info Keberangkatan</div>
                    <?php 
                    $boardingData = $this->paramPost['FormBooking'][Constant::SEARCH_BOARDING];
                    ?>
                    <div class="info-form tm-p-4">
                        <div class="form">
                            <label>Tanggal Berangkat</label>
                            <p><?= $this->ShortIndonesiaTgl($boardingData['startdate']) . ', ' . $this->getDay($boardingData['startdate']) ?></p>
                        </div>
                        <div class="form">
                            <label>Berangkat di</label>
                            <p><?= $boardingData['boarding_name'] ?></p>
                        </div>
                        <div class="form">
                            <label>Tiba di</label>
                            <p><?= $boardingData['destination_name'] ?></p>
                        </div>
                        <div class="form">
                            <label>Nomor Kursi</label>
                            <p><?= implode(',', $this->paramPost['FormSeat'][Constant::SEARCH_BOARDING]['kursi']); ?></p>
                        </div>
                        <div class="form">
                            <label>Harga tiap tiket</label>
                            <p><?= 'Rp ' . Helper::getInstance()->getRUpiah($boardingData['tarif']) ?></p>
                        </div>
                    </div>
                </div>

                <?php if (!empty($post['jml_pnp_pulang']) && isset($this->paramPost['FormBooking'][Constant::SEARCH_DROP_OFF])): ?>
                <div class="tm-bg-white color-border layout-form mt-10">
                    <div class="head-title">Info Kepulangan</div>
                    <?php 
                    $dropOffData = $this->paramPost['FormBooking'][Constant::SEARCH_DROP_OFF];
                    ?>
                    <div class="info-form tm-p-4">
                        <div class="form">
                            <label>Tanggal Berangkat</label>
                            <p><?= $this->ShortIndonesiaTgl($dropOffData['startdate']) . ', ' . $this->getDay($dropOffData['startdate']) ?></p>
                        </div>
                        <div class="form">
                            <label>Berangkat di</label>
                            <p><?= $dropOffData['boarding_name'] ?></p>
                        </div>
                        <div class="form">
                            <label>Tiba di</label>
                            <p><?= $dropOffData['destination_name'] ?></p>
                        </div>
                        <div class="form">
                            <label>Nomor Kursi</label>
                            <p><?= implode(',', $this->paramPost['FormSeat'][Constant::SEARCH_DROP_OFF]['kursi']); ?></p>
                        </div>
                        <div class="form">
                            <label>Harga tiap tiket</label>
                            <p><?= 'Rp ' . Helper::getInstance()->getRUpiah($dropOffData['tarif']) ?></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
    </div>
</div>


</div>