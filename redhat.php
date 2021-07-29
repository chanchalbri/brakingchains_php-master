<?php require_once("_/components/php/includes/session.php"); ?>
<?php require_once("_/components/php/includes/connection.php"); ?>
<?php require_once("_/components/php/includes/functions.php"); ?>
<?php 
// index.php - landing page of the TLF website
// will show login button
//
// (c) 2020, TLF
// Written by James Misa

$tlf_id = "123456789";

    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE id = '{$_SESSION['id']}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    while($found_user = mysqli_fetch_array($resultSet)) {
        $name = $found_user['first_name'] . " " . $found_user['last_name'];
        $tlf_id = $found_user['tlf_id'];
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>TLF</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Krub:ital,wght@1,600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rock+Salt&display=swap" rel="stylesheet">
    <link href="_/css/bootstrap.css" rel="stylesheet">
    <link href="_/css/mystyles.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    <script src="https://kit.fontawesome.com/7b30bafaf6.js" crossorigin="anonymous"></script>
  </head>
  <body id="home">
      <section class="container" ng-app="">
          <div class="content row">
              <?php include "_/components/php/header.php"; ?>
              <h2 class="elements-title2">Welcome to </h2>
              <h1 class="elements-title"><span class="lotus">The Lotus Family</span></h1>
              <div class="col-md-12">
                   <h3 class="how">You're in the right place</h3>
                  <hr>
                  <div class="description">
                   <p>Our mission is to provide a home for like-minded individuals to work together and practice the Universal Laws of sowing and reaping in a safe environment where everyone can reach their goals, dreams and aspirations.</p>
                   <hr>
                    <h3 class="how">Our community includes:</h3>
                      
                      <ul class="community">
                        <li>Complete virtual back office</li>
                        <li>One-touch gift verification system</li>
                        <li>Ongoing member communication</li>
                        <li>Highly successful leadership network</li>
                        <li>Amazing wealth creation opportunity</li>
                        <li>And so much more!</li>
                      </ul>
                    <hr>
                    <p>Simply follow your Inviter through each step of the process, and your Invitees will follow you, making this a real team effort.</p>

                    <p>And our automated system tracks your movement in real time every step of the way!</p>
                  </div>
              </div>
              
             <button type="button" 
                class="btn btn-block btn-primary btn-large btn-block"  
                data-toggle="modal" 
                data-target="#addNewSeeds">Register Now</button>
          </div><!--content-->
          <?php include "_/components/php/footer.php"; ?>
      </section><!--container--> 




<!-- Modal -->
<div class="modal fade" id="addNewSeeds" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Registration</h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form class="form-horizontal" data-toggle="validator" id="registerForm2" role="form">

                <div class="form-group">
                    <label  class="sr-only" for="referrer_name3">Marvin</label>
                    <div class="col-sm-12" inputGroupContainer>
                        <div class="input-group"> 
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control" 
                                   id="referrer_name3" name="referrer_name3" value="Marvin" disabled/>
                        </div><!--input-group-->
                        <p class="desc">Inviter</p>
                    </div><!--inputGroupContainer-->
                </div><!--form-group-->

                  <div class="form-group">
                    <label  class="sr-only" for="first_name3"></label>
                    <div class="col-sm-12" inputGroupContainer>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control" 
                            id="first_name3" name="first_name3" placeholder="First Name"/>
                        </div><!--input-group-->
                    </div><!--inputGroupContainer-->
                  </div><!--form-group-->

                    <div class="form-group">
                        <label  class="sr-only" for="last_name3">Last Name</label>
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input type="text" class="form-control" 
                                id="last_name3" name="last_name3" placeholder="Last Name"/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->

                    <div class="form-group">
                        <label  class="sr-only" for="email3">Email</label>
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <input type="email" class="form-control" 
                                id="email3" name="email3" placeholder="Email"/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->

                  <div class="form-group">
                    <label class="sr-only" for="phone3" >Phone</label>
                    <div class="col-sm-12" inputGroupContainer>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="tel" class="form-control"
                            id="phone3" name="phone3" data-minlength="6" placeholder="Phone"/>
                        </div><!--input-group-->
                    </div><!--inputGroupContainer-->
                  </div><!--form-group-->
                    
                    <div class="form-group">
                    <label class="sr-only" for="giftingMethod3" >Preferred Gifting Method</label>
                    <div class="col-sm-12" inputGroupContainer>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-credit-card"></i></span>
                            <select class="form-control" id="giftingMethod2">
                                <option>Select Preferred Gifting Method</option> 
                                <option>Venmo</option> 
                                <option>Zelle</option> 
                                <option>Paypal</option> 
                                <option>CashApp</option> 
                                <option>Xoom</option> 
                                <option>Other</option> 
                            </select>
                        </div><!--input-group-->
                    </div><!--inputGroupContainer-->
                  </div><!--form-group-->
                    
                    <div class="form-group">
                    <label class="sr-only" for="methodUsername3" >Gift Method Username</label>
                    <div class="col-sm-12" inputGroupContainer>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-credit-card"></i></span>
                            <input type="text" class="form-control"
                            id="methodUsername3" name="methodUsername3" data-minlength="6" placeholder="Gift Method Username"/>
                        </div><!--input-group-->
                    </div><!--inputGroupContainer-->
                  </div><!--form-group-->

                    <div class="form-group">
                        <label  class="sr-only" for="fireDate3">Targeted Fire Date</label>
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                <input type="date" class="form-control" 
                                id="fireDate3" name="fireDate3"  placeholder="Fire Date"/>
                            </div><!--input-group-->
                            <p class="desc">Enter Fire Date (MUST BE A SUNDAY!)</p>
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->
                    
                    <div class="form-group">
                    <label class="sr-only" for="password3" >Create a Password</label>
                    <div class="col-sm-12" inputGroupContainer>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" class="form-control"
                            id="password3" name="password3" data-minlength="6" placeholder="Create a Password"/>
                        </div><!--input-group-->
                    </div><!--inputGroupContainer-->
                  </div><!--form-group-->
                    
                    <div class="form-group">
                    <label class="sr-only" for="confirmPassword3" >Confirm Password</label>
                    <div class="col-sm-12" inputGroupContainer>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" class="form-control"
                            id="confirmPassword3" name="confirmPassword3" data-minlength="6" placeholder="Confirm Password"/>
                        </div><!--input-group-->
                    </div><!--inputGroupContainer-->
                  </div><!--form-group-->
                    
                    <div class="form-group">
                    <label class="sr-only" for="promoCode3" >Promo Code</label>
                    <div class="col-sm-12" inputGroupContainer>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-credit-card"></i></span>
                            <input type="text" class="form-control"
                            id="promoCode3" name="promoCode3" value="REDHAT" placeholder="Promo Code" disabled/>
                        </div><!--input-group-->
                        <p class="desc">Promo Code</p>
                    </div><!--inputGroupContainer-->
                  </div><!--form-group-->

                    <div class="form-group">
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <input type="hidden" class="form-control" 
                                id="ref_id3" name="ref_id3" value="<?php echo $tlf_id; ?>" placeholder="Referrer Code" readonly/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->
                    
                    <div class="form-inline">
                        <div class="form-check">
                           <input class="form-check-input" type="checkbox" value="" id="termsPrivacy3" onchange="activateButton(this)"/>
                          <label class="form-check-label" for="defaultCheck2">
                            I agree to the <a href="#privacy3" data-toggle="modal" data-target="#privacy3">Privacy Policy</a> and <a href="#terms3" data-toggle="modal" data-target="#terms3">Terms and Conditions</a>
                          </label>
                        </div>
                    </div><!--form-group-->

                </form> 
            </div><!--modal-body-->

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" id="regSubmit3" name="submit" class="btn btn-primary" disabled>Add</button>
            </div><!--modal-footer-->
        </div><!--modal-content-->
    </div><!--modal-dialog-->
</div><!--modal register-->
      
<!-- Modal -->
<div class="modal fade" id="payment-form-red" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><span class="input-group-addon"><i class="glyphicon glyphicon-credit-card"></i></span>Payment Method</h4>
            </div><!--modal-header-->
            
           <!-- Modal Body -->
            <div class="modal-body">
                <form class="form-horizontal" data-toggle="validator" id="loginForm3" role="form">
                  
                <div id="logo3"><img src="./images/tlflogo_lg.png"></div>    
                <h2 id="payment-desc">Monthly subscription for The Lotus Online platform: <span style="color:blue;">$19.95</span></h2>
                    
                <div class="form-group">
                    <label  class="sr-only" for="cardInfo">Card Info</label>
                    <div class="col-sm-12" inputGroupContainer>
                        <div class="input-group">
                            <label for="card-element">
                              Credit or debit card
                            </label>
                            <div id="card-element">
                              <!-- A Stripe Element will be inserted here. -->
                            </div>
                        </div><!--input-group-->
                    </div><!--inputGroupContainer-->
                </div><!--form-group-->

                    <div class="form-group">
                        <label  class="sr-only" for="name3">Full Name</label>
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input type="text" class="form-control" 
                                id="name3" name="name3" placeholder="Full Name"/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->

                    <div class="form-group">
                        <label  class="sr-only" for="address3">Address</label>
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <input type="text" class="form-control" 
                                id="address3" name="address3" placeholder="Address"/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->

                    <div class="form-group">
                        <label  class="sr-only" for="city3">City</label>
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <input type="text" class="form-control" 
                                id="city3" name="city3" placeholder="City"/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->

                    <div class="form-group">
                        <label  class="sr-only" for="zip3">Postal Code</label>
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <input type="text" class="form-control" 
                                id="zip3" name="zip3" placeholder="Postal Code"/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->

                    <div class="form-group">
                        <label  class="sr-only" for="country3">Country</label>
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
                                <input type="text" class="form-control" 
                                id="country3" name="country3" placeholder="Country"/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->

                    <div class="form-group">
                        <label  class="sr-only" for="email5">Email</label>
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <input type="email" class="form-control" 
                                id="email5" name="email5" placeholder="Email"/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->
                    
                </form><!--form-horizontal--> 
            </div><!--modal-body-->
            
            <div class="d-flex justify-content-center">
              <div id="loader" class="spinner-border loader" role="status">
                <span class="sr-only">Loading...</span>
              </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="submit" id="paymentSub" name="submit" class="btn btn-primary">Submit Payment</button>
            </div><!--modal-footer-->
        </div><!--modal-content-->
    </div><!--modal-dialog-->
</div><!--modal login-->
      
<!-- Modal -->
<div class="modal fade" id="terms2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Terms & Conditions</h4>
            </div><!--modal-header-->
            
           <!-- Modal Body -->
            <div class="modal-body">
                <form class="form-horizontal" data-toggle="validator" id="termsBody" role="form">
                    
                <div class="form-group">
                        <div class="wrapper">
<div class="terms">
<h4>Terms of Service</h4>

<p>Welcome to TheLotusOnline. This User Agreement ("Agreement") is a legal agreement between you ("you," "your") and TheLotusOnline, Inc. ("TheLotusOnline," "we," "our" or "us").
We want to make it easy for you to track and grow your Lotus flower, and have developed The Lotus Track & Grow service (the "Service," more fully described in Section 1 below) to help you. Before you can use the Service, we require that you accept the terms of this Agreement.

If you do not agree with these terms and do not want to be bound by this Agreement, you will not be granted any rights under this Agreement and you may not use or access the Service. Signing up for TheLotusOnline means you accept these terms:</p>

<h5>1. Your License</h5>

<p>TheLotusOnline grants you a personal, limited, non-exclusive, revocable, non-transferable license, without the right to sublicense, to electronically access and use the Service solely to track and grow your flower, and to manage the gifts you so receive. The Service includes our website, any programs, documentation, tools, internet-based services, components, and any updates (including website maintenance, service information, help content, or bug fixes) thereto provided to you by TheLotusOnline. You will be entitled to updates to the Service, subject to any additional terms made known to you at that time, when TheLotusOnline makes these updates available.</p>

<p>While we want you to enjoy the Service, you may not, nor may you permit any third party to do any of the following: (i) access or attempt to access TheLotusOnline systems, programs or data that are not made available for public use: (ii) copy, reproduce, republish, upload, post, transmit, resell or distribute in any way material from TheLotusOnline; (iii) permit any third party to use and benefit from the Service via a rental, lease, timesharing, or other arrangement; (iv) transfer any rights granted to you under this Agreement; (v) work around any of the technical limitations of the Service, use any tool to enable features or functionalities that are otherwise disabled in the Service, or decompile, disassemble or otherwise reverse engineer the Service, except to the extent that such restriction is expressly prohibited by law; (vi) perform or attempt to perform any actions that would interfere with the proper working of the Service, prevent access to or use of the Service by our other users, or impose an unreasonable or disproportionately large load on our infrastructure; or (vii) otherwise use the Service except as expressly allowed under this section.</p>

<h5>2. Ownership</h5>

<p>The Service is licensed and not sold. TheLotusOnline reserves all rights not expressly granted to you in this Agreement. The Service is protected by copyright, trade secret and other intellectual property laws. TheLotusOnline owns the title, copyright and other worldwide Intellectual Property Rights (as defined below) in the Service and all copies of the Service.

For the purposes of this Agreement, "Intellectual Property Rights" means all patent rights, copyright rights, moral rights, rights of publicity, trademark, trade dress and service mark rights, goodwill, trade secret rights and other intellectual property rights as may now exist or hereafter come into existence, and all applications therefore and registrations, renewals and extensions thereof, under the laws of any state, country, territory or other jurisdiction.

You may choose to or we may invite you to submit comments or ideas about the Service, including without limitation about how to improve the Service or our products ("Ideas"). By submitting any Idea, you agree that your disclosure is gratuitous, unsolicited and without restriction and will not place TheLotusOnline under any fiduciary or other obligation, and that we are free to use the Idea without any additional compensation to you, and/or to disclose the Idea on a non-confidential basis or otherwise to anyone. You further acknowledge that, by acceptance of your submission, TheLotusOnline does not waive any rights to use similar or related ideas previously known to TheLotusOnline, or developed by its employees, or obtained from sources other than you.</p>

<h5>3. Account Registration</h5>

<p>You must register and create a 'Member' account to use the Service. When prompted by our registration process, you agree to (a) provide true, accurate, current and complete information about yourself, and (b) maintain and update this information to keep it true, accurate, current and complete. If any information provided by you is untrue, inaccurate, not current or incomplete, TheLotusOnline has the right to terminate your TheLotusOnline Account ('Account') and refuse any and all current or future use of the Service.</p>

<h5>4. Protecting Your Information</h5>

<p>It is your sole responsibility to ensure that your account numbers, passwords, login details and any other security or access information used by you to use or access the Service is kept safe and confidential. You must prevent unauthorized access to and use of any of your information or data used with or stored in or by the Service ('Account Data'). You are responsible for all electronic communications sent to us or to any third party containing Account Data. When we receive communications containing your Account Data, we assume you sent it to us. You must immediately notify us if you become aware of any loss, theft or unauthorized use of any Account Data. We reserve the right to deny you access to the Service, in whole or in part, if we believe that any loss, theft or unauthorized use of any Account Data or access information has occurred. You grant us permission to anonymously combine your Account Data with that of other members in order to improve our services to you.</p>

<h5>5. Use of the Service</h5>

<p>We have the right and sole discretion to revise, update or otherwise modify the Service and to establish or change limits regarding the use of the Service. We will always attempt to notify you of any modifications with reasonable notice, by posting to TheLotusOnline website and/or sending you an email to the email address provided when you registered or subsequently updated by you. We reserve the right to make any such changes effective immediately to maintain the security of our system or to comply with any laws or regulations, and to provide with notice via email of such changes. We may also perform maintenance on the Service from time to time and this may result in service interruptions, delays, or errors. We will always attempt to provide prior notice of scheduled maintenance but cannot guarantee that notice will always be provided. You may be offered new services that may be in beta and not final. As such, the Service may contain errors and 'bugs' that may result in its failure. You agree that we may contact you in order to assist you with the Service and obtain information needed to identify and fix any errors.</p>

<h5>6. Privacy</h5>

<p>Upon acceptance of this Agreement you confirm that you have read, understood and accepted TheLotusOnline’s Privacy Policy.</p>

<h5>7. Security</h5>

<p>We have implemented commercially reasonable technical and organizational measures designed to secure your personal information from accidental loss and from unauthorized access, use, alteration or disclosure. However, we cannot guarantee that unauthorized third parties will never be able to defeat those measures or use your personal information for improper purposes. You acknowledge that you provide your personal information at your own risk.</p>

<h5>8. No Warranty</h5>

<p>THE SERVICE IS PROVIDED ON AN 'AS IS' AND 'AS AVAILABLE' BASIS. USE OF THE SERVICE IS AT YOUR OWN RISK. TO THE MAXIMUM EXTENT PERMITTED BY APPLICABLE LAW, THE SERVICE IS PROVIDED WITHOUT WARRANTIES OF ANY KIND, WHETHER EXPRESS OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, IMPLIED WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, OR NON-INFRINGEMENT. NO ADVICE OR INFORMATION, WHETHER ORAL OR WRITTEN, OBTAINED BY YOU FROM COMPANY OR THROUGH THE SERVICE WILL CREATE ANY WARRANTY NOT EXPRESSLY STATED HEREIN. WITHOUT LIMITING THE FOREGOING, TheLotusOnline, ITS PROCESSORS, ITS PROVIDERS, ITS LICENSORS (AND THEIR RESPECTIVE SUBSIDIARIES, AFFILIATES, AGENTS, DIRECTORS, AND EMPLOYEES) DO NOT WARRANT THAT THE CONTENT IS ACCURATE, RELIABLE OR CORRECT; THAT THE SERVICE WILL MEET YOUR REQUIREMENTS; THAT THE SERVICE WILL BE AVAILABLE AT ANY PARTICULAR TIME OR LOCATION, UNINTERRUPTED OR SECURE; THAT ANY DEFECTS OR ERRORS WILL BE CORRECTED; OR THAT THE SERVICE IS FREE OF VIRUSES OR OTHER HARMFUL COMPONENTS. ANY CONTENT DOWNLOADED OR OTHERWISE OBTAINED THROUGH THE USE OF THE SERVICE IS DOWNLOADED AT YOUR OWN RISK AND YOU WILL BE SOLELY RESPONSIBLE FOR ANY DAMAGE TO YOUR PROPERTY OR LOSS OF DATA THAT RESULTS FROM SUCH DOWNLOAD.</p>

<p>TheLotusOnline DOES NOT WARRANT, ENDORSE, GUARANTEE, OR ASSUME RESPONSIBILITY FOR ANY PRODUCT OR SERVICE ADVERTISED OR OFFERED BY A THIRD PARTY THROUGH THE SERVICE OR ANY HYPERLINKED WEBSITE OR SERVICE, OR FEATURED IN ANY BANNER OR OTHER ADVERTISING, AND TheLotusOnline WILL NOT BE A PARTY TO OR IN ANY WAY MONITOR ANY TRANSACTION BETWEEN YOU AND THIRD-PARTY PROVIDERS OF PRODUCTS OR SERVICES</p>

<h5>9. Limitation of Liability and Damages</h5>
    
<p>TO THE MAXIMUM EXTENT PERMITTED BY APPLICABLE LAW, IN NO EVENT SHALL TheLotusOnline, ITS PROCESSORS, SUPPLIERS OR ITS LICENSORS (OR THEIR RESPECTIVE AFFILIATES, AGENTS, DIRECTORS AND EMPLOYEES) BE LIABLE FOR ANY DIRECT, INDIRECT, PUNITIVE, INCIDENTAL, SPECIAL, CONSEQUENTIAL OR EXEMPLARY DAMAGES, INCLUDING WITHOUT LIMITATION DAMAGES THAT RESULT FROM THE USE OF, OR INABILITY TO USE, THIS SERVICEm. UNDER NO CIRCUMSTANCES WILL TheLotusOnline BE RESPONSIBLE FOR ANY DAMAGE, LOSS OR INJURY RESULTING FROM HACKING, TAMPERING OR OTHER UNAUTHORIZED ACCESS OR USE OF THE SERVICE OR YOUR ACCOUNT OR THE INFORMATION CONTAINED THEREIN.</p>
    
<p>TO THE MAXIMUM EXTENT PERMITTED BY APPLICABLE LAW, TheLotusOnline AND ITS PROCESSORS (AND THEIR RESPECTIVE AFFILIATES, AGENTS, DIRECTORS, AND EMPLOYEES) ASSUME NO LIABILITY OR RESPONSIBILITY FOR ANY (I) ERRORS, MISTAKES, OR INACCURACIES OF CONTENT; (II) PERSONAL INJURY OR PROPERTY DAMAGE, OF ANY NATURE WHATSOEVER, RESULTING FROM YOUR ACCESS TO OR USE OF OUR SERVICE; (III) ANY UNAUTHORIZED ACCESS TO OR USE OF OUR SECURE SERVERS AND/OR ANY AND ALL PERSONAL INFORMATION STORED THEREIN; (IV) ANY INTERRUPTION OR CESSATION OF TRANSMISSION TO OR FROM THE SERVICE; (V) ANY BUGS, VIRUSES, TROJAN HORSES, OR THE LIKE THAT MAY BE TRANSMITTED TO OR THROUGH OUR SERVICE BY ANY THIRD PARTY; (VI) ANY ERRORS OR OMISSIONS IN ANY CONTENT OR FOR ANY LOSS OR DAMAGE INCURRED AS A RESULT OF THE USE OF ANY CONTENT POSTED, EMAILED, TRANSMITTED, OR OTHERWISE MADE AVAILABLE THROUGH THE SERVICE; AND/OR (VII) USER CONTENT OR THE DEFAMATORY, OFFENSIVE, OR ILLEGAL CONDUCT OF ANY THIRD PARTY. IN NO EVENT SHALL TheLotusOnline, ITS PROCESSORS, AGENTS, SUPPLIERS, OR LICENSORS (OR THEIR RESPECTIVE AFFILIATES, AGENTS, DIRECTORS, AND EMPLOYEES) BE LIABLE TO YOU FOR ANY CLAIMS, PROCEEDINGS, LIABILITIES, OBLIGATIONS, DAMAGES, LOSSES OR COSTS IN AN AMOUNT EXCEEDING THE AMOUNT OF FEES EARNED BY US IN CONNECTION WITH YOUR USE OF THE SERVICE DURING THE THREE (3) MONTH PERIOD IMMEDIATELY PRECEDING THE EVENT GIVING RISE TO THE CLAIM FOR LIABILITY.</p>
    
<p>THIS LIMITATION OF LIABILITY SECTION APPLIES WHETHER THE ALLEGED LIABILITY IS BASED ON CONTRACT, TORT, NEGLIGENCE, STRICT LIABILITY, OR ANY OTHER BASIS, EVEN IF TheLotusOnline HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGE. THE FOREGOING LIMITATION OF LIABILITY SHALL APPLY TO THE FULLEST EXTENT PERMITTED BY LAW IN THE APPLICABLE JURISDICTION.</p>
    
<p>The Service is controlled and operated from its facilities in the United States. TheLotusOnline makes no representations that the Service is appropriate or available for use in other locations. Those who access or use the Service from other jurisdictions do so at their own volition and are entirely responsible for compliance with all applicable United States and local laws and regulations, including but not limited to export and import regulations. You may not use the Service if you are a resident of a country embargoed by the United States, or are a foreign person or entity blocked or denied by the United States government. Unless otherwise explicitly stated, all materials found on the Service are solely directed to individuals located in the United States.</p>

<h5>10. Indemnity</h5>

<p>You will indemnify, defend and hold us and our Processors harmless (and our respective employees, directors, agents, affiliates and representatives) from and against any and all claims, costs, losses, damages, judgments, Tax assessments, penalties, interest, and expenses (including without limitation reasonable attorneys' fees) arising out of any claim, action, audit, investigation, inquiry, or other proceeding instituted by a person or entity that arises out of or relates to: (a) any actual or alleged breach of your representations, warranties, or obligations set forth in this Agreement, including without limitation any violation of our Policies or the Networks’ rules; (b) your wrongful or improper use of the Services; (c) any transaction submitted by you through the Service; (d) your violation of any third-party right, including without limitation any right of privacy, publicity rights or Intellectual Property Rights; (e) your violation of any law, rule or regulation of the United States or any other country; (f) any other party’s access and/or use of the Service with your unique username, password or other appropriate security code.</p>

<h5>11. Representation and Warranties</h5>

<p>You represent and warrant to us that: (a) you are at least eighteen (18) years of age; (b) you are eligible to register and use the Service and have the right, power, and ability to enter into and perform under this Agreement; (c) the name identified by you when you registered is your name; (d) you are the owner of the email address and preferred gift method account information submitted in the registration process; and (e) you will not use the Service, directly or indirectly, for any fraudulent undertaking, illegal activity, or in any manner so as to interfere with the use of the Service.</p>

<h5>12. Consent to Electronic Communication</h5>

<p>We primarily communicate with you via your registered electronic addresses (e-mail and text). By registering for the services and accepting the terms of this Agreement, you affirmatively consent to receive notices electronically from us. You agree that we may provide all communications and transactions related to the services and your accounts, including without limitation agreements related to the Service, amendments or changes to such agreements, disclosures, notices, transaction information, statements, policies (including without limitation notices about our Privacy Policy), responses to claims, and other customer communications that we may be required to provide to you by law in electronic format. All communications by us will be sent either (a) via e-mail, (b) via text message, (c) by providing access to a Website that we designate in an e-mail notice to you, or (c) posting on our website. All Communications will be deemed to be in 'writing' and received by you when sent to you. You are responsible for creating and maintaining your own records of such communications. You must send notices to us at the designated e-mail addresses on the website or through the submission forms on the website. We reserve the right to discontinue or modify how we provide communications. We will give you prior notice of any change. Your continued consent is required to use your account and the Service. To withdraw your consent, you will need to close your account.</p>

<h5>13. Limitation on Time to Sue</h5>
    
<p>Unless otherwise required by law, an action or proceeding by you to enforce an obligation, duty or right arising under this Agreement or by law must commence within one year after the cause of action accrues.</p>

<h5>14. Amendment</h5>
    
<p>We have the right to change or add to the terms of this Agreement at any time, and to change, delete, discontinue, or impose conditions on any feature or aspect of the Service with notice that we in our sole discretion deem to be reasonable in the circumstances, including such notice on our website at http://www.thelotus.online or any other website maintained or owned by us for the purposes of providing services in terms of this Agreement. Any use of the Service after our publication of any such changes shall constitute your acceptance of this Agreement as modified.</p>

<h5>15. Termination</h5>
    
<p>TheLotusOnline may permanently or temporarily terminate, suspend, or otherwise refuse to permit your access to the Service without notice and liability for any reason, including if in TheLotusOnline’s sole determination you violate any provision of this Agreement, or for no reason. Upon termination for any reason or no reason, you continue to be bound by this Agreement. We reserve the right (but have no obligation) to delete all of your information and Account Data stored on our servers if your membership is terminated or if you have not performed in accordance with the community rules and guidelines. Upon termination you must immediately stop using the Service and the license provided under this Agreement shall end. You also agree that upon termination in accordance with this section, TheLotusOnline shall not be liable to you or any third party for termination of access to the Service or deletion of your information or Account Data. The rights and obligations of Section 9 (Limitation of Liability and Damages) and Section 10 (Indemnity), will survive termination of this Agreement.</p>

<h5>16. Assignment</h5>
    
<p>This Agreement, and any rights and licenses granted hereunder, may not be transferred or assigned by you, but may be assigned by TheLotusOnline without restriction.</p>

<h5>17. General Provisions</h5>
    
<p>Except as expressly provided in this Agreement, these terms are a complete statement of the agreement between you and TheLotusOnline, and describe the entire liability of TheLotusOnline and its vendors and suppliers (including Processors) and your exclusive remedy with respect to your access and use of the Service. In the event of a conflict between this Agreement and the Privacy Policy, this Agreement shall prevail. If any provision of this Agreement is invalid or unenforceable under applicable law, then it shall be changed and interpreted to accomplish the objectives of such provision to the greatest extent possible under applicable law, and the remaining provisions will continue in full force and effect. This Agreement will be governed by California law as applied to agreements entered into and to be performed entirely within California, without regard to its choice of law or conflicts of law principles that would require application of law of a different jurisdiction, and applicable federal law. The parties hereby consent to the exclusive jurisdiction and venue in the state courts in Los Angeles County, California or federal court for the District of California. Headings are included for convenience only, and shall not be considered in interpreting this Agreement. The Agreement does not limit any rights that TheLotusOnline may have under trade secret, copyright, patent or other laws. No waiver of any term of this Agreement shall be deemed a further or continuing waiver of such term or any other term, and TheLotusOnline’s failure to assert any right or provision under this Agreement shall not constitute a waiver of such right or provision.</p>
</div>
</div>

                </div><!--form-group-->
                    
                </form><!--form-horizontal--> 
            </div><!--modal-body-->

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div><!--modal-footer-->
        </div><!--modal-content-->
    </div><!--modal-dialog-->
</div><!--modal login-->

<!-- Modal -->
<div class="modal fade" id="privacy2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Privacy Policy</h4>
            </div><!--modal-header-->
            
           <!-- Modal Body -->
            <div class="modal-body">
                <form class="form-horizontal" data-toggle="validator" id="privacyBody" role="form">
                    
                <div class="form-group">
<div class="wrapper">
<div class="terms">

<p>TheLotusOnline respects your privacy and works hard to protect your personal information. We want you to understand how we may collect, store, use and protect any personal information. We will not share your information with anyone except as described in this Privacy Policy. When you registered for our services you agreed to accept this policy. We may change this policy at any time. We will post notifications of revised versions of our policy on our website, and revised policies will be immediately effective. Throughout this Privacy Policy, we will refer to our website and services collectively as the \"Service.\" Please note, this Privacy Policy does not apply to information we collect by other means than your use of the Service (including offline) or from other sources.</p>

<h4>Information We Collect</h4>

<p>When you register for or use a TheLotusOnline account, we collect the following information:
- When you register: we collect your name, phone number, email address, preferred gift method, and other related information.
- Additional information from or about you may also be collected in other ways, including responses to customer surveys or your communications with our customer service team.
**We use technology to help us collect information**</p>

<h4>Cookies</h4>

<p>It is important for us to track how our website is used, and we (or our service providers) may place "cookies" on your computer or device. Cookies are small data files that identify you when you use our services. You have the option to decline our cookies by using your browsers settings tools, but this may interfere with your use of our website and services.</p>

<h4>Protecting Personal Information</h4>

<p>Any information that can be used to identify a person is \"Personal Information\". This does not include information that has been aggregated or made anonymous. All information is securely stored on our servers in the United States. Our safeguards and procedures have been implemented to maintain the physical and electronic security of our services and your personal information. Our measures include firewalls, system-wide data encryption, physical and electronic access controls, and strict rules regarding the access and use of data on our system.</p>

<h4>Using Personal Information</h4>

<p>We use your Personal Information to provide you the features and functionality of the Service, and may share it with our trusted third parties, to ensure that you have a safe, high-performance experience when using the Service. When you use the Service, including contacting customer service or requesting technical support, in addition to many other interactions with TheLotusOnline, we will apply the information that we have collected. Knowing this information allows us to verify your identity, communicate with you and enforce our agreements with you. We may also use this information to measure how our members use the Service, and improve and enhance our offerings to you.
TheLotusOnline may use certain information about you without identifying you as an individual to third parties. We do this for purposes such as analyzing how the Service is used, diagnosing service or technical problems, maintaining security, and personalizing content.
We use cookies to: (a) remember information so that you will not have to re-enter it during your visit or the next time you visit the site; (b) provide custom, personalized content and information; (c) monitor the effectiveness of our Service; (d) monitor aggregate metrics such as total number of visitors and traffic; (e) diagnose or fix technology problems reported by our users or engineers that are associated with certain IP addresses; and (f) help you efficiently access your information after you sign in.</p>

<h4>Sharing Personal Information</h4>

<p>TheLotusOnline will not rent or sell your Personal Information to others. TheLotusOnline may share your Personal Information with members of TheLotusOnline or with third parties for the purpose of providing services to you (such as those described below). If we do this, such third parties' use of your Personal Information will be bound by terms at least as restrictive as this Privacy Policy. We may store personal information in locations outside the direct control of TheLotusOnline (for instance, on servers or databases co-located with hosting providers).</p>

<p>Processing payment and deposit transactions requires that we share your personal information with third parties, including but not limited to:</p>
    
<ul style="margin-left: 20px;">
    <li>Service providers who provide us a range of essential operational services including fraud prevention, transaction processing, collections, direct marketing, and managed technology services. Our contracts dictate that these service providers only use your information in connection with the services they perform for us and not for their own benefit.</li>
    <li>Law enforcement authorities or government representatives who may require us to share information in order to comply with court order and other legal mandates, or when we believe that disclosure is necessary to report suspicious activities, prevent physical harm, financial loss, or violations of our agreements and policies.</li>
    <li>Other third parties, subject to your prior consent or direction.</li>
</ul>
    
<p>If TheLotusOnline becomes involved in a merger, acquisition, or any form of sale of some or all of its assets, we will ensure the confidentiality of any personal information involved in such transactions and provide notice before personal information is transferred and becomes subject to a different privacy policy.</p>
    
<p>Except as otherwise described in this Privacy Policy, TheLotusOnline will not disclose Personal Information to any third party unless required to do so by law or subpoena or if we believe that such action is necessary to (a) conform to the law, comply with legal process served on us or our affiliates, or investigate, prevent, or take action regarding suspected or actual illegal activities; (b) to enforce our Terms of Service and related agreements, take precautions against liability, to investigate and defend ourselves against any third-party claims or allegations, to assist government enforcement agencies, or to protect the security or integrity of our site; and (c) to exercise or protect the rights, property, or personal safety of TheLotusOnline, our Users or others.</p>
    
<h4>Compromise of Personal Information</h4>
    
<p>In the event that personal information is compromised as a result of a breach of security, TheLotusOnline will promptly notify those persons whose personal information has been compromised, in accordance with the notification procedures set forth in this Privacy Policy, by email, or as otherwise required by applicable law.</p>

<h4>Your Choices About Your Information</h4>

<p>You may, of course, decline to submit personally identifiable information through the Service, in which case TheLotusOnline may not be able to provide certain services to you. You may update or correct your account information at any time by logging in to your account. You can review and correct the information about you that TheLotusOnline keeps on file by contacting us as described below.</p>

<h4>Links to Other Web Sites</h4>

<p>TheLotusOnline is not responsible for the practices employed by websites linked to or from our website, nor the information or content contained therein. Please remember that when you use a link to go from our website to another website, our Privacy Policy is no longer in effect. Your browsing and interaction on any other website, including those that have a link on our website, is subject to that website's own rules and policies. Please read over those rules and policies before proceeding.</p>

<h4>Notification Procedures</h4>

<p>It is our policy to provide notifications, whether such notifications are required by law or are for marketing or other business related purposes, to you via email notice, written or hard copy notice, or through conspicuous posting of such notice on our website, as determined by TheLotusOnline in its sole discretion. We reserve the right to determine the form and means of providing notifications to you.</p>

<h4>Changes to Our Privacy Policy</h4>

<p>If we change our privacy policies and procedures, we will post those changes on our website to keep you aware of what information we collect, how we use it and under what circumstances we may disclose it. Changes to this Privacy Policy are effective when they are posted on this page.</p>

<h4>Contact us with any questions</h4>

<p>Please contact our Privacy Department ([privacy@TheLotus.Online](mailto:privacy@thelotus.online)) with any questions or concerns regarding our policy.</p>

<h5>Effective Date: July 6, 2020</h5>
    </div>
</div>




                </div><!--form-group-->
                    
                </form><!--form-horizontal--> 
            </div><!--modal-body-->

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div><!--modal-footer-->
        </div><!--modal-content-->
    </div><!--modal-dialog-->
</div><!--modal login-->

    
  </body>
</html>

<script src="https://js.stripe.com/v3/"></script>
<script>
    
function disableSubmit() {
  document.getElementById("regSubmit3").disabled = true;
 }

  function activateButton(element) {

      if(element.checked) {
        document.getElementById("regSubmit3").disabled = false;
       }
       else  {
        document.getElementById("regSubmit3").disabled = true;
      }

  }

</script>