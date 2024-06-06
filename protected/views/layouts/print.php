<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= Constant::PROJECT_NAME; ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <?= AppAsset::registerCss(); ?>
    <style>
        @media print{
                @page {size: 210mm 148mm;margin: 0px 10px;}
                body { margin: 0px 10px; }
            }
        @media print {
            html, body {
            width: 210mm;
            height: auto;
          }
        /* ... the rest of the rules ... */
        } 
          .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
        }
       
        .d-flex {
            display: flex;
        }
        .justify-content-center{
            justify-content: center;
        }
        table.border-none>tbody>tr>td{
            border: none!important;
        }
        .ln_black{
            border: 1.5px solid;
        }
        table.head-print > tbody > tr > td {
          padding: 2px;
        }
        .table-bordered>tbody>tr>td.no-border, .table>tbody>tr>td.no-border, .table>tbody>tr>th.no-border{
          border-top: none;
          border-bottom: none;
        }
        p {
          margin: 0;
      }
      td span {
          line-height: 1.42857143!important;
        }
    .table>tbody>tr>td {
      padding: 4px;
    }
    table.head-print > tbody > tr > td {
      font-size: 70%;
    }
    table.table-content > thead > tr > td h3{
      font-size: 140%;
    }
    table.table-content > thead > tr > td h5{
      font-size: 100%;
    }
    table.table-content > tbody > tr > td, table.table-content > tbody > tr > td p{
      font-size: 90%;
    }
    </style>
  </head>

  <body onLoad="javascript:window.print();">
    <div>
        <?= $content; ?>
    </div>

    <?= AppAsset::registerJs(); ?>
  </body>
</html>