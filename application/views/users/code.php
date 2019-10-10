<section>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-8 col-xl-6">
          <div class="row">
            <div class="col text-center">
              <h1 class="h3">Reset code</h1>
              <p class="text-h3"><?php echo $title; ?></p>
            </div>
          </div>
          <?php echo form_open('users/code'); ?>
          <div class="row align-items-center mt-2">
            <div class="col">
            <input type="text" name="code" class="form-control" value="" placeholder="######################">
            </div>
          </div>
            <span class="text-danger"><?php echo validation_errors(); ?></span>
          <div class="row justify-content-start mt-3">
            <div class="col">
              <button type="submit" class="btn btn-primary btn-block mt-1" >Continue</button>
            </div>
          </div>
          <p class="text-center mt-2"><a class="text-danger" href="<?php echo base_url(); ?>users/recover">Cancel</a></p>
         <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </section>