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
      --color-border: #bebcbc;
      --color-available: #fff;
      --color-men: #fa6262;
      --color-women: #629afa;
      --color-selected: #62fa79;
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
    padding: 3px;
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
    padding-top: 2.2rem;
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
.homepage, .seatmap {
  width: 100%;
}
.homepage .content-header h1, .seatmap .content-header h1 {
    font-size: 1.3rem;
    margin: 0;
    font-weight: 600;
    color: var(--color-primary);
}
.card-header>.card-tools {
    font-size: 1.1rem;
    font-weight: 600;
}
span.arrow{
        color:#000;font-size:13px;font-weight:700;
    }
    .time-info, .seat-info {
            font-size: 13px;
    }
    .route {
        font-size: 1.1rem;
    }
    .route .col-sm-5{
        flex: 0 0 41.666667%;
        max-width: 41.666667%;
    }
    .route .col-sm-2{
        -ms-flex: 0 0 16.666667%;
        flex: 0 0 16.666667%;
        max-width: 16.666667%;
    }
    .price-layout {
        justify-content: space-around;
    }
    .price-layout .price {
        text-align: center;
        font-size: 1.2rem;
        font-weight: 700;
        color: #721c24;
    }
    .additional-info {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        font-size: 16px;
        background-color: #f3e8dc;
        border-top: 1px solid #bfbfbf;
        width: 100%;
        padding: 10px 20px;
    }
    .list-view div.items {
        border: none;
        max-height: 500px;
        overflow-y: auto;
    }
    .border-custom {
        border: 1px solid #ccc;
    }
    .divider {
        background-color: #fff;
        padding: 20px 0px;
        margin-left: -1rem;
        margin-right: -1rem;
    }
    .no_available_trip{
        padding: 20px;
        font-size: 1.5rem;
        font-weight: 600;
        color: red;
    }
    .seatmap .checkbox-wrapper {
        display: inline-block;
        position: relative;
        padding-left: 30px;
        margin-bottom: 15px;
        cursor: pointer;
    }

    .seatmap .checkbox-wrapper input {
        opacity: 0;
        cursor: pointer;
    }

    .seatmap .checkmark {
        z-index: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        height: 45px;
        width: 45px;
        background-image: url('<?= Constant::iconSeat() ?>');
        background-size: cover;
        transform: translate(-50%, -50%);
    }

    .seatmap .checkbox-wrapper input:checked ~ .checkmark {
        z-index: 0;
        background-image: url('<?= Constant::iconSeat("selected") ?>');
        left: 65%;
    }

    .seatmap .booked {
        z-index: 0;
        background-image: url('<?= Constant::iconSeat("booked") ?>');
        left: 65%;
    }
    .seatmap .booked-girl {
        z-index: 0;
        background-image: url('<?= Constant::iconSeat("temporary") ?>');
    }
    .seatmap .text-checkmark{
        position:absolute;
        top: 70%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-weight: 700;
        font-size: smaller;
    }
    .seatmap table.table-deck>tbody>tr>td {
        padding: 2px;
    }
    .seatmap .table-deck .checkbox{
        margin-top: 10px;
    }
    .seatmap .img-icon {
        width: 60px;
    }
    .seatmap .door {
        vertical-align: middle!important;
    text-align: center;
    background-color: antiquewhite;
    min-height: 7vh;
    }
    .seatmap .contact-form div, .seatmap .contact-form label {
    padding: 10px;
}
.seatmap p {
    margin-bottom: 5px;
}
.time-info, .seat-info {
            font-size: 12px;
        }
        .layout-seat {
            padding: 20px;
        }
        .layout-seat .head-title {
            text-align: center;
            padding: 10px;
            background-color: #fff;
            font-weight: 700;
        }
        .layout-seat .subhead-title {
            padding: 10px;
            font-size: 12px;
        }
        .layout-form .head-title {
            padding: 10px;
            background-color: #fff;
            font-weight: 700;
        }
        .justify-center {
            justify-content: center;
        }
        .justify-between {
            justify-content: space-between;
        }
        .legend {
            padding: 1px 8px;
            border: 1px solid var(--color-border);
            border-radius: 50%;
            margin-right: 5px;
            margin-left: 5px;
        }
        .legend-available {
            background-color: var(--color-available);
        }
        .legend-men {
            background-color: var(--color-men);
            border-color: var(--color-available);
        }
        .legend-women {
            background-color: var(--color-women);
            border-color: var(--color-available);
        }
        .legend-selected {
            background-color: var(--color-selected);
            border-color: var(--color-available);
        }
        .border-none {
            border: none;
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

    jQuery(function($) { $.extend({
    form: function(url, data, method) {
        if (method == null) method = 'POST';
        if (data == null) data = {};

        var form = $('<form>').attr({
            method: method,
            action: url
         }).css({
            display: 'none'
         });

        var addData = function(name, data) {
            if ($.isArray(data)) {
                for (var i = 0; i <= data.length; i++) {
                    var value = data[i];
                    addData(name + '[]', value);
                }
            } else if (typeof data === 'object') {
                for (var key in data) {
                    if (data.hasOwnProperty(key)) {
                        addData(name + '[' + key + ']', data[key]);
                    }
                }
            } else if (data != null) {
                form.append($('<input>').attr({
                  type: 'hidden',
                  name: String(name),
                  value: String(data)
                }));
            }
        };

        for (var key in data) {
            if (data.hasOwnProperty(key)) {
                addData(key, data[key]);
            }
        }

        return form.appendTo('body');
    }
});
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
