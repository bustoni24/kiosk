<div class="register-page">
    
<div class="register-box">
      <div class="register-logo">
        <a href="#"><?php echo 'Pembelian Tiket Bus'; ?></a>
      </div>
    
      <div class="card">
        <div class="card-body register-card-body">
    
          <form action="#" method="post">
            <div class="row justify-center">

              <div class="col-sm-3 col-relative pr-0">
              <div class="form-group">
                  <label>Dari</label>
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="DARI">
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
                  <input type="text" class="form-control" placeholder="KE">
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
                  <input type="text" class="form-control" placeholder="Tgl Berangkat">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="far fa-calendar-alt"></span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-2">
                <div class="input-group mb-3">
                  <input type="text" class="form-control" placeholder="Tgl Pulang (Opsional)">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="far fa-calendar-alt"></span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-1">
                <button type="submit" class="btn btn-primary btn-block">Cari</button>
              </div>
            </div>           
           
          </form>
  
        </div>
        <!-- /.form-box -->
      </div><!-- /.card -->
    </div>
</div>

<script>
    window.addEventListener('load', function() {
        checkToken();
    });
    var geoLoc = getLocation();
    var options = {
        enableHighAccuracy: true,
        timeout: 5000,
        maximumAge: 0
    };
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

    var titikId = null;
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
              console.log(data);
              titikId = data.message;
            },
            complete: function(){
                // setTitikId(latitude, longitude);
                console.log(titikId);
            },
            error: function () {
                console.log('failed');
            }
        });
    }

    function setTitikId(latitude, longitude)
    {

    }

    setInterval(checkToken, 1000 * 60 * 55); //10 menit
</script>