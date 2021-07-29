<?php
// login.php - called by the TLF website - index.php
// to present a login form for the users
//
// (c) 2020, TLF
// Written by James Misa 
    
?>
  <button type="button" class="login btn btn-default btn-lg btn-block font-white" data-toggle="modal" data-target="#login">Login here</button>

<?php 

    echo showLogin();
    echo showForgotPassword();
    echo registerModal($promoCode, $price, $tlf_id, $name); 
    echo showTerms();
    echo showPrivacy();
    echo showFindInviter();
    echo paymentForm($trial);

?>

<script src="https://js.stripe.com/v3/"></script>
<script>
 function disableSubmit() {
  document.getElementById("regSubmit").disabled = true;
 }

  function activateButton(element) {

      if(element.checked) {
        document.getElementById("regSubmit").disabled = false;
       }
       else  {
        document.getElementById("regSubmit").disabled = true;
      }

  }
</script>