<?php require_once("_/components/php/includes/session.php"); ?>
<?php require_once("_/components/php/includes/connection.php"); ?>
<?php require_once("_/components/php/includes/functions.php"); ?>
<?php
// index.php - landing page of the TLF website
// will show login button
//
// (c) 2020, TLF
// Written by James Misa

if(isset($_REQUEST['key'])) {$key = $_REQUEST['key'];}
if(isset($_REQUEST['id'])) {$id = $_REQUEST['id'];}
if(isset($_REQUEST['name'])) {$name = $_REQUEST['name'];}

$query = "SELECT * ";
$query .= "FROM harvests ";
$query .= "WHERE id = '{$id}' ";
$query .= "AND receiver_key = '{$key}' ";
$query .= "LIMIT 1";
$resultSet = mysqli_query($connection, $query);
confirm_query($resultSet, $connection);
if (mysqli_num_rows($resultSet) == 1) {
    // username/password authenticated
    while ($foundUser = mysqli_fetch_array($resultSet)) {
        $harvestId = $foundUser['id'];
        $water_id = $foundUser['water_id'];
        $fire_id = $foundUser['fire_id'];
        $gifter_name = $foundUser['gifter_name'];
        $signatureImg = $harvestId.''.$fire_id;
    }

    $query4 = "SELECT gift_amt ";
    $query4 .= "FROM users ";
    $query4 .= "WHERE lotus_id = '{$water_id}'";
    $resultSet4 = mysqli_query($connection, $query4);
    confirm_query($resultSet4, $connection);
    if(mysqli_num_rows($resultSet4) > 0) {
        $foundRow = mysqli_fetch_array($resultSet4);
        $gift_amt = $foundRow['gift_amt'];
    }

}else{
    echo "You're trying to access wrong URL, please get correct URL to sign doc.";
    die();
}

if (isset($_POST['submit'])) {

    $receiver_signature = $_REQUEST['receiver_signature'];
    $receiver_name = $_REQUEST['receiver_name'];
    $current_time = date('Y-m-d');
    $imgData = addslashes(file_get_contents($_REQUEST['receiver_signature']));

    $query2 = "UPDATE harvests SET is_receiver_sign = 1, receiver_name='{$receiver_name}', receiver_signature = '{$imgData}', receiver_sign_date = '{$current_time}' WHERE id='{$id}' AND receiver_key='{$key}'";
    $result = mysqli_query($connection, $query2);
    header("Location: signature_thanks.php");
    die();
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
    <link href="_/css/signature.css" rel="stylesheet">
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
        <h1 class="gift-title">Non-Solicitation & Gifting Letter (e-Signature)</h1>
        <div class="gift-inst">
        <p style="font-family:sans-serif; font-weight:700;">Please review the document below and follow these three (3) simple steps:</p>
        
        <ol style="font-family:sans-serif; margin-left:20px;">
            <li>Type your name and choose font type</li>
            <li>Check confirmation box</li>
            <li>Click submit</li>
        </ol>  
        
        <p style="font-family:sans-serif;">*You will receive confirmation that your gifting activity is complete and a copy of this document will be available for download in your back office. </p>
        </div>
        <div id="wrapper">
        <h1 style="text-align:center">Non-Solicitation</h1>
        <p>I, <span style="color: red"><?php echo $name?></span>, hereby confirm with full personal and legal responsibility, that I have requested this information of my own free will and accord, and that I am not seeking investment opportunities.</p>
        <p> I hereby affirm that the information that I am requesting is about a private gifting activity.</p>
        <p>I hereby confirm that neither you nor anyone on your behalf or anyone else associated
            with your activity has solicited me in any way. All parties state as truth that they are not
            employees or officials in or of any agency, and are not a member of the media whose
            purpose is to collect information for defamation or prosecution. All parties agree that
            falsification of this criteria entitles the party defrauded thereby is entitled to $100,000.00
            (U.S.) for violation of rights against forced association.</p>
        <p>Any documents or information received by me will not be construed as solicitation in any
            way whatsoever. I further affirm that I have been told that the nature of these activities is
            that of charity and I affirm that my involvement with gifting is solely a voluntary act of my
            own accord. I also understand that should I get involved with gifting that my gift will be
            just that, a gift, and it is nothing to which I may lay claim in the future; it is a gift.</p>
        <p>It is agreed that a fax or email copy will be considered legal and enforceable as an original.</p>
        <h1 style="text-align:center">Gifting Statement</h1>
        <h4>Title 26, United States Code Section: 2501, 2502, 2504, 2511</h4>
        <p>I, <span style="color: red"><?php echo $name?></span>, do hereby declare under penalties of perjury that the following statements are true and correct to the very best of my knowledge.</p>
        <p>Any and all property of any nature that I transfer from my ownership and possession to the recipient of my gift, is intended as a gift and not as an investment.  I have not been sold anything and I have not purchased anything, and I have not been offered any opportunity to do so.</p>
        <p>I have been told to not expect any return of any nature, and I have received no license or privilege of soliciting or recruiting other parties to participate in this gifting activity.  With this statement I waive any and all my rights to civil or criminal remedies against the recipient of my gift and the gifting activity as a whole.</p>
        <div class="page-break"></div>
        <p>I perceive no agreement between myself and the recipient of my gift, and I expect no profit, benefit, or opportunity of any nature in consideration of the property that I have been transferred as a gift.  I believe that I am totally within the law, as it pertains to my activities herein described.</p>
        <p>My intent is to give a gift of <span style="color: red">$<?php echo $gift_amt;?></span> to an individual, and I do not intend for the gift to be an investment, or a payment for which I am owed anything of any value or nature, and I acknowledge that my gift does not entitle me to any future opportunity or benefit of any nature.  I understand that the gifting activity accepts only gifts and that they absolutely do not accept any property offered with the intent of its owner that a future return or opportunity be obtained or secured by virtue of their having transferred said gift to another individual.</p>
        <p>I have agreed under this gift contract to not reassert any rights to the property that I now give freely as a gift to another individual.  I am a fully informed and consenting adult and I have not been misled in anyway.</p>
        <p>I do hereby declare under penalties of perjury that the foregoing statement is true and correct, and are binding upon me to the full extent expressed therein.</p>
        <form name="sign_doc" action="" method="post" class="">
            <table style="width: 100%; color: red; text-align: left">
                <tr><td>&nbsp;</td></tr>
                <tr>
                    <td>Name of Receiver</td>
                    <td><input type="text" name="receiver_name" value="<?php echo $name?>" class="" /></td>
                </tr>
                <tr><td>&nbsp;</td></tr>
                <tr>
                    <td>Signature</td>
                    <td>
                        <input type="text" name="receiver_signature_txt" id="signature" class="" value="" />
                    </td>
                </tr>
                <tr>
                    <td>Signature Font</td>
                    <td>
                        <select name="signatureFont" id="signatureFont" required>
                            <option value="">Select Font Type</option>
                            <option value="angelloniaBold">angelloniaBold</option>
                            <option value="almondita">almondita</option>
                            <option value="allisonScript">allison-script</option>
                            <option value="alexandroupoli">alexandroupoli</option>
                            <option value="aerotis">aerotis</option>
                        </select>
                    </td>
                </tr>
                <tr><td colspan="2" style="text-align: center">
                        <div id="signatureDev"></div>
                    </td>
                </tr>
                <tr>
                    <td>Date</td>
                    <td><?php echo date('Y-m-d')?>
                        <input type="hidden" name="receiver_sign_date" value="<?php echo date('Y-m-d')?>" /></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="checkbox" name="is_receiver_sign" value="1"> Check box to sign document.</td>
                </tr>
                <tr>
                    <td colspan="2"><input class="btn btn-primary btn-block" type="submit" name="submit" value="submit" onclick="alert('Congratulations! You've completed the gifting process.');"/></td>
                </tr>
            </table>
            <input type="hidden" name="receiver_signature" id="receiver_signature" />
            <input type="hidden" name="receiver_key" id="gifter_key" value="<?php echo $key?>" />
        </form>
            
        <?php $ip_address = getUserIP(); ?>
            
        <p style="font-size:20px; color:red;">Your IP Address <?php echo $ip_address; ?> recorded for validation.</p>
            
        <p style="font-size:14px ">* By participating in this activity you have in no way purchased a "position" or "spot".  You have not purchased the right to make money or proceeds and you have in no way purchased the right to benefit from gifting.  It simply means that you have given a gift and the participation with this activity is logged and recorded.</p>
        </div>
    </div><!--content-->
    <?php include "_/components/php/footer.php"; ?>
</section><!--container-->

<script>
    $(document).ready(function(){
        var signature = $("#signature");
        var signatureDev = $("#signatureDev");
        var signatureFont = $("#signatureFont");
        signature.keydown(function(){
            signatureDev.html(signature.val());
        });
        signature.keyup(function(){
            signatureDev.html(signature.val());
        });
        signatureFont.change(function (){

            signatureDev.attr('class', '');
            signatureDev.addClass(signatureFont.val());
            var dataString = 'font='+signatureFont.val()+'&signature='+signature.val()+'&type=receiver&signatureImg='+<?php echo $id?>;
            signatureDev.html('<img src="images/loading.gif" />')
            jQuery.ajax({
                type: "POST",
                url: "signature.php",
                data: dataString,
                success: function(msg){

                    setTimeout(function(){
                        signatureDev.html('<img src="'+msg+'" />');
                        $('#receiver_signature').val(msg);
                    }, 5000);

                },
                error: function(){
                    alert("failure");
                }
            });

        });
    });
</script>
</body>
</html>