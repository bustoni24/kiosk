<?= $this->renderPartial('_navbar', ['model' => $model, 'listTujuan' => $listTujuan, 'arrTujuan' => $arrTujuan], false); ?>

<div class="homepage">

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
            <div class="w-100">

            <div class="card-header">
            <h3 class="card-title">
            <h1><?= $model->source_name . ' <span class="arrow"><i class="fa fa-arrow-right"></i></span> ' . $model->destination_name ?></h1>
            </h3>

            <div class="card-tools">
                <?= $this->ShortIndonesiaTgl($model->startdate); ?>
            </div>
            </div>

            </div>
        </div>
      </div><!-- /.container-fluid -->
</section>

<?php 
    $this->widget('zii.widgets.CListView', array(
        'id'=>'listBoarding',
        'dataProvider'=>$model->searchListBus(Constant::SEARCH_BOARDING),
        'itemView'=>'_list_bus_boarding',
        'emptyText' => 'Silahkan pilih Tujuan Anda dengan tepat'
    )); 
?>   

<?php if (isset($model->enddate)): ?>
    <div class="divider">
    <hr style="border: 1px solid #000;">
    </div>

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
            <div class="w-100">

            <div class="card-header">
            <h3 class="card-title">
                <?php if ($model->return): ?>
                    <h1>Pilih Jadwal Kepulangan</h1>
                <?php endif; ?>
            <h1><?= $model->destination_name . ' <span class="arrow"><i class="fa fa-arrow-right"></i></span> ' . $model->source_name ?></h1>
            </h3>

            <div class="card-tools">
                <?= $this->ShortIndonesiaTgl($model->enddate); ?>
            </div>
            </div>

            </div>
        </div>
      </div><!-- /.container-fluid -->
</section>

<?php 
    $this->widget('zii.widgets.CListView', array(
        'id'=>'listDropoff',
        'dataProvider'=>$model->searchListBus(Constant::SEARCH_DROP_OFF),
        'itemView'=>'_list_bus_boarding',
        'emptyText' => 'Silahkan pilih Tujuan Anda dengan tepat'
    )); 
?>

<?php endif; ?>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function(event) {
      /* 
        - Code to execute when only the HTML document is loaded.
        - This doesn't wait for stylesheets, 
          images, and subframes to finish loading. 
      */
      var targetDrop = $('#listDropoff');
        <?php if ($model->return): ?>
            $('html, body').animate({
                scrollTop: $(targetDrop).offset().top
            }, 1000); // Durasi animasi dalam milidetik
        <?php endif; ?>

        $("body").on("click", ".chooseRoute", function(e){
        e.preventDefault();
            
                var route_id = $(this).attr('data-route_id');
                var trip_id = $(this).attr('data-trip_id');
                var startdate = $(this).attr('data-doj');
                var armada_ke = $(this).attr('data-armada_ke');
                var penjadwalan_id = $(this).attr('data-penjadwalan_id');
                var label_trip = $(this).attr('data-label_trip');
                var agen_id_asal = $(this).attr('data-agen_id_asal');
                var agen_id_tujuan = $(this).attr('data-agen_id_tujuan');
                var data_transit = $(this).attr('data-transit');
                var search_type = $(this).attr('data-search_type');
                var source_name = $(this).attr('data-source_name');
                var destination_name = $(this).attr('data-destination_name');
                
                var enddate = "<?= $model->enddate ?>";
                <?php if ($model->return): ?>
                    enddate = null;
                <?php endif; ?>
                var source_id =  $(this).attr('data-source_id');
                var destination_id =  $(this).attr('data-destination_id');

                if (search_type == 'drop_off') {
                    <?php if (empty(Helper::getInstance()->getState(Constant::TEMP_POST))): ?>
                    swal.fire('Mohon pilih jadwal keberangkatan terlebih dahulu', '', 'warning');

                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    return false;
                    <?php endif; ?>
                } else {
                    <?php if (isset(Yii::app()->session['post_return'])): ?>

                    swal.fire('Mohon Pilih Jadwal Kepulangan!', '', 'warning');

                    Swal.fire({
                        text: 'Mohon Pilih Jadwal Kepulangan!',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $('html, body').animate({
                            scrollTop: $(targetDrop).offset().top
                        }, 1000); // Durasi animasi dalam milidetik
                    });

                    
                    return false;
                    <?php endif; ?>
                }

            var formData = {
                route_id:route_id,
                trip_id:trip_id,
                label_trip:label_trip,
                agen_id_asal:agen_id_asal,
                agen_id_tujuan:agen_id_tujuan,
                data_transit:data_transit, 
                armada_ke:armada_ke,
                doj:startdate,
                penjadwalan_id:penjadwalan_id,
                search_type:search_type,
                source_name:source_name,
                destination_name:destination_name,
                startdate:startdate,
                enddate:enddate,
                source_id:source_id,
                destination_id:destination_id
            };

            $.form("<?= Constant::baseUrl() . '/front/seatmap/'; ?>"+route_id, formData).submit();
        });
  });

</script>