<style>
    ._failed{ border-bottom: solid 4px red !important; }
._failed i{  color:red !important;  }

._success {
    box-shadow: 0 15px 25px #00000019;
    padding: 45px;
    width: 100%;
    text-align: center;
    margin: 40px auto;
    border-bottom: solid 4px #28a745;
}

._success i {
    font-size: 55px;
    color: #28a745;
}

._success h2 {
    margin-bottom: 12px;
    font-size: 40px;
    font-weight: 500;
    line-height: 1.2;
    margin-top: 10px;
}

._success p {
    margin-bottom: 0px;
    font-size: 18px;
    color: #495057;
    font-weight: 500;
}
.btn {
    height: auto;
}
</style>

<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="message-box _success">
                     <i class="fa fa-check-circle" aria-hidden="true"></i>
                    <h2> Pembayaran Tiket berhasil </h2>
                   <p> Terimakasih sudah mempercayai Efisiensi, <br>
                    silahkan klik <a class="btn btn-success" href="<?= Constant::baseUrl().'/front/cetakTiket?id=' . $modelBooking->id ?>">Download Tiket</a> untuk mendapatkan tiket elektronik Anda</p>      
                </div> 

                <div class="row">
                    <div class="col-sm-12">
                        <a href="<?= Constant::baseUrl().'/' ?>" class="btn btn-info">Kembali ke Beranda</a>
                    </div>
                </div>
        </div> 
    </div>   
</div> 

<script>
window.addEventListener('load', function() {
    setTimeout(function() {
        location.href = "<?= Constant::baseUrl() . '/' ?>";
    }, 1000 * 60 * 10);
});
setTimeout(function() {
    $('#preloader').addClass('none');
}, 2000);
</script>