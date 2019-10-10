
  <section style="padding-top: 0em; ">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-8 col-xl-5 ml-auto">
          <div class="row">
            <div class="col text-center">
              <h2><?php echo $title; ?></h2>
              <p class="text-h3">Signup to make friends and find your match closer to you</p>
              <span class="text-danger"><?php echo form_error('password2'); ?></span>
            </div>
          </div>
          <?php echo form_open('users/signup'); ?>
            <div class="row align-items-center mt-2">
              <div class="col">
              <input type="text" name="firstname" class="form-control" value="<?php echo set_value('firstname'); ?>" placeholder="First Name">
              </div>
            </div>
            <span class="text-danger"><?php echo form_error('firstname'); ?></span>
            <div class="row align-items-center mt-2">
              <div class="col">
              <input type="text" name="lastname" class="form-control" value="<?php echo set_value('lastname'); ?>" placeholder="Last Name" >
              </div>
            </div>
            <span class="text-danger"><?php echo form_error('lastname'); ?></span>
            <div class="row align-items-center mt-2">
              <div class="col">
              <input type="email" name="email" class="form-control" value="<?php echo set_value('email'); ?>" placeholder="E-mail" >
              </div>
            </div>
            <span class="text-danger"><?php echo form_error('email'); ?></span>
            <div class="row align-items-center mt-2">
              <div class="col">
              <input type="text" name="dob" id="datepicker" class="form-control" value="<?php echo set_value('dob'); ?>" placeholder="Please enter your date of birth">
              </div>
            </div>
            <span class="text-danger"><?php echo form_error('dob'); ?></span>
            <div class="row align-items-center mt-2">
              <div class="col">
              <select class="form-control" name="gender">
                  <option selected disabled><?php if(!empty(set_value('gender'))){echo set_value('gender');}else{echo 'Please select your gender';} ?></option>
                  <option value="Female">Female</option>
                  <option value="Male">Male</option>
                  <option value="Agender">Agender</option>
                  <option value="Androgyne">Androgyne</option>
                  <option value="Androgynous">Androgynous</option>
                  <option value="Bigender">Bigender</option>
                  <option value="Cis">Cis</option>
                  <option value="Cisgender">Cisgender</option>
                  <option value="Cis Female">Cis Female</option>
                  <option value="Trans Female">Trans Female</option>
                  <option value="Trans* Female">Trans* Female</option>
                  <option value="Trans Male">Trans Male</option>
                  <option value="Trans* Male">Trans* Male</option>
                  <option value="Trans Man">Trans Man</option>
                  <option value="Trans* Man">Trans* Man</option>
                  <option value="Trans Person">Trans Person</option>
                  <option value="Two-Spirit">Two-Spirit</option>
              </select>
              </div>
            </div>
            <span class="text-danger"><?php echo form_error('gender'); ?></span>
            <div class="row align-items-center mt-2">
              <div class="col">
              <input type="text" id="autocomplete" name="address" class="form-control" value="<?php echo set_value('address'); ?>" placeholder="Address" onFocus="geolocate()">
              </div>
            </div>
            <span class="text-danger"><?php echo form_error('address'); ?></span>
            <div class="row align-items-center mt-2">
              <div class="col">
              <input type="password" name="password" class="form-control" value="" placeholder="Password" >
              </div>
              <div class="col">
              <input type="password" name="password2" class="form-control" value="" placeholder="Confirm password" >
              </div>
            </div>
            <input type="hidden" name="street_number" id="street_number" value="">
            <input type="hidden" name="route" id="route" value="">
            <input type="hidden" name="locality" id="locality" value="">
            <input type="hidden" name="area_level" id="administrative_area_level_1" value="">
            <input type="hidden" name="postal_code" id="postal_code" value="">
            <input type="hidden" name="country" id="country" value="">
            <span class="text-danger"><?php echo form_error('password'); ?></span>
            <div class="row justify-content-start mt-4">
              <div class="col">
                <div class="form-check">
                  <label class="form-check-label pull-left mb-3">
                    <input type="checkbox" id="chkAgree" onclick="goFurther()" class="form-check-input">
                    I have read and Accept <a href="https://www.froala.com">Terms and Conditions</a>
                  </label>
                </div>
                <button type="submit" id="btnSubmit" class="btn btn-primary btn-block mt-1" disabled data-disable-with="Signing up...">SIGNUP</button>
              </div>
            </div>
            <p class="text-center mt-3">Already have an Account? <a href="<?php echo base_url(); ?>users/login">SIGN IN</a></p>
         <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </section>

   <script>
var placeSearch, autocomplete;

var componentForm = {
  street_number: 'short_name',
  route: 'long_name',
  locality: 'long_name',
  administrative_area_level_1: 'short_name',
  country: 'long_name',
  postal_code: 'short_name'
};

function initAutocomplete() {
  // Create the autocomplete object, restricting the search predictions to
  // geographical location types.
  autocomplete = new google.maps.places.Autocomplete(
      document.getElementById('autocomplete'), {types: ['geocode']});

  // Avoid paying for data that you don't need by restricting the set of
  // place fields that are returned to just the address components.
  autocomplete.setFields(['address_component']);

  // When the user selects an address from the drop-down, populate the
  // address fields in the form.
  autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
  // Get the place details from the autocomplete object.
  var place = autocomplete.getPlace();

  for (var component in componentForm) {
    document.getElementById(component).value = '';
    document.getElementById(component).disabled = false;
  }

  // Get each component of the address from the place details,
  // and then fill-in the corresponding field on the form.
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      document.getElementById(addressType).value = val;
    }
  }
}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      var circle = new google.maps.Circle(
          {center: geolocation, radius: position.coords.accuracy});
      autocomplete.setBounds(circle.getBounds());
    });
  }
}

  $('#datepicker').datepicker({
      uiLibrary: 'bootstrap4',
      maxDate: '01/01/2002'
  });

  function goFurther(){
if (document.getElementById("chkAgree").checked == true)
    document.getElementById("btnSubmit").disabled = false;
    else
    document.getElementById("btnSubmit").disabled = true;
}

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBRMLF9pK8EoY-wOnp1_N1uZ7pH6fOnlLQ&libraries=places&callback=initAutocomplete"
        async defer></script>