<!--
// _mysript.js - source of the minified "myscript.js" included on most code pages 
// to run my javascript functions
//
// (c) 2020, TLF
// Written by James Misa 
-->    
 /*eslint-env jquery*/

$('#verSubmit').click(function(){ 
        var temp_password = $("#temp_password").val();
        var password = $("#password").val();
        var confirm_password = $("#confirm_password").val();
        var tlf_id = $("#tlf_id").val();
        var dataString = 'temp_password=' + temp_password + '&password=' + password + '&tlf_id=' + tlf_id;
        if (password !== confirm_password) { 
            alert("Passwords do not match"); 
    } else {
        $(function(){ 
                jQuery.ajax({
                 type: "POST",
                 url: "_/components/php/update_password.php", 
                 data: dataString,
                 success: function(msg){
                     alert(msg);
                     window.location.href = "index.php";
                 },
                 error: function(){
                 alert("failure");
                 }
                }); 
            });
    }
});

$('#refSubmit').click(function(){ 
    var email = $("#refEmail").val();
    var dataString = 'email=' + email;
    $(function(){ 
        jQuery.ajax({
         type: "POST",
         url: "_/components/php/findReferrer.php", 
         data: dataString,
         success: function(msg){
             console.log(msg);
             var obj = JSON.parse(msg);
             if(obj[0] == 2) {
                 $("#register").modal('hide');
                 $(".modal-body .referrer_name").val(obj[1]);
                 $(".modal-body .ref_id").val(obj[2]);
                 $(".modal-body .promoCode5").val(obj[3]);
                 $(".modal-body .priceCode").val(obj[4]);
                 $("#newRegister").modal('toggle'); 
             } else {
                 alert("This email address does not exist.");
                 $("#login").modal('hide');
             }
         },
         error: function(){
         alert("failure");
         }
        }); 
    });
});

    $('#passSubmit').click(function(){ 
        alert('im here');
        var temp_password = $("#temp_password").val();
        var password = $("#password").val();
        var confirm_password = $("#confirm_password").val();
        var tlf_id = $("#tlf_id").val();
        var dataString = 'temp_password=' + temp_password + '&password=' + password + '&tlf_id=' + tlf_id;
        if (password !== confirm_password) { 
            alert("Passwords do not match"); 
    } else {
        $(function(){ 
                jQuery.ajax({
                 type: "POST",
                 url: "_/components/php/update_password.php", 
                 data: dataString,
                 success: function(msg){
                     alert(msg);
                     window.location.href = "index.php";
                 },
                 error: function(){
                 alert("failure");
                 }
                });   
            });
    }
});

 $('#chPassSubmit').click(function(){ 
        var currPassword = $("#currPassword").val();
        var password = $("#password").val();
        var confirm_password = $("#confirmPassword").val();
        var email = $("#email").val();
        var dataString = 'currPassword=' + currPassword + '&password=' + password + '&email=' + email;
        if (password !== confirm_password) { 
            alert("Passwords do not match"); 
    } else {
        $(function(){ 
            jQuery.ajax({
             type: "POST",
             url: "_/components/php/changePassword.php", 
             data: dataString,
             success: function(msg){
                 alert(msg);
                 window.location.href = "user.php";
             },
             error: function(){
             alert("failure");
             }
            });  
        });
    }
});

function passSubmits (){
        var temp_password = $("#temp_password").val();
        var password = $("#password").val();
        var confirm_password = $("#confirm_password").val();
        var tlf_id = $("#tlf_id").val();
        var dataString = 'temp_password=' + temp_password + '&password=' + password + '&tlf_id=' + tlf_id;
        if (password !== confirm_password) { 
            alert("Passwords do not match"); 
    } else {
        $(function(){ 
                jQuery.ajax({
                 type: "POST",
                 url: "_/components/php/update_password.php", 
                 data: dataString,
                 success: function(msg){
                     alert(msg);
                     window.location.href = "index.php";
                 },
                 error: function(){
                 alert("failure");
                 }
                });  
            });
    }
}




$('#inviteSubmit').click(function(){
    
    var email = $("#email").val();
    var dataString = 'email=' + email;
         jQuery.ajax({
             type: "POST",
             url: "_/components/php/resendInvite.php",
             data: dataString,
             success: function(data){
                    alert(data);
                    $("#login").modal('hide');
                     window.location.href = "index.php"; 
             },
             error: function(data){
             alert(data);
             }
            });
    
});

$('#setupSubmit').click(function(){
    
    var email = $("#email").val();
    var dataString = 'email=' + email;
         jQuery.ajax({
             type: "POST",
             url: "_/components/php/completeSetup.php",
             data: dataString,
             success: function(data){
                    $("#setup").modal('hide');
                    document.getElementById('passwordSetup').innerHTML = data; 
             },
             error: function(data){
             alert(data);
             }
            });
    
});

$('#startBoardSubmit').click(function(){
    var boardLevel = $("#boardLevel").val();
    var placementMethod = $("#placementMethod").val();
    if(placementMethod == "Specific Tree") {var boardID = $("#boardID").val();} else {var boardID = "NULL";}
    var dataString = 'boardLevel=' + boardLevel + '&placementMethod=' + placementMethod + '&boardID=' + boardID;
         jQuery.ajax({
             type: "POST",
             url: "_/components/php/confirmPosition.php",
             data: dataString,
             success: function(data){
                    console.log(data);
                    alert(data);
                     window.location.href = "myTrees.php";
             },
             error: function(data){
             alert('error' + data);
             }
        });
});





    
$('#addSeedAdminSubmit').click(function(){
    var seed = $("#addSeed").val();
    var fireDate = $("#fireDate2").val(); 
    var lotus_id = $("#lotus_id2").val();
    var dataString = 'seed=' + seed + '&lotus_id=' + lotus_id + '&fireDate=' + fireDate;
    if (fireDate == '') {
        alert("Please select a fireDate"); 
    } else {
         jQuery.ajax({
             type: "POST",
             url: "_/components/php/addSeedAdmin.php",
             data: dataString,
             success: function(data){
                    alert(data);
                    $("#addFlowerForm").modal('hide');
                     window.location.href = "myflowers.php";  
             },
             error: function(data){
             alert(data);
             }
            }); 
    }
});
    
$('#addFlowerAdminSubmit').click(function(){
    var flower = $("#addFlower2").val();
    var fireDate = $("#fireDate").val(); 
    var lotus_id = $("#lotus_id").val();
    var dataString = 'flower=' + flower + '&lotus_id=' + lotus_id + '&fireDate=' + fireDate;
    if (fireDate == '') {
        alert("Please select a Seed Date"); 
    } else {
         jQuery.ajax({
             type: "POST",
             url: "_/components/php/addFlowerAdmin.php",
             data: dataString,
             success: function(data){
                    alert(data);
                    $("#addFlower").modal('hide');
                     window.location.href = "myflowers.php";  
             },
             error: function(data){ 
             alert(data);
             }
            }); 
    }
});
    



$('#defPasswordSubmit').click(function(){
    var email = $("#email").val();
    var dataString = 'email=' + email;
         jQuery.ajax({
             type: "POST",
             url: "_/components/php/resetPassword.php",
             data: dataString,
             success: function(data){
                    $("#changePassword").modal('hide');
                    alert(data);
             },
             error: function(data){
             alert('error' + data);
             }
        });
});

$('#termsSubmit').click(function(){
    var tlf_id = $("#tlf_id").val();
    var dataString = 'tlf_id=' + tlf_id;
         jQuery.ajax({
             type: "POST",
             url: "_/components/php/termsAgreed.php",
             data: dataString,
             success: function(data){
                    $("#termsOptIn").modal('hide');
                    localStorage.removeItem('terms');
                    localStorage.setItem('terms', 1);
                    alert(data);
             },
             error: function(data){
             alert('error' + data);
             }
        });
});


function addGiftedFire(water_id, fire_id, gifted_date, fname){
    var r = confirm("This will confirm that you received your gift from " + fname);
      if (r == true) {
    var dataString = 'water_id=' + water_id + '&fire_id=' + fire_id + '&gifted_date=' + gifted_date;
    jQuery.ajax({
         type: "POST",
         url: "_/components/php/recordGifter.php",
         data: dataString,
         success: function(res){
             console.log(res);
             alert("You will receive an email with the link to your gifting letter."); 
            window.location.href = "water.php";
         },
         error: function(){
         alert("failure");
         }
        });
      } 
}

function flower_det(i) {
    var flower_num = i;
    var dataString = 'flower_num=' + flower_num;
    jQuery.ajax({
         type: "POST",
         url: "_/components/php/flower_detail.php",
         data: dataString,
         success: function(data){
            document.getElementById('myFlower').innerHTML = data;
         },
         error: function(){
         alert("failure"); 
         }
        });
}

function mstone(i) {
    var dataString = 'next_mstone=' + i;
    jQuery.ajax({
         type: "POST",
         url: "_/components/php/update_mstone.php",
         data: dataString,
         success: function(){
            alert('Great Job!');
            window.location.href = "seeds.php";
         },
         error: function(){
         alert("failure");
         }
        });
}

function flower_dets(lotus_id, tlf_id) {
    var dataString = 'lotus_id=' + lotus_id + '&tlf_id=' + tlf_id;
    jQuery.ajax({
         type: "POST",
         url: "_/components/php/flower_detail.php",
         data: dataString,
         success: function(data){
            document.getElementById('myFlower').innerHTML = data;
         },
         error: function(){
         alert("failure");  
         }
        });
}

function board_dets(lotus_id, water_id) {
    var dataString = 'lotus_id=' + lotus_id + '&water_id=' + water_id;
    jQuery.ajax({
         type: "POST",
         url: "_/components/php/board_detail.php",
         data: dataString,
         success: function(data){
            document.getElementById('myFlower').innerHTML = data;
         },
         error: function(msg){
         alert(msg);  
         }
        });
}

function flower_dets_admin(lotus_id, tlf_id) {
    var dataString = 'lotus_id=' + lotus_id + '&tlf_id=' + tlf_id;
    jQuery.ajax({
         type: "POST",
         url: "_/components/php/flower_detail_admin.php",
         data: dataString,
         success: function(data){
            document.getElementById('myFlower').innerHTML = data;
         },
         error: function(){
         alert("failure");  
         }
        });
}

function logMeOut() {
        jQuery.ajax({
         type: "POST",
         url: "_/components/php/logout.php",
         success: function(){
            window.location = "index.php";
            localStorage.clear();
         },
         error: function(){
         alert("failure");
         }
        });
}

$('#checkLogin').click(function(){
    var logout = confirm('Would you like to logout?');
    if (logout == true) {
        jQuery.ajax({
         type: "POST",
         url: "_/components/php/logout.php",
         success: function(){
            window.location = "index.php";
            localStorage.clear();
         },
         error: function(){
         alert("failure");
         }
        });
    } else {
        return false;
    }
});

$('#resetSubmit').click(function(){
    var email = $("#resetEmail").val();
    alert(email);
    var dataString = 'email=' + email;
         jQuery.ajax({
             type: "POST",
             url: "_/components/php/resetPassword.php",
             data: dataString,
             success: function(data){
                    $("#forgotPassword").modal('hide');
                    alert(data);
             },
             error: function(data){
             alert('error' + data);
             }
        }); 
});

$('#editDateSubmit').click(function(){
    var sowDate = $("#sowDate").val();
    var id = $("#this_lotus_id").val();
    var dataString = 'sowDate=' + sowDate + '&id=' + id;
         jQuery.ajax({
             type: "POST",
             url: "_/components/php/updateSowDate.php",
             data: dataString,
             success: function(data){
                    $("#editDate").modal('hide');
                    alert(data);
                     window.location.href = "orgView.php";
             },
             error: function(data){
             alert('error' + data);
             }
        });
});

$('#editNameSubmit').click(function(){
    var display_name = $("#display_name").val();
    var focus_id = $("#focus_id").val();
    var dataString = 'display_name=' + display_name + '&focus_id=' + focus_id;
         jQuery.ajax({
             type: "POST",
             url: "_/components/php/updateDisplayName.php",
             data: dataString,
             success: function(data){
                    console.log(data);
                    $("#editName").modal('hide');
                    alert(data);
                     window.location.href = "orgView.php";
             },
             error: function(data){
             alert('error' + data);
             }
        });
});


    
    function changeNav(name) {
       document.getElementById('navbar').innerHTML = '<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#collapsemenu" aria-controls="collapsemenu" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggler-icon"></span></button><!--hamburgerbutton--><div class="collapse navbar-collapse" id="collapsemenu"><ul class="navbar-nav nav-pills nav-justified"><li class="nav-item"><a href="index.php" class="nav-link" onclick="changebackNav();"><img src="images/home.png" style="width:3vw; height:3vw;"></i> HOME</a></li><li class="nav-item"><a href="#" class="nav-link" onclick="changeNav(\'' + name + '\');"><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Seeds</a></li><li class="nav-item"><a href="myflowers.php" class="nav-link" onclick="changeNav(\'' + name + '\');"><img src="images/Tree of Life.png" style="width:3vw; height:3vw;"> Trees</a></li><li class="nav-item"><a href="support.php" class="nav-link" onclick="changeNav(\'' + name + '\');"><img src="images/family.png" style="width:3vw; height:3vw;"> Family</a></li><li class="nav-item"><a href="water.php" class="nav-link" onclick="changeNav(\'' + name + '\');"><img src="images/harvest.png" style="width:3vw; height:3vw;"> Harvest</a></li><li class="nav-item"><a href="user.php" class="nav-link" onclick="changeNav(\'' + name + '\');"><img src="images/user.png" style="width:3vw; height:3vw;"> ' + name + '</a></li></div></li></ul><!--nav--></div><!--collapse-->';
    }
    
    function changebackNav(name) {
       document.getElementById('navbar').innerHTML = '<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#collapsemenu" aria-controls="collapsemenu" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggler-icon"></span></button><!--hamburgerbutton--><div class="collapse navbar-collapse" id="collapsemenu"><ul class="navbar-nav nav-pills nav-justified"><li class="nav-item"><a href="index.php" class="nav-link"><img src="images/home.png" style="width:3vw; height:3vw;"></i> HOME</a></li><li class="nav-item"><a href="bridges.php" class="nav-link"><img src="images/bridge.png" style="width:3vw; height:3vw;"></i> BRIDGES</a></li><li class="nav-item"><a href="bees.php" class="nav-link"><img src="images/bees.png" style="width:3vw; height:3vw;"> BEES</a></li><li class="nav-item"><a href="#" class="nav-link" onclick="changeNav(\'' + name + '\');"><img src="images/harvest.png" style="width:3vw; height:3vw;" > EDEN</a></li><li class="nav-item"><a href="user.php" class="nav-link"><img src="images/user.png" style="width:3vw; height:3vw;"> ' + name + '</a></li></ul><!--nav--></div><!--collapse-->';
    }




function newTree(id) {
     $("#addTreeAdmin").modal('toggle'); 
      localStorage.setItem('up_id', id);
    
}

function addFromSeeds() {
    $up_id = localStorage.getItem('up_id');
    $tlf_id = localStorage.getItem('tlf_id');
    
  var x = document.getElementById("addSeed");
  var option = document.createElement("option");
  option.text = "James Misa";
  option.value = "174";
  x.add(option);
    
 $("#addFromSeedsAdmin").modal('toggle'); 
    /*
    jQuery.ajax({
         type: "POST",
         url: "_/components/php/getSeeds.php",
         data: dataString,
         success: function(data){
             console.log(data);
                localStorage.setItem("viewData", data);  
                window.location.href = "orgView.php"; 
         },
         error: function(data){
         alert('error' + data);
         }
    });*/
    
}

function storeParent(id, board_brand) { 
    
      localStorage.setItem('parent_id', id);
      localStorage.setItem('board_brand', board_brand); 
}


    

$(document).ready(function() {

$('#editName').on('show.bs.modal', function (event) {
  var myVal = $(event.relatedTarget).data('val');
  $(".modal-body #display_name").val(myVal);
});
    
$("#visibility a").on('click', function(event) {
    event.preventDefault();
    if($('#visibility input').attr("type") == "text"){
        $('#visibility input').attr('type', 'password');
        $('#visibility a i').addClass( "fa-eye-slash" );
        $('#visibility a i').removeClass( "fa-eye" );
    }else if($('#visibility input').attr("type") == "password"){
        $('#visibility input').attr('type', 'text');
        $('#visibility a i').removeClass( "fa-eye-slash" );
        $('#visibility a i').addClass( "fa-eye" );
    }
});
    
$('[data-toggle="tooltip"]').tooltip(); 
    
    
    if(localStorage.getItem('terms') == 0) {
        $('#termsOptIn').modal('show');
    } 

    $('.regSubmit').click(function(){
            var first_name = $(".first_name").val();
            if(first_name == ""){alert("first name is missing");}
            var last_name = $(".last_name").val();
            if(last_name == ""){alert("last name is missing");}
            var email = $(".email").val();
            if(email == ""){alert("email is missing");}
            var phone = $(".phone").val();
            if(phone == ""){alert("phone is missing");}
            var fireDate = $(".fireDate").val();
            if(fireDate == ""){alert("fire date is missing");}
            var referrer_name = $(".referrer_name").val();
            if(referrer_name == ""){alert("referrer name is missing");}
            var ref_id = $(".ref_id").val();
            if(ref_id == ""){alert("ref_id is missing");}
            var password = $(".password").val();
            if(password == ""){alert("password is missing");}
            var confirm_password = $(".confirmPassword").val();
            if(confirm_password == ""){alert("confirm password is missing");}
            var promoCode = $(".promoCode").val();
            if(promoCode == ""){var promoCode = "Empty";}
            var priceCode = $(".priceCode").val();
            var dataString = 'first_name=' + first_name + '&last_name=' + last_name + '&email=' + email + '&phone=' + phone + '&fireDate=' + fireDate + '&referrer_name=' + referrer_name + '&ref_id=' + ref_id + '&password=' + password + '&promoCode=' + promoCode + '&priceCode=' + priceCode;
            if (first_name == '' || last_name == '' || email == '' || phone == '' || password == '' || confirm_password == '' || promoCode == '') {
                alert("Please fill all fields");
        } else {

            if (password !== confirm_password) {
                alert("Passwords do not match");
            } else { 
                $(function(){
                        jQuery.ajax({
                         type: "POST", 
                         url: "_/components/php/newUser3.php",
                         data: dataString,
                         success: function(msg){
                             console.log(msg);
                             $("#newRegister").modal('hide');
                             var obj = JSON.parse(msg);
                             if(obj[0] == "Success") {
                                 if(obj[4] == "REDHAT") {
                                     document.getElementById('name').value = obj[1];
                                     document.getElementById('email').value = obj[2];
                                     document.getElementById('priceCode').value = obj[5];
                                     localStorage.setItem('tlf_id', obj[3]);
                                     $("#payment-form").modal('show');
                                 } else {
                                     alert("Congrats! You're free to login.")
                                     window.location.href = "index.php";
                                 }
                             } else if (obj[0] == "Error") {
                                 alert(obj[1]);
                             }
                         },
                         error: function(msg){
                         alert(msg);
                         }
                        });
                    });
            }
        }
    });

    $('#convertToSeed').click(function(){
         jQuery.ajax({
             type: "POST",
             url: "_/components/php/convertToSeed.php",
             success: function(data){
                    alert(data);
                    window.location.href = "admin_portal.php"; 
             },
             error: function(data){
             alert(data);
             }
            });
    });
    
    $('#deleteFlower').click(function(){
         jQuery.ajax({
             type: "POST",
             url: "_/components/php/deleteFlower.php",
             success: function(data){
                    alert(data);
                    window.location.href = "myflowers.php"; 
             },
             error: function(data){
             alert(data);
             }
            });
    });
    
    $('#loginPassword').keypress(function(e){
        if(e.which === 13){//Enter key pressed
            $('#loginSubmit').click();//Trigger search button click event
        }
    });

    $('#loginForm').bootstrapValidator({
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            email: {
                validators: {
                    notEmpty: {
                        message: 'Please supply your email address'
                    },
                    emailAddress: {
                        message: 'Please supply a valid email address'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'Please enter a password'
                    }
                } 
            }
        }
    })
    
    // Create a Stripe client.
var stripe = Stripe("pk_live_51H5mLbGkFLnj68yKYxAJgqDZ5U0Lm734Jps5jRxgGofjEszwVCgX6TqRZ6ayjDph79dLUcdq9jt8eSlLNyNqXZQo00gj6ySdVS"); 

// Create an instance of Elements.
var elements = stripe.elements(); 

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
  base: {
    color: '#32325d',
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
      color: '#aab7c4'
    }
  },
  invalid: {
    color: '#fa755a',
    iconColor: '#fa755a'
  }
};

// Create an instance of the card Element.
var card = elements.create('card', {style: style});

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});

// Create a source or display an error when the form is submitted.
var form = document.getElementById('payment-form');

$('#paymentSub').click(function() {
    $('#loader').removeClass("loader");
    var name = document.getElementById('name3').value;
    var address = document.getElementById('address3').value;
    var zip = document.getElementById('zip3').value;
    var city = document.getElementById('city3').value;
    var email = document.getElementById('email1').value;
    var priceCode = document.getElementById('priceCode2').value;
    var ownerInfo = {
      owner: {
        name: name,
        address: {
          line1: address,
          city: city,
          postal_code: zip,
          country: 'US'
        },
        email: email
      }
    };

  stripe.createSource(card, ownerInfo).then(function(result) {
    if (result.error) {
      // Inform the user if there was an error
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
    } else {
        var tlf_id = localStorage.getItem('tlf_id');
      // Send the source to your server
      stripeSourceHandler(result.source, email, tlf_id, priceCode);
    }
  });
});

function stripeSourceHandler(source, email, tlf_id, priceCode) {
    var dataString = 'source=' + source.id + '&email=' + email + '&tlf_id=' + tlf_id + '&priceCode=' + priceCode;
        jQuery.ajax({
         type: "POST",
         url: "_/components/php/newCustomer.php",
         data: dataString,
         success: function(){
             $('#loader').addClass("loader");
             window.location.href = "receipt.php"; 
         },
         error: function(msg){
         alert(msg);
         }
        });
}
    /*
    if (window.location.protocol == "http:") {
      console.log("You are not connected with a secure connection.")
      console.log("Reloading the page to a Secure Connection...")
      window.location = document.URL.replace("http://", "https://");
    }

    if (window.location.protocol == "https:") {
      console.log("You are connected with a secure connection.")
    }*/
});