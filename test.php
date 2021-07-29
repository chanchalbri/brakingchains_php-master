<?php require_once("_/components/php/includes/session.php"); ?>
<?php require_once("_/components/php/includes/connection.php"); ?>
<?php require_once("_/components/php/includes/functions.php"); ?>
<?php 
/*
function welcomesmail ($email_address) {
    //need css
        $to      = $email_address;
		$subject = 'WELCOME to The Eden Project!';
}
        $message = '<html><body style="margin:20px; max-width:700px;"><p>Welcome Chain Breaker!!</p>' .  
				   '<p>Thank you for seeing the vision of our <strong>Breaking Chains Private Cooperative</strong> and participating in The Eden Project. The Eden Project is the financial support arm for our members. </p>' . 
                   '<p>Remember, there are 2 things that we ask:</p>'  .
                   '<ol style="margin-left:20px; font-weight:bold;">' . 
                    '<li>Sow your support to your “Tree of Life”</li>' .
                    '<li>Have two (2) like-minded, trustworthy friends or family accept the invitation to join theCooperative and The Eden Project.</li>' .
                   '</ol>' . 
                   '<p>Do not spoil it for them. You want them to see and hear it just like you did. So, don’t try to explain it. Let the presentation give the information for you. <mark>DO NOT POST THIS ON SOCIAL MEDIA!!! THIS GROUP CONSISTS OF FRIENDS AND FAMILY ONLY THAT HAVE BEEN PERSONALLY INVITED!!</mark> </p>' .
                   '<p><strong>You will sow your support to the following:</p>' .
                   '<p style="margin-left:20px;">Name: ' . $name . '</p>' .
                   '<p style="margin-left:20px;">Number: ' . $number . '</p>' .
                   '<p style="margin-left:20px;">Email: ' . $email . '</p>' .
                   '<p style="margin-left:20px;">Support Method: ' . $method . '</p>' .
                   '<p style="margin-left:20px;">Date to Sow: ' . $date . '</strong></p>' .
                   '<p>Blessings Upon Blessings,</p>' .
                   '<p><strong>Next Steps:</strong></p>' .
                    '<ol style="margin-left:20px;">' . 
                    '<li>Reply to this email with your preferred support method (i.e Zelle, CashApp, Paypal,Venmo, Xoom) and the information associated with that method.</li>' .
                    '<li>As soon as they are identified, send your referrals the Future Chain Breaker Welcomeemail. Don’t forget to add your referral link.</li>' .
                    '<li>Also send me their names, numbers, email addresses and support methods andsupporting information of your two (2) Seeds.</li>' .
                    '<li>The Thursday prior to your entry into Eden, your “Tree of Life” will send you a textand/or email to welcome you, introduce him/herself, and reiterate the method in whichhe/she would like to be supported. <mark>WHEN YOU RECEIVE THESE TEXTS and/or EMAILS,PLEASE REPLY TO THEM.</mark></li>' .
                    '<li><strong>JOIN THE EDEN PROJECT BY SOWING YOUR SEED SUPPORT TO YOUR TREE OF LIFE BY12:00 PM!!</strong></li>' .
                    '<li>Upon receipt of your support, your “Tree of Life” will send you a thank you text as well as let you know who your two (2) seeds will support the following week.</li>' .
                   '</ol>' . 
				   '<p>Now it\'s time to grow your Tree of Life.</p>' .
				   '<div style="border:1px solid black; border-radius:10px; padding:10px; margin-bottom:10px;"><p style="color:yellow;">THE GATE</p>' .
				   '<p"><strong>Week 1: </strong>You will join The Eden Project at The Gate.</p>' .
				   '<p><strong>Week 2: </strong> Your two (2) “seeds” will join The Eden Project at The Gate and you will move to “Seedling”</p>' .
				   '<p><strong>Week 3: </strong> The two people you invited will invite their two (2) “Seeds” each and you will move to “Plant”</p>' .
				   '<p><strong>Week 4: </strong> YOU ARE NOW THE TREE OF LIFE!!!! Those four (4) Seeds will invite their two (2) Seeds each and those eight (8) Seeds will each sow their support of $100 each to you.</p>' .
				   '<p><strong>CONGRATULATIONS, YOU HAVE NOW REAPED YOUR HARVEST AND WILL NOW ENTER THE GARDEN.</strong></p>' .
				   '<p><strong>Week 5: </strong> It’s time to Re-Sow. Take $100 from your $800 Harvest and Re-Sow your $100 seed support to the same “Tree of Life” you sowed into initially and in 21 days, reap your harvest again. Then do it all over again. It’s that simple.</p></div>' .
				   '<div style="border:1px solid black; border-radius:10px; padding:10px;"><p style="color:purple;">THE GARDEN</p>' .
				   '<p><strong>THE SUNDAY AFTER YOUR GATE HARVEST, YOU WILL TAKE $500 AND SOW INTO THE GARDEN.</strong></p>' .
                   '<p><strong>You will sow your support to the following:</p>' .
                   '<p style="margin-left:20px;">Name: ' . $name . '</p>' .
                   '<p style="margin-left:20px;">Number: ' . $number . '</p>' .
                   '<p style="margin-left:20px;">Email: ' . $email . '</p>' .
                   '<p style="margin-left:20px;">Support Method: ' . $method . '</p>' .
                   '<p style="margin-left:20px;">Date to Sow: ' . $date . '</strong></p>' .
				   '<p"><strong>Week 1: </strong>You will enter The Garden.</p>' .
				   '<p><strong>Week 2: </strong>The same two (2) Plants in your Tree from the Gate will follow you into The Garden and you will move to a Seedling in the Garden.</p>' .
				   '<p><strong>Week 3: </strong>The same four (4) Seedlings in your Tree from the Gate will follow you into The Garden and you will move to a Plant in the Garden.</p>' .
				   '<p><strong>Week 4: YOU ARE NOW THE TREE OF LIFE IN THE GARDEN!!!! </strong>Those same eight (8) Seeds that supported you in the Gate will each sow their support of $500 each to you in the Garden.</p>' .
				   '<p><strong>Week 5: </strong>It’s time to Re-Sow. Take $500 from your $4000 Harvest and Re-Sow your $500 seed support to the same “Tree of Life” you sowed into initially in The Garden and in 21 days, reap your harvest again. Then do it all over again. It’s that simple.</p></div>' .
				   '<p><strong>RENEGE OF SUPPORT</strong></p>' .
				   '<p>Your agreement to participate in The Eden Project is voluntary and this support is given freely and without coercion. This support is given without consideration and no repayment is expected or implied either in the form of cash or by future services.</p>' .
				   '<p><strong>THEREFORE, NO SUPPORTS WILL BE RETURNED. <mark>PLEASE BE VERY SURE ON YOUR DECISION TO JOIN THE EDEN PROJECT</mark></strong></p>' .
				   '<p>My hope is that this Initiative blesses you and your family.</p>' .
				   '<p><strong><mark>PLEASE RESPOND ACKNOWLEDGING THAT YOU HAVE CHOSEN TO PARTICIPATE IN THE EDEN PROJECT AND YOU ARE CLEAR ON ALL INFORMATION STATED ABOVE.</mark></strong></p>' .
				   '<p>Mary L. Boyde</p>' .
				   '<p>Founder</p>' .
				   '<p style="color:grey;">Copyright Notice.  All materials contained within this document are protected by United States copyright law and may not be reproduced, distributed, transmitted, displayed, published, altered or broadcasted without the prior, express written permission of Breaking Chains Private Cooperative, LLC.  ©Copyright 2020 Breaking Chains Private Cooperative, LLC
                    </p></body></html>';
    
    echo $message;
*/

$date = "2020-11-19 20:32:20";
$new_date = strtotime($date);
echo $new_date;
?>