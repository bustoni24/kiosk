<?php if (isset($data['route_id'], $data['armada_ke'], $data['kelas_bus'])): 
    $fasilitas = isset($data['fasilitas']) ? $data['fasilitas'] : '';
    ?>

<div class="card w-100 border-custom">
        <div class="card-header">
          <h3 class="card-title">
            <?= isset($data['nomor_lambung']) ? $data['nomor_lambung'] : '' ?>
          </h3>

          <div class="card-tools">
           
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-sm-2 text-center">
                <div class="text"><?= 'Jam ' . $data['jam'] ?></div> 
                <div class="time-info"><?= 'Lama Perjalanan ' . $data['lama_perjalanan'] ?>* </div>
            </div>
            <div class="col-sm-5 text-center">
                <div class="row route">
                    <div class="col-sm-5"><div class="text"><?= isset($data['boarding_name']) ? $data['boarding_name'] : '' ?></div></div>
                    <div class="col-sm-2"><i class="fa fa-arrow-right"></i></div>
                    <div class="col-sm-5"><div class="text"><?= isset($data['drop_off_name']) ? $data['drop_off_name'] : '' ?></div></div>
                </div>
            </div>
            <div class="col-sm-1 text-center">
                <div class="seat-info"><?= 'Tersedia<br/>' . $data['seats_left']; ?> Kursi</div>
            </div>
            <div class="col-sm-4 text-center">
                <div class="row price-layout">
                    <div class="price"><i class="fa fa-male"></i> Rp <?= Helper::getInstance()->getRupiah($data['price']); ?></div>
                    <button 
                    data-route_id="<?= $data['route_id']; ?>" 
                    data-trip_id="<?= $data['trip_id']; ?>" 
                    data-armada_ke="<?= $data['armada_ke'] ?>" 
                    data-penjadwalan_id="<?= (isset($data['penjadwalan_id']) ? $data['penjadwalan_id'] : '') ?>" 
                    data-label_trip="<?= (isset($data['booking_trip_label']) ? $data['booking_trip_label'] : $data['trip_label']) ?>" 
                    data-agen_id_asal="<?= $data['agen_id_asal'] ?>" 
                    data-agen_id_tujuan="<?= $data['agen_id_tujuan'] ?>"
                    data-search_type="<?= $data['search_type'] ?>"
                    data-doj="<?= $data['doj'] ?>"
                    data-source_id="<?= $data['source_id'] ?>"
                    data-destination_id="<?= $data['destination_id'] ?>"
                    data-source_name="<?= $data['boarding_name'] ?>"
                    data-destination_name="<?= $data['drop_off_name'] ?>"
                    data-transit="<?= isset($data['transit_data']) ? base64_encode(json_encode($data['transit_data'])) : '' ?>"
                    type="button" class="btn btn-warning chooseRoute">Pilih</button>
                </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer additional-info">
            <div class="col-sm-5"><span class="text-bold"><?= (isset($data['booking_trip_label']) ? $data['booking_trip_label'] : '') ?></span></div>
            <div class="col-sm-7 text-center"><?= (isset($data['kelas_bus']) ? $data['kelas_bus'] : '') ?> <i class="fa fa-tv"></i></div>
        </div>
        <!-- /.card-footer-->
</div>

<?php elseif (isset($data['data'])): ?>
    <div class="card w-100">
        <div class="card-header">
          <h3 class="card-title">
          Mohon maaf perjalanan belum tersedia
          </h3>
        </div>
    </div>
<?php elseif (isset($data['message'])): ?>
    <div class="card w-100">
        <div class="card-header">
          <h3 class="card-title no_available_trip">
          <?= $data['message']; ?>
          </h3>
        </div>
    </div>
<?php endif; ?>