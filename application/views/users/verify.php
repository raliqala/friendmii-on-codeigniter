<div class="jumbotron text-center">
  <h1 class="display-3">Thank You!</h1>
  <p class="display-5 text-success text-center"><?php echo $title; ?></p>
  <p class="lead"><strong>Please check your email</strong> for further instructions on how to complete your account setup.</p>
  <hr>
  <p>
    <a href="<?php echo base_url(); ?>">go to home page</a>
  </p>
  <p class="lead">
    <a class="btn btn-primary btn-sm" target="_blank" href="https://www.google.com" role="button">Continue to your email account veirfy your email.</a>
    <input type="hidden" name="code" value="<?php echo $code; ?>">
  </p>
</div>