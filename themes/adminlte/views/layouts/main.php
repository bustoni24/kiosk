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
.col-sm-05 {
  display: flex;
    align-items: center;
    margin-bottom: 1rem !important;
}
.col-sm-05 i.fas {
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

body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .content-wrapper, body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-footer, body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-header {
        margin-left: 0;
    }
.nav-form {
  position: relative;
    width: 100%;
    padding-top: 2rem;
    background-color: #fff;
    border-bottom: 1px solid #ccc;
}
.align-baseline {
  align-items: baseline;
}
.main-header {
    background-color: var(--color-primary);
}
.p-0{
  padding: 0;
}
.mb-20 {
  margin-bottom: 20px;
}
.w-100 {
  width: 100%!important;
}
.homepage {
  width: 100%;
}
.homepage .content-header h1 {
    font-size: 1.5rem;
    margin: 0;
    font-weight: 600;
    color: var(--color-primary);
}
  </style>
</head>
<body class="hold-transition">
<div class="wrapper">
<div id="preloader" class="none">
    <div class="jumper">
        <h5 id="additionalText"></h5>
        <div class="box-loader"><div class="loader-04"></div></div>
    </div>
</div>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand">
<ul class="navbar-nav">
      <li class="nav-item">
      <div class="content-header p-0">
      <h1 class="text-white"><?= Constant::PROJECT_NAME ?></h1>
      </div>
      </li>
    </ul>
</nav>

<div class="content-wrapper">
<section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">

        <?php 
          echo $content;
        ?>

        </div>
      </div>
</section>
</div>

<!-- Main Footer -->
<footer class="main-footer">
    <strong>Copyright &copy; <?= date('Y') ?> <a href="#"><?= Constant::PROJECT_NAME ?></a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> beta
    </div>
  </footer>
</div>

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
            location.href="<?= Constant::baseUrl().'/' ?>";
          } else {
            $('#preloader').removeClass('none');
            swal.fire(data.message, '', 'error');
          }
        }
      });
    }
    setInterval(checkToken, 1000 * 60 * 55); //55 menit
</script>
</body>
</html>
