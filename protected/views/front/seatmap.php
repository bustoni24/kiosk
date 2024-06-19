<?= $this->renderPartial('_navbar', ['model' => $model, 'listTujuan' => $listTujuan, 'arrTujuan' => $arrTujuan], false); ?>

<div class="seatmap">
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
            <div class="w-100">

            <div class="card-header">
            <h3 class="card-title">
            <h1><?= $model->source_name . ' <span class="arrow"><i class="fa fa-arrow-right"></i></span> ' . $model->destination_name ?></h1>
            </h3>

            <div class="card-tools">
                <?= $this->ShortIndonesiaTgl($model->doj); ?>
            </div>
            </div>

            </div>
        </div>

        <div class="row">
            <div class="col-sm-8">
                <div class="bg-white color-border layout-seat">
                    <div class="head-title">
                        <div class="sub">
                            <h5 class="text-bold">KOMPOSISI KURSI ARMADA</h5>
                            <p>Untuk membatalkan, klik kembali kursi yang dipilih</p>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="subhead-title">
                        <div class="row justify-center">
                            <div><span class="legend legend-available"></span> Kursi Kosong</div>
                            <div><span class="legend legend-men"></span> Kursi Terisi Pria</div>
                            <div><span class="legend legend-women"></span> Kursi Terisi Wanita</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="bg-white color-border layout-seat">
                    <div class="head-title" style="font-size: 1.5rem;">Informasi Kursi</div>
                        <form action="<?= Constant::baseUrl() . '/' . $this->route . '/' . $data['route_id'] ?>" method="post" onsubmit="return validateForm()" class="contact-form tm-p-4" id="form-seat">
                            <?php if (isset($data['boarding_name'], $data['destination_name'])): ?>
                            <h5 class="title-seat"><?= $data['detail_label'] ?></h5>
                            <?php endif; ?>
                            <p>Titik Keberangkatan: <?= $data['boarding_name'] . ' - ' . $data['boarding_address'] ?></p>
                            <p>Waktu*: <?= $data['time_label'] ?></p>
                            <p>Tarif per Orang: <?= $data['price_label'] ?></p>
                            <p>Label Perjalanan: <?= $data['header_label'] ?></p>
                            
                            <h4 class="title-seat">Data Kursi</h4>
                            
                            <table class="table mb-20 none">
                                <tbody id="table-form-passenger">
                                    <tr id="form-passenger0" class="form-passenger">
                                        <td><label>Kursi</label></td>
                                        <td>
                                            <?= CHtml::textField('FormSeat['.$model->search_type.'][kursi][]', '', ['readonly'=>true, 'class'=>'seatForm form-control', 'data-name'=>'kursi']); ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="summary-form">
                                <?php foreach ($data as $label => $value) {
                                    if (is_array($value)){
                                        echo CHtml::hiddenField('FormBooking['.$model->search_type.']['.$label.']', json_encode($value));
                                    } else {
                                        echo CHtml::hiddenField('FormBooking['.$model->search_type.']['.$label.']', $value);
                                    }
                                } ?>
                                <div class="row">
                                    <p><i class="fa fa-users"></i> Jumlah: <span class="jml_penumpang">0</span> Penumpang</p>
                                </div>
                                <div class="row">
                                    <p><i class="fa fa-laptop"></i> Harga / Kursi: </p>
                                    <div class="mb-10" id="harga_kursi"></div>
                                </div>
                                <div class="row bg-dark text-white p-10 d-flex justify-between">
                                    <span>Total Bayar</span>
                                    <h4 id="total_price">0</h4>
                                </div>
                            </div>

                            <div class="row justify-between">
                                <?php if (isset($model->enddate) && $model->search_type == Constant::SEARCH_BOARDING): ?>
                                <input type="submit" name="proses" class="btn btn-success tm-btn-success" style="font-size: 0.8rem;padding:10px;" value="Proses Sekali Jalan">
                                <?php endif; ?>
                                <input type="submit" class="btn btn-primary tm-btn-success" style="font-size: 0.8rem;padding:10px;" name="proses" value="<?= $data['btn_text'] ?>">
                            </div>
                            
                        </form>
                    </div> 
            </div>
        </div>
      </div><!-- /.container-fluid -->
</section>
</div>