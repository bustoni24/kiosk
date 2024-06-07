<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= Constant::PROJECT_NAME; ?> | Admin</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  
  <?= AppAsset::registerCss(); ?>
  <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
  <style>
    :root {
      --color-primary: #f58220;
      --color-primary-hover: #da6400;
      --color-text-primary: #ffb03b;
      --bg-white: #fff;
    }
    .login-box, .register-box {
        width: 88vw;
    }
    .login-card-body, .register-card-body {
      background-color: #fff;
      border-top: 0;
      color: #3a3939;
      padding: 40px 20px 20px 20px;
      border-radius: 50px;
  }
  .login-page, .register-page {
    background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("<?= Constant::baseUrl() . '/images/background_bus.png' ?>");
    background-size: cover;
  }
  .form-control {
    border-right: 0;
    height: 55px;
}
.btn {
  height: 55px;
}
.btn-block+.btn-block {
    margin-top: 0;
}
.login-box .card, .register-box .card {
    margin-bottom: 0;
    border-radius: 20px;
}
.col-relative{
  position: relative;
}
.col-relative label {
  position: absolute;top:-25px;
}
.login-logo a, .register-logo a {
    color: #fff;
}
.btn-primary {
    background-color: var(--color-primary);
    border-color: var(--color-primary);
}
.btn-primary:hover {
    background-color: var(--color-primary-hover);
    border-color: var(--color-primary-hover);
}
.btn-primary.focus, .btn-primary:focus {
    background-color: var(--color-primary-hover);
    border-color: var(--color-primary-hover);
}
.register-card-body .col-sm-1 {
  -ms-flex: 0 0 13.333333%;
    flex: 0 0 13.333333%;
    max-width: 13.333333%;
}
.register-card-body .col-sm-05 {
  display: flex;
    align-items: center;
    margin-bottom: 1rem !important;
}
.register-card-body .col-sm-05 i.fas {
  border: 1px solid #858383;
    border-radius: 50%;
    padding: 2px;
    color: #858383;
    cursor: pointer;
}
.pr-0 {
  padding-right: 0;
}
.pl-0 {
  padding-left: 0;
}
#preloader .jumper{
text-align: center;
}
#preloader img {
width: 50%;
}
#preloader{
position: fixed;
z-index: 999;
width: 100%;
height: 100%;
display: flex;
align-items: center;
justify-content: center;
background-color: #383838f5;
}
#preloader .jumper{
text-align: center;
}
#preloader img {
width: 50%;
}
.none {
  display: none!important;
}
.justify-center {
  justify-content: center;
}
.select2-container--default .select2-selection--single {
    height: 55px;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    margin-top: 3px;
}
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

<div id="preloader" class="none">
    <div class="jumper">
        <h5 id="additionalText"></h5>
        <div class="box-loader"><div class="loader-04"></div></div>
    </div>
</div>

<?php 
  echo $content;
?>

<?= AppAsset::registerJs(); ?>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<script type="text/javascript">
    <?php
        //flashes
        foreach(Yii::app()->user->getFlashes() as $key => $message){
            ?>
            swal.fire('<?= $message ?>', '', '<?= $key ?>');
            <?php
        }
    ?>
    $(window).on('beforeunload', function() {
        $('#preloader').removeClass('none');
    });
    $(window).on('onunload', function() {
      $('#preloader').addClass('none');
    });

    window.addEventListener('load', function() {
        checkToken();
        $('select').select2();
    });
    function checkToken()
    {
      //check token
      $.ajax({
        url: "<?= Constant::baseUrl() . '/api/requestToken' ?>",
        type: 'get',
        dataType: 'JSON',
        success: function(data) {
          console.log(data);
          if (data.success) {
            $('#preloader').addClass('none');
          } else {
            $('#preloader').removeClass('none');
            swal.fire(data.message, '', 'error');
          }
        }
      });
    }
    setInterval(checkToken, 1000 * 60 * 55); //10 menit
</script>
</body>
</html>
