<section>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-8 col-xl-6">
          <div class="row">
             <?php if ($this->session->flashdata('reset_pass')) { ?>
                 <h5 class="col text-center mt-3 text-success"><?= $this->session->flashdata('reset_pass') ?></h5>
             <?php } ?>
          </div>
          <div class="row">
            <div class="col text-center">
              <h3><?php echo $title; ?></h3>
            </div>
          </div>
          <?php echo form_open('users/reset'); ?>
          <div class="row align-items-center mt-2">
            <div class="col">
            <input type="password" name="password" class="form-control" value="" placeholder="New Password">
            </div>
          </div>
          <span class="text-danger"></span>
          <div class="row align-items-center mt-2">
            <div class="col">
            <input type="password" name="password2" class="form-control" value="" placeholder="Confirm new password">
            </div>
            <input type="hidden" class="hide" name="token" value="<?php echo validation_token(); ?>">
          </div>
          <span class="text-danger"><?php echo validation_errors(); ?></span>
          <div class="row justify-content-start mt-3">
            <div class="col">
              <button type="submit" class="btn btn-primary btn-block mt-3" >RESET</button>
            </div>
          </div>
          <p class="text-center mt-2"><a class="text-danger" href="<?php echo base_url(); ?>/users/login">Cancel</a></p>
         <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </section>
      