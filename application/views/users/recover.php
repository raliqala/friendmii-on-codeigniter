<section>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-8 col-xl-6">
          <div class="row mt-4">
             <?php if ($this->session->flashdata('error_cookie')) { ?>
                 <span class="col text-center text-danger"><?= $this->session->flashdata('error_cookie') ?></span>
            <?php } ?>
            <?php if ($this->session->flashdata('incorrect')) { ?>
                 <span class="col text-center text-danger"><?= $this->session->flashdata('incorrect') ?></span>
            <?php } ?>
          </div>
          <div class="row">
            <div class="col text-center">
              <h1 class="h3"><?php echo $title; ?></h1>
              <p class="text-h3">Please enter your email to reset your password</p>
            </div>
          </div>
          <?php echo form_open('users/recover'); ?>
          <div class="row align-items-center mt-2">
            <div class="col">
            <input type="email" name="email" class="form-control" value="" placeholder="Enter your email" required>
            <input type="hidden" class="hide" name="token" value="<?php echo validation_token(); ?>">
            </div>
          </div>
            <span class="text-danger"><?php echo validation_errors(); ?></span>
          <div class="row justify-content-start mt-3">
            <div class="col">
              <button type="submit" class="btn btn-primary btn-block mt-1" >Reset password</button>
            </div>
          </div>
          <p class="text-center mt-2"><a class="text-danger" href="<?php echo base_url(); ?>users/login">Cancel</a></p>
         <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </section>