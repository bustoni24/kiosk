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
                    <div class="contact-form tm-p-4">
                        <div class="row justify-center">
                            <table class="table border-none text-center table-deck max-w-60">
                                <tbody>
                                <?php 
                                    foreach ($seatmap as $key => $deck) {
                                        echo "<tr>";
                                        foreach ($deck as $deck_) {
                                            if (in_array($deck_['type'], ['TL','EMPTY'])) {
                                                echo '<td style="width:22.5%"></td>';
                                            } else if (in_array($deck_['type'], ['DRIVER'])) {
                                                echo '<td style="width:22.5%"><img src="'. $deck_['image']  .'" class="img-icon" alt="steer"/></td>';
                                            } else if (in_array($deck_['type'], ['DOOR'])) {
                                                echo '<td class="door">Pintu</td>';
                                            } else if (in_array($deck_['type'], ['TOILET'])) {
                                                echo '<td><img src="'. $deck_['image']  .'" class="img-icon" alt="toilet"/></td>';
                                            } else {
                                                echo '<td>
                                                            <div class="checkbox">
                                                                <label class="checkbox-wrapper">
                                                                '. CHtml::checkBox('SeatBus[seat]['. $deck_['id'] .']', (isset($post['seat_bus'][$deck_['id']]['value'])), ['class' => 'none checkSeat', 'style' => 'display: contents;', 'value'=>$deck_['id'], 'data-index' => $deck_['id'], 'disabled' => ($deck_['status'] == 'UNAVAILABLE') ] )
                                                                .' <span class="checkmark '. ($deck_['gender'] == 'L' ? 'booked' : ($deck_['gender'] == 'P' ? 'booked-girl' : '')) .'" data-passengerId="'.(isset($deck_['passenger_id']) && $deck_['passenger_id'] != '-' ? $deck_['passenger_id'] : '').'"></span> <span class="text-checkmark" data-passengerId="'.(isset($deck_['passenger_id']) && $deck_['passenger_id'] != '-' ? $deck_['passenger_id'] : '').'">'. $deck_['id'] .'</span>
                                                            </label>
                                                            </div>
                                                            </td>';
                                            }
                                        }
                                        echo "</tr>";
                                    }
                                ?>
                                </tbody>
                            </table>
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
                            <div class="content-form">
                                <p>Titik Keberangkatan: <?= $data['boarding_name'] . ' - ' . $data['boarding_address'] ?></p>
                                <p>Tanggal: <?= $data['time_label'] ?></p>
                                <p>Tarif per Orang: <?= $data['price_label'] ?></p>
                                <p>Label Perjalanan: <?= $data['header_label'] ?></p>
                            </div>
                            
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
                                <?php 
                                echo CHtml::hiddenField('FormBooking['.$model->search_type.'][source_id]', $model->source_id);
                                echo CHtml::hiddenField('FormBooking['.$model->search_type.'][destination_id]', $model->destination_id);
                                echo CHtml::hiddenField('FormBooking['.$model->search_type.'][startdate]', $model->startdate);
                                echo CHtml::hiddenField('FormBooking['.$model->search_type.'][enddate]', $model->enddate);
                                if (isset($model->enddate) && $model->search_type == Constant::SEARCH_BOARDING): ?>
                                <input type="submit" name="proses" class="btn btn-success tm-btn-success" style="font-size: 1rem;padding:10px;" value="Proses Sekali Jalan">
                                <?php endif; ?>
                                <input type="submit" class="btn btn-primary tm-btn-success" style="font-size: 1rem;padding:10px;" name="proses" value="<?= $data['btn_text'] ?>">
                            </div>
                            
                        </form>
                    </div> 
            </div>
        </div>
      </div><!-- /.container-fluid -->
</section>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        var maxSeat = 8;

        $("body").on("change", ".checkSeat", function(e){
        e.preventDefault();
            addFormSeatAction($(this));
            addDetailPembelian($(this));
        });

        function addDetailPembelian(element) {
            if (typeof element === "undefined") {
                alert('Terjadi kesalahan');
                return false;
            }

            var inputs = document.querySelectorAll('#table-form-passenger input.seatForm');
            var count = 0;
            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].value.trim() !== '') {
                    count++;
                }
            }        

            $('.jml_penumpang').html(count);
            var harga = parseInt('<?= $data['tarif'] ?>');
            var totalHarga = harga * count;
            $('#total_price').html(accounting.formatNumber(totalHarga, 0, "."));
        }

        function addFormSeatAction(element) {
            if (typeof element === "undefined") {
                alert('Terjadi kesalahan');
                return false;
            }

            // var total_harga = 0;
            var harga = parseInt('<?= $data['tarif'] ?>');
            
            var inputs = document.querySelectorAll('#table-form-passenger input.seatForm');
            var count = 0;
            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].value.trim() !== '') {
                    // total_harga += harga;
                    count++;
                }
            }

            // total_harga = accounting.formatNumber(total_harga, 0, ".");
            var seatIndex = parseInt(element.attr('data-index'));
            var passengerFormId = 'passengerForm' + seatIndex;
            var valSeat = element.val();

            var elementID = 'kursiForm' + seatIndex;
            // console.log(count);
            if (element.is(":checked")) {
                if (count >= maxSeat) {
                    swal.fire('Maaf pembelian tiket sudah melewati batas', '', 'warning');
                    element.attr('checked', false);
                    return false;
                }
                
                var $addForm = $('#form-passenger0')
                .clone()
                .attr('id', passengerFormId)
                .find("input:text").val("")
                .end()
                .find("input.seatForm").val(valSeat)
                .end();

                // $('#harga_kursi').html(total_harga);
                if (count <= 0 || $('#form-passenger0').find('input.seatForm').val() === "") {
                    $('#form-passenger0').find('input.seatForm').val(valSeat);
                } else {
                    $('#table-form-passenger').append($addForm);
                }
            } else {
                console.log(passengerFormId);
                if (count > 0 && typeof $('#' + passengerFormId).val() !== "undefined") {
                    $('#' + passengerFormId).remove();
                } else {
                    $('#form-passenger0').find('input[type="text"]').val('');
                    $('#form-passenger0').find('input[type="number"]').val('');
                }
                $('#' + elementID).remove();
            }
        }
    });

    function validateForm()
        {
            var jmlPnp = parseInt($('.jml_penumpang').html());
            console.log(jmlPnp);
            <?php if (!empty(Helper::getInstance()->getState(Constant::TEMP_POST))): ?>
                var boardingData = <?= json_encode(Helper::getInstance()->getState(Constant::TEMP_POST)) ?>;
                if (typeof boardingData.FormSeat.boarding.jml_pnp !== "undefined") {
                    var jmlPnpBoarding = boardingData.FormSeat.boarding.jml_pnp;
                    if (jmlPnp !== jmlPnpBoarding) {
                        alert('Jumlah Kursi Keberangkatan harus sama dengan Jumlah Kursi Kepulangan! Keberangkatan: '+jmlPnpBoarding+' , Kepulangan: '+jmlPnp);

                        return false;
                    }
                }
            <?php endif; ?>
            // var formData = new FormData(document.getElementById("form-seat"));
            // console.log(formData);
            if ($('#total_price').html() === "" || $('#total_price').html() === "0") {
                swal.fire('Maaf silahkan pilih kursi terlebih dahulu', '', 'warning');

                return false;
            }
            
        }
</script>