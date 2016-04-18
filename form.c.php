**** This form is a work in progress.  It is super broken at the moment and
needs to use an Inclusion class instance properly,
and also use an Authenticator class instance! ****


<?php
$msg = "Login Form:";
?>






<?php

use wdid\Utils as Utils;

$ustr = 'wdid_form_post_username';
$pstr = 'wdid_form_post_password';





if (  array_key_exists( $ustr, $_POST ) && array_key_exists( $pstr, $_POST )  ){

    $provided_username = $_POST[ $ustr ];
    $provided_password = $_POST[ $pstr ];
    $login_was_sucessful = false;
    if ( $provided_username === 'wdid' ){
        if ($provided_password === 'wdid-0wdid' ){
            $login_was_sucessful = true;            
        }
    }
    
    if (  $login_was_sucessful === true  ){
        echo 'login successful';
    } else {
        echo 'login failed';
    }
    
}
else {
    //echo "Output form here.";   
    ?>
                <form class = "wdid_test_form" role = "form_test_wdid" 
                    action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
                    ?>" method = "post">
                    <h4 class = "form-signin-heading"><?php echo $msg; ?></h4>
                    <input type = "text" class = "form-control" 
                       name = "wdid_form_post_username" placeholder = "yourUserName" 
                       required autofocus></br>
                    <input type = "text" class = "form-control"
                       name = "wdid_form_post_password" placeholder = "yourPassword1234"
                       required>
                    <button class = "btn btn-lg btn-primary btn-block" type = "submit" 
                       name = "login">Login</button>
                </form>    
    
    <?php
 
}





//Utils::EchoLine( $_POST['wdid_test_username'] );
//Utils::EchoLine( $_POST['wdid_test_password'] );