<?= $this->renderPartial('_navbar', ['model' => $model, 'listTujuan' => $listTujuan, 'arrTujuan' => $arrTujuan], false); ?>

<div class="homepage">

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>Jadwal Berangkat</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
</section>

<div class="card w-100">
        <div class="card-header">
          <h3 class="card-title">Title</h3>

          <div class="card-tools">
            <?= $this->ShortIndonesiaTgl($model->startdate); ?>
          </div>
        </div>
        <div class="card-body">
          Check the Header part you can find Legacy vesion of style.
          <br>
          Start creating your amazing application!
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          Footer
        </div>
        <!-- /.card-footer-->
</div>
       

<?php if (isset($model->enddate)): ?>

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>Jadwal Pulang</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
</section>

<div class="card w-100">
        <div class="card-header">
          <h3 class="card-title">Title</h3>

          <div class="card-tools">
            <?= $this->ShortIndonesiaTgl($model->enddate); ?>
          </div>
        </div>
        <div class="card-body">
          Check the Header part you can find Legacy vesion of style.
          <br>
          Start creating your amazing application!
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          Footer
        </div>
        <!-- /.card-footer-->
</div>

<?php endif; ?>

</div>