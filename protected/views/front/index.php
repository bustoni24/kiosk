<div class="register-page">
    
<div class="register-box">
      <div class="register-logo">
        <a href="#"><?php echo 'Pembelian Tiket Bus'; ?></a>
      </div>
    
      <div class="card">
        <div class="card-body register-card-body">
    
        <?php $form=$this->beginWidget('CActiveForm', array(
          'id'=>'homepage-form',
          // Please note: When you enable ajax validation, make sure the corresponding
          // controller action is handling ajax validation correctly.
          // There is a call to performAjaxValidation() commented in generated controller code.
          // See class documentation of CActiveForm for details on this.
          'enableAjaxValidation'=>false,
          'action' => Constant::baseUrl().'/front/homepage',
        )); 
        ?>
            <div class="row justify-center">

              <div class="col-sm-3 col-relative pr-0">
              <div class="form-group">
                  <label>Dari</label>
                  <div class="input-group mb-3">
                  <?= CHtml::dropDownList("source", $model->source_id, $listTujuan, ['prompt' => 'Pilih Asal Keberangkatan', 'class' => 'form-control col-sm-11', 'required' => true]); ?>
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-map-marker-alt"></span>
                      </div>
                    </div>
                  </div>
              </div>
              </div>

              <div class="col-sm-05">
                <i class="fas fa-exchange-alt"></i>
              </div>

              <div class="col-sm-3 col-relative pl-0">
              <div class="form-group">
                  <label>Ke</label>
                  <div class="input-group mb-3">
                  <?= CHtml::dropDownList("destination", $model->destination_id, $arrTujuan, ['prompt' => 'Pilih Tujuan Keberangkatan', 'class' => 'form-control col-sm-11', 'required' => true]); ?>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-map-marker-alt"></span>
                    </div>
                  </div>
                </div>
              </div>
              </div>

              <div class="col-sm-2">
                <div class="input-group mb-3">
                  <?= CHtml::textField("startdate", $model->startdate, ['readonly' => true, 'class' => 'form-control', 'placeholder' => 'Tgl Berangkat', 'required' => true]) ?>
                </div>
              </div>

              <div class="col-sm-2">
                <div class="input-group mb-3">
                <?= CHtml::textField("enddate", $model->enddate, ['readonly' => true, 'class' => 'form-control', 'placeholder' => 'Tgl Pulang (Opsional)']) ?>
                </div>
              </div>

              <div class="col-sm-1">
                <button type="submit" onclick="return submitted()" class="btn btn-primary btn-block">Cari</button>
              </div>
            </div>           
           
          <?php $this->endWidget(); ?>
  
        </div>
        <!-- /.form-box -->
      </div><!-- /.card -->
    </div>
</div>

<script>
    window.addEventListener('load', function() {
        $('#startdate').datepicker({
          uiLibrary: 'bootstrap4',
          format: 'yyyy-mm-dd',
          header: true
        });

        $('#enddate').datepicker({
          uiLibrary: 'bootstrap4',
          format: 'yyyy-mm-dd',
          header: true
        });

        $('.fa-exchange-alt').on('click', function(){
          // exchange source and destination
          // $('#TripTransit_tts_titik_awal').val("").trigger('change');
        });
    });
    var titikId = "<?= isset($model->source_id) ? $model->source_id : null ?>";
    var geoLoc = false;
    if (titikId === null || titikId === ""){
      geoLoc = getLocation();
    }
    var options = {
        enableHighAccuracy: true,
        timeout: 5000,
        maximumAge: 0
    };

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError, options);
            return true;
        }
        return false;
    }

    function showPosition(position) {
        if (geoLoc != false || geoLoc != undefined || geoLoc != "" || geoLoc != null) {
            if (position.coords.latitude != "" || position.coords.longitude != "") {
                getDetailCurrentLocation(position.coords.latitude, position.coords.longitude);
            }
        }
    }

    function showError(error) {
        switch (error.code) {
            case error.PERMISSION_DENIED:
                console.log("User denied the request for Geolocation.");
                getDetailCurrentLocation(0, 0);
                break;
            case error.POSITION_UNAVAILABLE:
                console.log("Location information is unavailable.");
                getDetailCurrentLocation(0, 0);
                break;
            case error.TIMEOUT:
                console.log("The request to get user location timed out.");
                getDetailCurrentLocation(0, 0);
                break;
            case error.UNKNOWN_ERROR:
                console.log("An unknown error occurred.");
                getDetailCurrentLocation(0, 0);
                break;
        }
    }

    function getDetailCurrentLocation(latitude, longitude) {
        $.ajax({
            url: "<?= Constant::baseUrl() ?>/api/setTitikId",
            data: {
                latitude: latitude,
                longitude: longitude
            },
            type: "POST",
            dataType: "JSON",
            success: function (data) {
              if (data.success) {
                if (typeof data.data !== "undefined") {
                  var datas = data.data;
                  if (typeof datas.titik_id !== "undefined") {
                    titikId = datas.titik_id;
                  }
                }
              }
            },
            complete: function(){
               setTitikId(titikId);
            },
            error: function () {
                console.log('failed');
            }
        });
    }

    function setTitikId(titikId)
    {
      location.href = "<?= Constant::baseUrl() . '/' . $this->route ?>?source="+titikId;
    }

    function submitted() {
      var startdate = $('#startdate').val();
      if (startdate === "") {
        swal.fire('Silahkan isi tanggal keberangkatan', '', 'warning');
        return false;
      }
      return true;
    }
</script>