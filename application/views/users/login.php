<section style="padding-top: 2em; ">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-8 col-xl-5 ml-auto">
          <div class="row">
            <div class="col text-center">
              <span class="text-danger"><?php echo validation_errors(); ?></span>
              <?php if ($this->session->flashdata('account_activated')) { ?>
                <span class="text-success text-h3"><?= $this->session->flashdata('account_activated'); ?></span>
              <?php } ?>
              <?php if ($this->session->flashdata('pass_updated')) { ?>
               <span class="text-success"><?= $this->session->flashdata('pass_updated') ?></span>
              <?php } ?>
            </div>
          </div>
          <div class="row">
            <div class="col text-center">
              <h1><?php echo $title; ?></h1>
            </div>
          </div>
          <?php echo form_open('users/login'); ?>
          <div class="row align-items-center mt-2">
            <div class="col">
            <input type="email" name="email" class="form-control" id="email" value="<?php if(isset($_COOKIE['friendmii_ue'])) {echo $_COOKIE['friendmii_ue'];} ?> <?php echo set_value('address'); ?>" placeholder="E-mail" required>
            </div>
          </div>
          
          <div class="row align-items-center mt-2">
            <div class="col">
            <input type="password" name="password" class="form-control" id="password" value="<?php if(isset($_COOKIE['friendmii_up'])) {echo $_COOKIE['friendmii_up'];} ?>" placeholder="Password">
            </div>
          </div>
          <?php if ($this->session->flashdata('login_failed')) { ?>
               <span class="text-danger"><?= $this->session->flashdata('login_failed') ?></span>
          <?php } ?>
          <span class="text-danger"><?php echo form_error('password'); ?></span>
          <div class="row justify-content-start mt-3">
            <div class="col">
              <div class="form-check">
                <label class="form-check-label">
                  <input type="checkbox" name="remember" <?php if(isset($_COOKIE['friendmii_ue'])){?> checked <?php } ?> value="on" class="form-check-input">
                  Remember me
                </label>
                <a href="<?php echo base_url(); ?>users/recover" class="pull-right">Forgot Password?</a>
              </div>
              <button type="submit" id="submit-control" class="btn btn-primary btn-block mt-3" data-disable-with="Signing in...">SIGNIN</button>
            </div>
          </div>
          <p class="text-center mt-2">Don't have an Account? <a href="<?php echo base_url(); ?>users/signup">SIGN UP</a></p>
         <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </section>