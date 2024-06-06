<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <title>iHospital</title>
        <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/font-awesome.css">
        <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui-bootstrap.css">
        <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/datepicker3.css">
        <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/material-design-iconic-font.css">
        <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.css">
        <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/animate.css">
        <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/layout.css">
        <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/components.css">
        <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/widgets.css">
        <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/plugins.css">
        <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/pages.css">
        <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-extend.css">
        <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/common.css">
        <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/responsive.css"> 
        <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/small-box.css"> 

        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/jquery.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.ba-bbq.js"></script>
        <?php
        // }
        Yii::app()->clientScript->scriptMap = array(
          'jquery.js' => false,
          'jquery.ba-bbq.js' => false
        );
        ?>


        <link href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.ico" rel="SHORTCUT ICON" />
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/eModal.min.js"></script> 
        <script type="text/javascript">
            function showModal(url) {
                eModal.ajax(url, 'Informasi');
            }
        </script>

        <style>
            textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input {
                background-color: #ffffff;
                border: 1px solid #cccccc;
                -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
                -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
                box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
                -webkit-transition: border linear 0.2s, box-shadow linear 0.2s;
                -moz-transition: border linear 0.2s, box-shadow linear 0.2s;
                -o-transition: border linear 0.2s, box-shadow linear 0.2s;
                transition: border linear 0.2s, box-shadow linear 0.2s;
            }

            select, textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input {
                display: inline-block;
                padding: 4px 6px;
                margin-bottom: 3px;
                font-size: 11px;
                line-height: 20px;
                color: #555555;
                vertical-align: middle;
                -webkit-border-radius: 4px;
                -moz-border-radius: 4px;
                border-radius: 4px;
            }

            h1{
                font: 22px 'Poppins',Helvetica,Arial,sans-serif !important;
                color:#1f677b;/*#337ab7;*/
                font-weight:bold;
            }

            .breadcrumbs{
                font-style:italic;
                float:left;
                margin-top: -40px;
            }

            td{
                color:#4d4d4d;
                font-size:11px;
            }
            body{
                font-family: 'Poppins',Helvetica,Arial,sans-serif;
                font-weight: 400;
            }

            .grid-view .button-column {    
                width: 100px;
            }

            li.next a {
                margin-top: 6px;
                margin-left: 3px;
            }

            select{
                background: #efefef;
            }

            .input-group-addon {
                color: #ffffff;    
            }

            /* NAV BAR*/

            .grid-view table.items th {
                background: #3490a9;
                background: -moz-linear-gradient(#3490a9, #1f677b);
                background: -ms-linear-gradient(#3490a9, #1f677b);
                background: -o-linear-gradient(#3490a9, #1f677b);
                background: -webkit-gradient(linear, 0 0, 0 100%, from(#3490a9), to(#1f677b));
                background: -webkit-linear-gradient(#3490a9, #1f677b);
                background: linear-gradient(#3490a9, #1f677b);

            }

            .badge{
                position: absolute;
                margin-top: -30px;
                margin-left: 15px;
                background:red;
            }

            .navbar-default .dropdown-menu.notify-drop {
                min-width: 330px;
                background-color: #fff;
                min-height: 360px;
                max-height: 360px;
            }
            .navbar-default .dropdown-menu.notify-drop .notify-drop-title {
                border-bottom: 1px solid #e2e2e2;
                padding: 5px 15px 10px 15px;
            }
            .navbar-default .dropdown-menu.notify-drop .drop-content {
                min-height: 280px;
                max-height: 280px;
                overflow-y: scroll;
            }
            .navbar-default .dropdown-menu.notify-drop .drop-content::-webkit-scrollbar-track
            {
                background-color: #F5F5F5;
            }

            .navbar-default .dropdown-menu.notify-drop .drop-content::-webkit-scrollbar
            {
                width: 8px;
                background-color: #F5F5F5;
            }

            .navbar-default .dropdown-menu.notify-drop .drop-content::-webkit-scrollbar-thumb
            {
                background-color: #ccc;
            }
            .navbar-default .dropdown-menu.notify-drop .drop-content > li {
                border-bottom: 1px solid #e2e2e2;
                padding: 10px 0px 5px 0px;
            }
            .navbar-default .dropdown-menu.notify-drop .drop-content > li:nth-child(2n+0) {
                background-color: #fafafa;
            }
            .navbar-default .dropdown-menu.notify-drop .drop-content > li:after {
                content: "";
                clear: both;
                display: block;
            }
            .navbar-default .dropdown-menu.notify-drop .drop-content > li:hover {
                background-color: #fcfcfc;
            }
            .navbar-default .dropdown-menu.notify-drop .drop-content > li:last-child {
                border-bottom: none;
            }
            .navbar-default .dropdown-menu.notify-drop .drop-content > li .notify-img {
                float: left;
                display: inline-block;
                width: 45px;
                height: 45px;
                margin: 0px 0px 8px 0px;
            }
            .navbar-default .dropdown-menu.notify-drop .allRead {
                margin-right: 7px;
            }
            .navbar-default .dropdown-menu.notify-drop .rIcon {
                float: right;
                color: #999;
            }
            .navbar-default .dropdown-menu.notify-drop .rIcon:hover {
                color: #333;
            }
            .navbar-default .dropdown-menu.notify-drop .drop-content > li a {
                font-size: 12px;
                font-weight: normal;
            }
            .navbar-default .dropdown-menu.notify-drop .drop-content > li {
                font-weight: bold;
                font-size: 11px;
            }
            .navbar-default .dropdown-menu.notify-drop .drop-content > li hr {
                margin: 5px 0;
                width: 70%;
                border-color: #e2e2e2;
            }
            .navbar-default .dropdown-menu.notify-drop .drop-content .pd-l0 {
                padding-left: 0;
            }
            .navbar-default .dropdown-menu.notify-drop .drop-content > li p {
                font-size: 11px;
                color: #666;
                font-weight: normal;
                margin: 3px 0;
            }
            .navbar-default .dropdown-menu.notify-drop .drop-content > li p.time {
                font-size: 10px;
                font-weight: 600;
                top: -6px;
                margin: 8px 0px 0px 0px;
                padding: 0px 3px;
                border: 1px solid #e2e2e2;
                position: relative;
                background-image: linear-gradient(#fff,#f2f2f2);
                display: inline-block;
                border-radius: 2px;
                color: #B97745;
            }
            .navbar-default .dropdown-menu.notify-drop .drop-content > li p.time:hover {
                background-image: linear-gradient(#fff,#fff);
            }
            .navbar-default .dropdown-menu.notify-drop .notify-drop-footer {
                border-top: 1px solid #e2e2e2;
                bottom: 0;
                position: relative;
                padding: 8px 15px;
            }
            .navbar-default .dropdown-menu.notify-drop .notify-drop-footer a {
                color: #777;
                text-decoration: none;
            }
            .navbar-default .dropdown-menu.notify-drop .notify-drop-footer a:hover {
                color: #333;
            }    

            .dropdown-submenu{position:relative;}
            .dropdown-submenu>.dropdown-menu{top:0;left:100%;margin-top:-6px;margin-left:-1px;-webkit-border-radius:0 6px 6px 6px;-moz-border-radius:0 6px 6px 6px;border-radius:0 6px 6px 6px;}
            .dropdown-submenu:hover>.dropdown-menu{display:block;}
            .dropdown-submenu>a:after{display:block;content:" ";float:right;width:0;height:0;border-color:transparent;border-style:solid;border-width:5px 0 5px 5px;border-left-color:#cccccc;margin-top:5px;margin-right:-10px;}
            .dropdown-submenu:hover>a:after{border-left-color:#ffffff;}
            .dropdown-submenu.pull-left{float:none;}.dropdown-submenu.pull-left>.dropdown-menu{left:-100%;margin-left:10px;-webkit-border-radius:6px 0 6px 6px;-moz-border-radius:6px 0 6px 6px;border-radius:6px 0 6px 6px;}

            .grid-view table.items tbody tr:hover {
                background: #7bffe5;
            }

            .grid-view table.items tr.odd {
                background: #d3fbf3;
            }

            .btn {
                display: inline-block;
                *display: inline;
                padding: 4px 12px;
                margin-bottom: 0;
                *margin-left: .3em;
                font-size: 12px;
                line-height: 20px;
                color: #333333;
                text-align: center;
                /*text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);*/
                vertical-align: middle;
                cursor: pointer;
                background-color: #f5f5f5;
                *background-color: #e6e6e6;
                background-image: -moz-linear-gradient(top, #ffffff, #e6e6e6);
                background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#e6e6e6));
                background-image: -webkit-linear-gradient(top, #ffffff, #e6e6e6);
                background-image: -o-linear-gradient(top, #ffffff, #e6e6e6);
                background-image: linear-gradient(to bottom, #ffffff, #e6e6e6);
                background-repeat: repeat-x;
                border: 1px solid #aaaaaa;
                *border: 0;
                border-color: #e6e6e6 #e6e6e6 #bfbfbf;
                border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
                border-bottom-color: #aaaaaa;
                -webkit-border-radius: 4px;
                -moz-border-radius: 4px;
                border-radius: 4px;
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff', endColorstr='#ffe6e6e6', GradientType=0);
                filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
                *zoom: 1;
                -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
                -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
                box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
            }

            .btn-mini{
                padding:2px 6px;
                margin-right: 10px;
            }

            .btn-success {
                color: #ffffff;                
                background-color: #5bb75b;
                *background-color: #51a351;
                background-image: -moz-linear-gradient(top, #62c462, #51a351);
                background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#62c462), to(#51a351));
                background-image: -webkit-linear-gradient(top, #62c462, #51a351);
                background-image: -o-linear-gradient(top, #62c462, #51a351);
                background-image: linear-gradient(to bottom, #62c462, #51a351);
                background-repeat: repeat-x;
                border-color: #51a351 #51a351 #387038;
                border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff62c462', endColorstr='#ff51a351', GradientType=0);
                filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
            }


            .btn-info {
                color: #ffffff;
                text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
                background-color: #49afcd;
                *background-color: #2f96b4;
                background-image: -moz-linear-gradient(top, #5bc0de, #2f96b4);
                background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#5bc0de), to(#2f96b4));
                background-image: -webkit-linear-gradient(top, #5bc0de, #2f96b4);
                background-image: -o-linear-gradient(top, #5bc0de, #2f96b4);
                background-image: linear-gradient(to bottom, #5bc0de, #2f96b4);
                background-repeat: repeat-x;
                border-color: #2f96b4 #2f96b4 #1f6377;
                border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff5bc0de', endColorstr='#ff2f96b4', GradientType=0);
                filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
            }

            .btn-danger {
                color: #ffffff;
                text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
                background-color: #da4f49;
                *background-color: #bd362f;
                background-image: -moz-linear-gradient(top, #ee5f5b, #bd362f);
                background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ee5f5b), to(#bd362f));
                background-image: -webkit-linear-gradient(top, #ee5f5b, #bd362f);
                background-image: -o-linear-gradient(top, #ee5f5b, #bd362f);
                background-image: linear-gradient(to bottom, #ee5f5b, #bd362f);
                background-repeat: repeat-x;
                border-color: #bd362f #bd362f #802420;
                border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffee5f5b', endColorstr='#ffbd362f', GradientType=0);
                filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
            }

            .btn-warning {
                color: #ffffff;
                text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
                background-color: #faa732;
                *background-color: #f89406;
                background-image: -moz-linear-gradient(top, #fbb450, #f89406);
                background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#fbb450), to(#f89406));
                background-image: -webkit-linear-gradient(top, #fbb450, #f89406);
                background-image: -o-linear-gradient(top, #fbb450, #f89406);
                background-image: linear-gradient(to bottom, #fbb450, #f89406);
                background-repeat: repeat-x;
                border-color: #f89406 #f89406 #ad6704;
                border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fffbb450', endColorstr='#fff89406', GradientType=0);
                filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
            }

            .row{
                margin-left:5px;
            }    

            .urgent, .urgent td{
                background:#efaaaa;
                color:#333;
            }

            .tab-content{
                padding:10px;
            }

            .grid-view table.items th, .grid-view table.items td {
                padding: 0.1em;
            }


            .bold{
                font-weight: bold;
                color:#3cabc9;
            }

            .w50{
                width:50px;
            }

            .ui-widget-header {
                background: #1f677b !important;
                background: -moz-linear-gradient(#308aa2, #1f677b) !important;
                background: -ms-linear-gradient(#308aa2, #1f677b) !important;
                background: -o-linear-gradient(#308aa2, #1f677b) !important;
                background: -webkit-gradient(linear, 0 0, 0 100%, from(#308aa2), to(#1f677b)) !important;
                background: -webkit-linear-gradient(#308aa2, #1f677b) !important;
                background: linear-gradient(#308aa2, #1f677b) !important;
            }
            .errorSummary >ul{
                color: red;
            }
            .errorMessage{
                margin-top: 20px;
                color: #8a0303;
                border: 1px solid #a50707;
                padding: 3px;
                background: #f7545454;
            }
        </style>

    </head>
    <body class="leftbar-view">
        <!--Topbar Start Here-->
        <header class="topbar clearfix">
            <!--Top Search Bar Start Here-->
            <div class="top-search-bar">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="search-input-addon">
                                <span class="addon-icon"><i class="zmdi zmdi-search"></i></span>
                                <input type="text" class="form-control top-search-input" placeholder="Search">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Top Search Bar End Here-->
            <!--Topbar Left Branding With Logo Start-->
            <div class="topbar-left pull-left">
                <div class="clearfix" >
                    <ul class="left-branding pull-left clickablemenu ttmenu dark-style menu-color-gradient">
                        <li><span class="left-toggle-switch"><i class="zmdi zmdi-menu" style="color:#ffffff"></i></span></li>
                        <li>
                            <div class="logo" style="padding-top:20px; margin-left:30px;">
                                <a href="<?php echo Yii::app()->request->baseUrl . "/home"; ?>" title="iHospital" style="color:#e4e0fb; padding-top:10px;"><div class="clearfix"><span style="font-size: 20px; font-weight:bold;color:#ffffff; line-height: 0px;">iHOSPITAL</span></a>
                            </div>
                        </li>
                    </ul>
                    <!--Mobile Search and Rightbar Toggle-->

                </div>
            </div>
            <!--Topbar Left Branding With Logo End-->
            <!--Topbar Right Start-->


            <div class="topbar-right pull-right">
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <!--<a class="navbar-brand" href="<?php echo Yii::app()->request->baseUrl; ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/sinar-joyoboyo.png" width="32px"></a>-->
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                            <ul class="nav navbar-nav navbar-right">

                                <li><br>Demo Version</li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="zmdi zmdi-account-circle zmdi-hc-2x"></i> </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/user/updateProfile/">Edit Profil</a></li>
                                        <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/user/changepwd">Ubah Password</a></li>
                                        <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/site/logout/">Log Out</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div><!-- /.navbar-collapse -->
                    </div><!-- /.container-fluid -->
                </nav>        


            </div>
        </div>
        <!--Topbar Right End-->
    </header>
    <!--Topbar End Here-->

    <!--Leftbar Start Here-->
    <aside class="leftbar pull-left">
        <div class="left-aside-container">
            <div class="user-profile-container">

                <div class="admin-bar">
                    <ul>
                        <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/site/logout"><i class="zmdi zmdi-power" style="color:#efefef; font-size:2em;"></i>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>

            <ul class="list-accordion tree-style" style="margin-bottom: 35px;">
                <?php if (isset(Yii::app()->user->permission) && in_array("registrasi", Yii::app()->user->permission)) { ?>
                    <li>
                        <a href="#"><i class="zmdi zmdi-edit"></i><span class="list-label">PENDAFTARAN</span></a>
                        <ul>                         
                            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/registrasi?f=1">Umum</a></li>
                            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/registrasi?f=2">BPJS</a></li>   
                            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/registrasi/list">Data Registrasi</a></li>   
                            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/pasien">Data Pasien</a></li> 
                            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/registrasi/getStatistik">Statistik Pasien</a></li>   
                        </ul>
                    </li>
                <?php } ?>

                <?php if (isset(Yii::app()->user->permission) && 
                    (in_array("perawat", Yii::app()->user->permission)) ||
                    (in_array("dokter", Yii::app()->user->permission))||
                    (in_array("mapping", Yii::app()->user->permission))
                    ) { ?>
                <li>
                    <a href="#"><i class="zmdi zmdi-hospital"></i><span class="list-label">RAWAT JALAN</span></a>
                    <ul>  
                        <?php if (isset(Yii::app()->user->permission) && in_array("perawat", Yii::app()->user->permission)) { ?>
                            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/periksaperawat">Form Perawat</a></li>
                        <?php } ?>
                        <?php if (isset(Yii::app()->user->permission) && in_array("dokter", Yii::app()->user->permission)) { ?>
                            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/periksadokter">Form Dokter</a></li>
                        <?php } ?>
                        <?php if (isset(Yii::app()->user->permission) && in_array("mapping", Yii::app()->user->permission)) { ?>
                            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/diagnosis">Mapping Diagnosis</a></li>                                                        
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>

                <?php if (isset(Yii::app()->user->permission) && in_array("laboratorium", Yii::app()->user->permission)) { ?>
                    <li>
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/laboratorium"><i class="zmdi zmdi-file-text"></i><span class="list-label">LABORATORIUM</span></a>
                    </li>
                <?php } ?>

                <?php if (isset(Yii::app()->user->permission) && in_array("radiologi", Yii::app()->user->permission)) { ?>
                    <li>
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/radiologi"><i class="zmdi zmdi-shield-check"></i><span class="list-label">RADIOLOGI</span></a>
                    </li>
                <?php } ?>

                <?php if (isset(Yii::app()->user->permission) && in_array("fisioterapi", Yii::app()->user->permission)) { ?>
                    <li>
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/fisioterapi"><i class="zmdi zmdi-male"></i><span class="list-label">FISIOTERAPI</span></a>
                    </li>
                <?php } ?>

                <?php if (isset(Yii::app()->user->permission) && in_array("penunjang_lain", Yii::app()->user->permission)) { ?>
                    <li>
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/penunjangLain"><i class="zmdi zmdi-view-list"></i><span class="list-label">PENUNJANG LAIN</span></a>
                    </li>
                <?php } ?>

                <?php if (isset(Yii::app()->user->permission) && in_array("farmasi-apoteker", Yii::app()->user->permission)) { ?>                
                    <li>
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/farmasi"><i class="zmdi zmdi-hospital-alt"></i><span class="list-label">INSTALASI FARMASI</span></a>
                    </li>
                <?php } ?>

                <?php if (isset(Yii::app()->user->permission) && in_array("farmasi-gudang", Yii::app()->user->permission)) { ?>                
                    <li>
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/gudangfarmasi"><i class="zmdi zmdi-storage"></i><span class="list-label">GUDANG FARMASI</span></a>
                    </li>
                <?php } ?>



                <?php if (isset(Yii::app()->user->permission) && in_array("gudang", Yii::app()->user->permission)) { ?>                
                    <li><a style="font-weight:bold;">PERSEDIAAN</a></li>               

                    <li>
                        <a href="#"><i class="zmdi zmdi-settings"></i><span class="list-label">KONFIGURASI</span></a>
                        <ul>
                          <!--  <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/user">Pengguna</a></li>
                            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/role">Role</a></li>
                            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/permission">Akses</a></li> -->
                            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/barang">Master Barang</a></li>
                            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/instalasi">Instalasi</a></li>                            
                            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/supplier">Supplier</a></li>
                            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/masterTindakan">Tindakan</a></li>
                            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/setTarif">Tarif</a></li>

                        </ul>
                    </li>
                   
                    <li>
                        <a href="#"><i class="zmdi zmdi-swap"></i><span class="list-label">PERMINTAAN</span></a>
                        <ul>                                                   
                            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/spp">SPP Gudang</a></li>    
                            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/setSpp">Cetak Penawaran</a></li>
                            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/penawaran">Penawaran Masuk</a></li>
                            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/penerimaan">Penerimaan</a></li>
                            <!--<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/penerimaan/stok">Kartu Stok</a></li>-->
                            
                        </ul>
                    </li>
                    
                    <li>
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/demo/rekapGudang"><i class="zmdi zmdi-storage"></i><span class="list-label"> REKAPITULASI GUDANG</span></a>
                    </li>
                             

                <li>
                    <a href="#"><i class="zmdi zmdi-swap"></i><span class="list-label">PENGELUARAN</span></a>
                    <ul>                       
                        <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/demo/requestPelayanan">Pelayanan</a></li>  

                        <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/kerusakan">Laporan Kerusakan</a></li>    
                        <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/telaah">Telaah Staf</a></li>    
                        <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/demo/requestReparasi">Reparasi</a></li>  
                        <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/demo/oret">Pengembalian</a></li>

                        <!--                <li>
                                            <a href="<?php echo Yii::app()->request->baseUrl; ?>/penerimaan/stok"><i class="zmdi zmdi-storage"></i><span class="list-label">KARTU STOK</span></a>
                                        </li> -->

                    </ul>
                </li>    
                <?php } ?> 

                <li><a style="font-weight:bold;">LAPORAN</a></li>
                <?php if (isset(Yii::app()->user->permission) && in_array("keuangan", Yii::app()->user->permission)) { ?>

                    <li>
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/penerimaan/finansial">&nbsp;<i class="zmdi zmdi-money"></i><span class="list-label"> &nbsp;KEUANGAN</span></a>
                    </li>
                    <li>
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/demo/laporanHutang"><i class="zmdi zmdi-library"></i><span class="list-label"> LAPORAN HUTANG</span></a>
                    </li>

                    <li>
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/demo/rekapPersediaan"><i class="zmdi zmdi-storage"></i><span class="list-label"> REKAPITULASI PERSEDIAAN</span></a>
                    </li>
                    <li>
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/laporan/Akuntansi"><i class="zmdi zmdi-money-box"></i><span class="list-label"> AKUNTANSI</span></a>
                    </li>  
                    <li>
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/laporan/KaAkuntansi"><i class="zmdi zmdi-account"></i><span class="list-label"> KA AKUNTANSI</span></a>
                    </li>  
                    <li>
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/laporan/RekapBiaya"><i class="zmdi zmdi-money"></i><span class="list-label"> &nbsp;&nbsp;REKAPITULASI BIAYA</span></a>
                    </li>  
                <?php } ?>



                <!--NEW REPORT-->
                <?php if (isset(Yii::app()->user->permission) && in_array("farmasi-gudang", Yii::app()->user->permission)) { ?>
                    <li>
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/laporan/KaRajal"><i class="zmdi zmdi-account"></i><span class="list-label"> KA RAJAL & DEPO</span></a>
                    </li>  
                    <li>
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/laporan/KaFarmasi"><i class="zmdi zmdi-account-circle"></i><span class="list-label"> KA FARMASI</span></a>
                    </li>
                    <li>
                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/laporan/kartuGudang"><i class="zmdi zmdi-storage"></i><span class="list-label"> KARTU GUDANG</span></a>
                    </li>
                <?php } ?>
                





            </ul>
        </div>
    </aside>
    <!--Leftbar End Here-->
    <!--Page Container Start Here-->
    <section class="main-container" id="maincont">
        <div class="container-fluid">
            <div class="page-header filled full-block light">
                <div class="row">

                    <?php if (isset($this->breadcrumbs)): ?>
                        <?php
                        $this->widget('zii.widgets.CBreadcrumbs', array(
                          'links' => $this->breadcrumbs,
                        ));
                        ?><!-- breadcrumbs -->
                    <?php endif ?>

                    <?php echo $content; ?>
                </div>
            </div>
        </div>
    </div>


</section>
<!--Page Container End Here-->

<!--Footer Start Here -->
<footer class="footer-container">
    <div class="container-fluid">
        <div class="row">

            <div class="footer-right pull-right">
                <span style="color:#f2f3f5">Intelligently Integrated Hospital © 2019</span>
            </div>


        </div>
    </div>
</footer>
<!--Footer End Here -->


<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/jquery-migrate.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/bootstrap.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/jRespond.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/nav.accordion.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/hover.intent.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/hammerjs.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/scrollup.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/jquery.slimscroll.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/jquery.hammer.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/smart-resize.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/apps.js"></script>
</body>
</html>
