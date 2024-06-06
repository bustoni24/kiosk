<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Admin</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= Constant::assetsUrl() ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= Constant::assetsUrl() ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= Constant::assetsUrl() ?>/dist/css/adminlte.min.css">
  <style>
    .login-box, .register-box {
        width: 500px;
    }
  </style>
  <?php
  Yii::app()->clientScript->scriptMap = array(
      'jquery.js' => false,
      'jquery.ba-bbq.js' => false
  );
  ?>
</head>
<body class="hold-transition login-page">
    <?= $content; ?>

<!-- jQuery -->
<script src="<?= Constant::assetsUrl() ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= Constant::assetsUrl() ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= Constant::assetsUrl() ?>/dist/js/adminlte.min.js"></script>
</body>
</html>