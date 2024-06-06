<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
			  <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <!-- <img src="<?= Constant::getImageUrl().'/logo.png'; ?>" alt=""> -->
                  <span class="d-none d-lg-block"><?= Constant::PROJECT_NAME; ?></span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Buat Akun Baru</h5>
                    <p class="text-center small">Masukkan data diri Anda untuk mendaftar akun</p>
                  </div>

				  <?php
                    $form=$this->beginWidget('CActiveForm', array(
                      'id'=>'register-form',
                      'enableClientValidation'=>true,
                      'clientOptions'=>array(
                      'validateOnSubmit'=>false
                      ),
                      'htmlOptions' => ['class'=>'row g-3 needs-validation', 'novalidate' => true],
                    )); 
                    ?>
                    <div class="col-12">
                      <label for="yourName" class="form-label">Nama Lengkap</label>
                      <input type="text" name="User[nama]" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">Mohon isi nama lengkap!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Email</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="email" name="User[username]" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Mohon isi email!</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Kata sandi</label>
                      <input type="password" name="User[password]" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Mohon isi kata sandi!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourRePassword2" class="form-label">Ulang Kata sandi</label>
                      <input type="password" name="User[re_password]" class="form-control" id="yourRePassword2" required>
                      <div class="invalid-feedback">Kata sandi tidak cocok</div>
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required>
                        <label class="form-check-label" for="acceptTerms">Saya menyetujui <a href="#">syarat dan ketentuan</a> yang berlaku</label>
                        <div class="invalid-feedback">Mohon untuk dicentang!</div>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Buat Akun</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Sudah punya akun? <a href="<?= CController::createUrl('site/login'); ?>">Log in</a></p>
                    </div>
					<?php $this->endWidget(); ?>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

  <script>
  var password = document.getElementById("yourPassword2"), 
  confirm_password = document.getElementById("yourRePassword2");

  function validatePassword(){
    if(password.value != confirm_password.value) {
      confirm_password.setCustomValidity("Password Tidak Cocok");
    } else {
      confirm_password.setCustomValidity('');
    }
  }

  password.onchange = validatePassword;
  confirm_password.onkeyup = validatePassword;
</script>