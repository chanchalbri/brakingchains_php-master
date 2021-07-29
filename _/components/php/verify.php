<h2 class="welcome_msg">Welcome <?php echo $name; ?>, let's create a new password.</h2>
<form>
  <div class="form-group">
    <label for="temp_password">Temp Password</label>
    <input type="text" class="form-control" id="temp_password" aria-describedby="temp_password" value="<?php echo $temp_password; ?>">
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" placeholder="Enter New Password">
  </div>
  <div class="form-group">
    <label for="confirm_password">Confirm Password</label>
    <input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password">
  </div>
    <div class="form-group">
    <input type="hidden" class="form-control" 
    id="tlf_id" name="tlf_id" value="<?php echo $tlf_id; ?>" placeholder="TLF ID" readonly/>
    </div><!--form-group-->
  <button type="submit" id="verSubmit" class="btn btn-primary btn-block">Submit</button>
</form>