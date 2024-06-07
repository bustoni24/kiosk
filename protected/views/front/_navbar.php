    
<div class="nav-form">
<?php $form=$this->beginWidget('CActiveForm', array(
          'id'=>'homepage-form',
          // Please note: When you enable ajax validation, make sure the corresponding
          // controller action is handling ajax validation correctly.
          // There is a call to performAjaxValidation() commented in generated controller code.
          // See class documentation of CActiveForm for details on this.
          'enableAjaxValidation'=>false,
          'action' => Constant::baseUrl().'/'.$this->route,
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

              <div class="col-sm-2 col-relative">
              <div class="form-group">
                  <label>Tgl Berangkat</label>
                <div class="input-group mb-3">
                  <?= CHtml::textField("startdate", $model->startdate, ['readonly' => true, 'class' => 'form-control', 'placeholder' => 'Tgl Berangkat', 'required' => true]) ?>
                </div>
              </div>
              </div>

              <div class="col-sm-2 col-relative">
              <div class="form-group">
                  <label>Tgl Pulang (Opsional)</label>
                <div class="input-group mb-3">
                <?= CHtml::textField("enddate", $model->enddate, ['readonly' => true, 'class' => 'form-control', 'placeholder' => 'Tgl Pulang (Opsional)']) ?>
                </div>
              </div>
              </div>

              <div class="col-sm-1">
                <button type="submit" onclick="return submitted()" class="btn btn-primary btn-block">Cari</button>
              </div>
            </div>           
           
          <?php $this->endWidget(); ?>
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
    });
</script>