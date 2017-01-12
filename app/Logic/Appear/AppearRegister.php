<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 4/5/16
 * Time: 2:58 PM
 */

class AppearRegister {

    public static function validateUname(){

        $json['bool'] = 1;

        $u = addslashes($_POST['u']);

        $uname_min = 5;
        $uname_max = 15;

        if(strlen($u)<$uname_min || strlen($u)>$uname_max){
            $json['bool'] = 0;
            $json['err'] = "The username is the wrong length. Min $uname_min Max $uname_max Characters.";
        }
        else {
            $acc = new Account();
            $arr = $acc->getWhere("admin_username = '$u'");

            if (count($arr) > 0) {
                $json['bool'] = 0;
                $json['err'] = "Username is already being used";
            }
        }

        echo json_encode($json);

        exit();
    }

    public static function check_email(){
        $needVerify = Efiwebsetting::getData("needVerify");

        if($needVerify == "true") {
            ?>
            <div class="container attop">
                <div class="col-md-6 col-md-offset-3">
                    <div class="appear_logo_pages">
                        <a href="<?=_SPPATH;?>">
                            <img src="<?=_SPPATH;?>images/registration.png" >
                        </a>
                    </div>


                    <h1 class="hype">Registration Successful</h1>
                    <h4 class="hype">Check your Email to verify your registration</h4>

                    <h3 class="hype"><a href="<?= _SPPATH; ?>">log in</a></h3>

                </div>
            </div>
            <style>
                .hype {
                    color: white;
                    text-align: center;
                }
            </style>
        <?
        }else{



            $type = addslashes($_GET['type']);
            if($type!="app"){
                $type = "agent";
            }

            if($type == "agent") {

                header("Location:" . _SPPATH . "mydashboard");
            }else{
                header("Location:" . _SPPATH . "myapps");
            }
            exit();
        }
    }

    public static function verify(){
        $mid = addslashes($_GET['mid']);
        $hash = addslashes($_GET['token']);

        if($mid==""||$hash == "")die("Hacking Attempt");

        $acc = new Account();
        $nr = $acc->getWhere("admin_hash = '$hash' AND admin_username = '$mid'");


        if(count($nr) == 1){

            $acc = $nr[0];

            $acc->getByID($mid);
            $acc->admin_aktiv = 1;
            $acc->load = 1;
            $acc->save();
            ?>
            <div class="container attop">
                <h1 class="hype">You are now verified!!</h1>
                <h2 class="hype">Please <a href="<?=_SPPATH;?>loginpage">login</a></h2>
            </div>
        <?
        }else{
            ?>
            <div class="container attop">
                <h1 class="hype">Verification Error!!</h1>
                <h2 class="hype">Please <a href="<?=_SPPATH;?>register">register</a> again or <a href="<?=_SPPATH;?>contact">contact us</a> </h2>
            </div>
        <?
        }
    }

    public static function processRegister($mode = "web"){

        //masi copy paste
        $uname_min = 5;
        $uname_max = 15;

        $passwd_min = 5;
        $passwd_max = 15;

        $hp_min = 9;
        $hp_max = 15;


        $json = array();
        $json['err'] = "";
        $json['bool'] = 0;

        //utk webservices
        $json['status_code'] = 0;
        $json['status_message'] = "Incomplete Request";

        if($mode == "web") {
            //check captcha
            if (isset($_POST['g-recaptcha-response'])) {
                $captcha = $_POST['g-recaptcha-response'];
            }
            if (!$captcha) {
                $json['err'] .= Lang::t('Please verify that you are not a robot') . "<br>";
            } else {
                $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LdxXBMTAAAAAAgT0r9Vgly2P8yyrtU2Io-OVDZa&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
                if ($response . success == false) {
                    $json['err'] .= Lang::t('Please verify that you are not a robot') . "<br>";
                } else {
                    //echo '<h2>Thanks for posting comment.</h2>';
                    //human
//                $json['err'] .= Lang::t('HUMANNN')."<br>";
                }
            }
            //END check captcha
            //check token
            $rand = $_SESSION['rand'];
            $token = $_POST['token'];

            if ($rand != $token) {
                $json['err'] .= "Wrong Token<br>";
            }
        }
        //eND check token

        if($mode == "web") {
            //check username
            $uname = addslashes($_POST['uname']);
            if (!validate_alphanumeric_underscore($uname)) {
                $json['err'] .= "Username must be alphanumeric<br>";
            }
            if ($uname == "") {
                $json['err'] .= "Username cannot be empty<br>";
            }
            if (strlen($uname) < $uname_min || strlen($uname) > $uname_max) {
                $json['err'] .= "The username is the wrong length. Min $uname_min Max $uname_max Characters.<br>";
            }
        }else{
            $uname = addslashes($_POST['email']);
        }
        //apakah sudah terpakai

        //END
        //Check password
        $pwd = addslashes($_POST['pwd']);
//        if(!validate_alphanumeric_underscore($pwd)){
//            $json['err'] .= "Password must be alphanumeric<br>";
//        }
        if($pwd==""){
            $json['err'] .= "Password cannot be empty<br>";
        }
        if(strlen($pwd)<$passwd_min || strlen($pwd)>$passwd_max){
            $json['err'] .= "The password is the wrong length. Min $passwd_min Max $passwd_max Characters.<br>";
        }

        $pwd2 = addslashes($_POST['pwd2']);
        if($pwd != $pwd2){
            $json['err'] .= "Password mismatched.<br>";
        }
        //EnD

        //CHeck name
        $name = addslashes($_POST['name']);
        if($name==""){
            $json['err'] .= "Name cannot be empty<br>";
        }
        if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
            $json['err'] .= "Only letters and white space allowed<br>";
        }
        //END
        //Check Address
//        $addresss = addslashes($_POST['addresss']);
//        if($addresss==""){
//            $json['err'] .= "Address cannot be empty<br>";
//        }
        //END
        //Check email
        $email = addslashes($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $json['err'] .= "Invalid Email Address<br>";
        }
        //apakah sudah terpakai

        //END
        //Check Phone
        $phone = addslashes($_POST['phone']);
        if(strlen($phone)<$hp_min || strlen($phone)>$hp_max){
            $json['err'] .= "The phone is the wrong length. Min $hp_min Max $hp_max Characters.<br>";
        }
        //ENd

        if($json['err'] == ""){

            //cek apakah email dan username masi free
            $acc = new Account();

            if($mode == "web") {

                $nr2 = $acc->getJumlah("admin_username = '$uname'");


                if ($nr2 > 0) {
                    $json['err'] .= "Username is already being registered.<br>";
                }
            }

            $nr = $acc->getJumlah("admin_email = '$email'");
            if ($nr > 0) {
                $json['err'] .= "Email is already being registered.<br>";
            }

            if($json['err'] == ""){

//                echo "pwd : ".$pwd;
                //process password
                $crypt = Account::cryptPassword($pwd);

//                echo "crypt ".$crypt;

                //save as new Account
                $acc->admin_email = $email;
                $acc->admin_ip = $_SERVER['REMOTE_ADDR'];
                $acc->admin_nama_depan = $name;
                $acc->admin_password = $crypt;
                $acc->admin_webpassword = $crypt;
                $acc->admin_username = $uname;
                $acc->admin_role = "normal_user";
                $acc->admin_type = 1;
                $acc->admin_aktiv = 1;
                $acc->admin_hash = md5($uname.$pwd.time());
                $acc->admin_reg_date = leap_mysqldate();
                $acc->admin_lastupdate = leap_mysqldate();
                $acc->admin_marketer = addslashes($_POST['marketer']);
                $acc->admin_phone = $phone;

                $mid = $acc->save();
                if($mid){

                    $needVerify = Efiwebsetting::getData("needVerify");

                    $dataEmail = new DataEmail();

                    if($needVerify == "true") {

                        $succEmail = $dataEmail->registrationSuccessWithVerify($email,$uname,$acc->admin_hash);


                    }
                    elseif($needVerify == "push"){

                        $succEmail = 1; //cuman dummy



                        /*
                         * send push ke marketer if any
                         */


                        /*
                         * get register data
                         */
                        $_POST['usrname'] = $email;
                        $_POST['pswd'] = $pwd;

                        $appapi = new AppAPI();
                        $appapi->login_me();

                    }
                    else{

                        //aktivasi langsung
                        $arrAcc = $acc->getWhere("admin_email = '$email' LIMIT 0,1");
                        $acc2 = $arrAcc[0];
                        $acc2->load = 1;
//                        $acc->getByID($mid);
                        $acc2->admin_aktiv = 1;
                        $acc2->save();

                        $succEmail = $dataEmail->registrationSuccessWithOutVerify($email,$uname);

                        //kalau ada marketer send ke marketer jg
                        if($acc2->admin_marketer != "") {
                            $arrAcc2 = $acc->getWhere("admin_username = '{$acc2->admin_marketer}' LIMIT 0,1");
                            if(count($arrAcc2)>0) {
                                $acc_marketer = $arrAcc2[0];
                                $succEmail2 = $dataEmail->registrationSuccessToMarketer($acc_marketer->admin_email, $uname,$acc2->admin_marketer);
                            }else{
                                $succEmail2 = $dataEmail->registrationSuccessToMarketer(Efiwebsetting::getData("franchiseEmail"), $uname,$acc2->admin_marketer);
                                $acc2->admin_marketer = "";
                                $acc2->save();
                            }
                        }

                        //loginin
                        $_POST['admin_username'] = $acc->admin_username;
                        $_POST['admin_password'] = $acc->admin_password;
                        $_POST['rememberme'] = 1;

                        $username = addslashes($_POST["admin_username"]);
                        $password = addslashes($_POST["admin_password"]);
                        $rememberme = (isset($_POST["rememberme"]) ? 1 : 0);

                        $row = array ("admin_username" => $username, "admin_password" => $password, "rememberme" => $rememberme,
                            "admin_ldap"     => 0);

                        if($mode == "web") {
                            //login pakai row credential
                            Auth::login($row);
                        }
                    }
                    //send email
//                    $lm = new Leapmail();
//                    $lm->senderMail = "registration@yourapp.com";

                    //sementara disini..krn response error

                    $json['status_code'] = 1;
                    $json['status_message'] = "Registration Success";

                    $json['bool'] = 1;
                    $json['mid'] = $mid;

                    if($succEmail){
//                        $json['err'] .= $succEmail;
                    }else{
                        $json['err'] .= "Send Email failed. Please <a href='"._SPPATH."contact'>contact</a> us by email or phone.<br>";
                    }

                }
                else{
                    $json['status_code'] = 0;
                    $json['status_message'] = "Saving failed";
                    $json['err'] .= "Save failed. Please <a href='"._SPPATH."contact'>contact</a> us by email or phone.<br>";
                }

            }
        }

        echo json_encode($json);
        die();
    }

    public static function registerForm(){
        $type = addslashes($_GET['type']);
        if($type != "app"){
            $type = "agent";
        }

        $aid = addslashes($_GET['aid']);


        $rand = time().rand(0,100);

        $_SESSION['rand'] = $rand;

        $uname_min = 5;
        $uname_max = 15;

        $passwd_min = 5;
        $passwd_max = 15;

        $hp_min = 9;
        $hp_max = 15;

        if(Auth::isLogged()){
            header("Location:"._SPPATH."mydashboard");
            exit();
        }
        ?>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <div class="container attop" >
        <div class="col-md-8 col-md-offset-2">
        <div class="appear_logo_pages">
            <a href="<?=_SPPATH;?>">
                <img src="<?=_SPPATH;?>images/registration.png" >
            </a>
        </div>
        <div class="berpadding" style="padding-top: 30px; padding-bottom: 50px;">

            <form id="formreg" class="form-horizontal" role="form" >
                <input type="hidden" name="token" value="<?=$rand;?>">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="uname">Username : </label>
                    <div class="col-sm-10">
                        <input name="uname" type="text" class="form-control" id="uname" placeholder="Enter username">
                        <div id="uname_err" class="err"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="name">Full Name : </label>
                    <div class="col-sm-10">
                        <input name="name" type="text" class="form-control" id="name" placeholder="Enter name">
                        <div id="name_err" class="err"></div>
                    </div>
                </div>
                <!--                <div class="form-group">-->
                <!--                    <label class="control-label col-sm-2" for="addresss">Address: </label>-->
                <!--                    <div class="col-sm-10">-->
                <!--                        <textarea name="addresss" id="addresss" class="form-control" rows="5"></textarea>-->
                <!--                        <div id="address_err" class="err"></div>-->
                <!--                    </div>-->
                <!--                </div>-->
                <div class="form-group">
                    <label class="control-label col-sm-2" for="phone">Mobile Phone : </label>
                    <div class="col-sm-10">
                        <input name="phone" type="tel" class="form-control" id="phone" placeholder="Enter mobile phone">
                        <div id="phone_err" class="err"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Email : </label>
                    <div class="col-sm-10">
                        <input name="email" type="email" class="form-control" id="email" placeholder="Enter email">
                        <div id="email_err" class="err"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="pwd">Password : </label>
                    <div class="col-sm-10">
                        <input name="pwd" type="password" class="form-control" id="pwd" placeholder="Enter password">
                        <div id="pwd_err" class="err"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="pwd2">Repeat Password : </label>
                    <div class="col-sm-10">
                        <input name="pwd2" type="password" class="form-control" id="pwd2" placeholder="Repeat password">
                        <div id="pwd2_err" class="err"></div>
                    </div>
                </div>
                <? if($aid == ""){?>
                    <hr>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="marketer">Marketer : </label>
                        <div class="col-sm-10">
                            <input name="marketer" type="text" class="form-control" id="marketer" placeholder="Marketer Username">
                            <div id="marketer_err" class="err"></div>
                        </div>
                    </div>
                <? }else{ ?>
                    <input name="marketer" type="hidden" class="form-control" id="marketer" value="<?=$aid;?>">
                <? } ?>
                <hr>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div style="text-align: center; padding: 10px;">
                            <div class="g-recaptcha" data-sitekey="6LdxXBMTAAAAACQrkdGjb1Wqmrnkw8uVfd94OAjg"></div>
                            <div id="captcha_err" class="err"></div>
                        </div>
                    </div>
                </div>
                <div id="resultajax" style="display: none; text-align: center;" class="alert alert-danger"></div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button style="width: 100%;" type="submit" class="btn btn-primary btn-appeargreen btn-lg">Submit</button>
                        <div class="back_to_button" >
                            <a href="<?=_SPPATH;?>loginpage">back to login</a>
                        </div>
                    </div>
                </div>
            </form>

        </div>

        <script>
            $( "#formreg" ).submit(function( event ) {
                if(allowed) {
                    if (validateFormOnSubmit(this)) {
//                        alert("benar semua1");
                        var $form = $(this);
                        var url = "<?=_SPPATH;?>processRegister";

                        $(".err").hide();

                        // Send the data using post
                        var posting = $.post(url, $form.serialize(), function (data) {
//                            console.log(data);
                            if (data.bool) {
                                //kalau success masuk ke check your email....
                                document.location = "<?=_SPPATH;?>check_your_email?type=<?=$type;?>";
                            }
                            else {
                                $("#resultajax").show();
                                $("#resultajax").html(data.err);
                            }
                        }, 'json');

                    } else {

                    }
                }else{
                    alert("Please complete registration");
                }


                event.preventDefault();
            });

            var allowed = 0;
            $('#uname').blur(function(){
                var slc = $('#uname').val();

                $.post("<?=_SPPATH;?>validateUname",{u:slc},function(data){
//                    console.log(data);
                    if(!data.bool){
//                            $('#uname').css("background",'#CCCCCC');

                        $('#uname_err').css( "color", "red").show().html(data.err);
                        console.log("after"+data.err);
                    }else{
                        $('#uname_err').hide();
                        allowed = 1;
                    }
                },'json');
            });
        </script>
        <script>
            function validateFormOnSubmit(theForm) {
                var reason = "";

                reason += validateUsername(theForm.uname);
                reason += validatePassword(theForm.pwd);
                reason += validatePassword(theForm.pwd2);
                reason += validateEmail(theForm.email);
                reason += validatePhone(theForm.phone);
//                    reason += validateEmpty(theForm.addresss);
                reason += validateEmpty(theForm.name);

                if(theForm.pwd.value != theForm.pwd2.value){
                    var error = "Password not mismatched.\n"
                    $( theForm.pwd ).next().css( "color", "red").show().html(error);
                    theForm.pwd.style.background = '#CCCCCC';
                    theForm.pwd2.style.background = '#CCCCCC';
                    $( theForm.pwd2 ).next().css( "color", "red").show().html(error);
                    reason += error;
                }

                if (reason != "") {
//                        alert("Some fields need correction:\n" + reason);
                    return false;
                }

                return true;
            }

            function validateEmpty(fld) {
                var error = "";

                if (fld.value.length == 0) {
                    error = "The required field has not been filled in.\n"
                    fld.style.background = '#CCCCCC';
                    $( fld ).next().css( "color", "red").show().html(error);

                } else {
                    fld.style.background = 'White';
                    $( fld ).next().hide();
                }
                return error;
            }

            function validateUsername(fld) {
                var error = "";
                var illegalChars = /\W/; // allow letters, numbers, and underscores

                if (fld.value == "") {
                    fld.style.background = '#CCCCCC';
                    error = "You didn't enter a username.\n";
                    $( fld ).next().css( "color", "red").show().html(error);
                } else if ((fld.value.length < <?=$uname_min;?>) || (fld.value.length > <?=$uname_max;?>)) {
                    fld.style.background = '#CCCCCC';
                    error = "The username is the wrong length. Min <?=$uname_min;?> Max <?=$uname_max;?> Characters.\n";
                    $( fld ).next().css( "color", "red").show().html(error);
                } else if (illegalChars.test(fld.value)) {
                    fld.style.background = '#CCCCCC';
                    error = "The username contains illegal characters.\n";
                    $( fld ).next().css( "color", "red").show().html(error);
                } else {
                    fld.style.background = 'White';
                    $( fld ).next().hide();
                }
                return error;
            }
            function validatePassword(fld) {
                var error = "";
                var illegalChars = /[\W_]/; // allow only letters and numbers

                if (fld.value == "") {
                    fld.style.background = '#CCCCCC';
                    error = "You didn't enter a password.\n";
                    $( fld ).next().css( "color", "red").show().html(error);
                } else if ((fld.value.length < <?=$passwd_min;?>) || (fld.value.length > <?=$passwd_max;?>)) {
                    error = "The password is the wrong length. Min <?=$passwd_min;?> Max <?=$passwd_max;?> Characters. \n";
                    $( fld ).next().css( "color", "red").show().html(error);
                    fld.style.background = '#CCCCCC';
                } else if (illegalChars.test(fld.value)) {
                    error = "The password contains illegal characters.\n";
                    $( fld ).next().css( "color", "red").show().html(error);
                    fld.style.background = '#CCCCCC';
                } else if (!((fld.value.search(/(a-z)+/)) && (fld.value.search(/(0-9)+/)))) {
                    error = "The password must contain at least one numeral.\n";
                    $( fld ).next().css( "color", "red").show().html(error);
                    fld.style.background = '#CCCCCC';
                } else {
                    fld.style.background = 'White';
                    $( fld ).next().hide();
                }
                return error;
            }
            function trim(s)
            {
                return s.replace(/^\s+|\s+$/, '');
            }

            function validateEmail(fld) {
                var error="";
                var tfld = trim(fld.value);                        // value of field with whitespace trimmed off
                var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/ ;
                var illegalChars= /[\(\)\<\>\,\;\:\\\"\[\]]/ ;

                if (fld.value == "") {
                    fld.style.background = '#CCCCCC';
                    error = "You didn't enter an email address.\n";
                    $( fld ).next().css( "color", "red").show().html(error);
                } else if (!emailFilter.test(tfld)) {              //test email for illegal characters
                    fld.style.background = '#CCCCCC';
                    error = "Please enter a valid email address.\n";
                    $( fld ).next().css( "color", "red").show().html(error);
                } else if (fld.value.match(illegalChars)) {
                    fld.style.background = '#CCCCCC';
                    error = "The email address contains illegal characters.\n";
                    $( fld ).next().css( "color", "red").show().html(error);
                } else {
                    fld.style.background = 'White';
                    $( fld ).next().hide();
                }
                return error;
            }
            function validatePhone(fld) {
                var error = "";
                var stripped = fld.value.replace(/[\(\)\.\-\ ]/g, '');

                if (fld.value == "") {
                    error = "You didn't enter a phone number.\n";
                    fld.style.background = '#CCCCCC';
                    $( fld ).next().css( "color", "red").show().html(error);
                } else if (isNaN(parseInt(stripped))) {
                    error = "The phone number contains illegal characters.\n";
                    $( fld ).next().css( "color", "red").show().html(error);
                    fld.style.background = '#CCCCCC';
                } else if ((stripped.length < <?=$hp_min;?>) || (stripped.length > <?=$hp_max;?>)) {
                    error = "The phone number is the wrong length. Make sure you included an area code.\n";
                    $( fld ).next().css( "color", "red").show().html(error);
                    fld.style.background = '#CCCCCC';
                }else {
                    fld.style.background = 'White';
                    $( fld ).next().hide();
                }
                return error;
            }

            //                function validateForm(){
            //                    var nameRegex = /^[a-zA-Z0-9]+$/;
            //                    var validfirstUsername = document.frm.firstName.value.match(nameRegex);
            //                    if(validUsername == null){
            //                        alert("Your first name is not valid. Only characters A-Z, a-z and '-' are  acceptable.");
            //                        document.frm.firstName.focus();
            //                        return false;
            //                    }
            //                }
        </script>
        </div>
        </div>
    <?
    }

    public static function forgotPasswordForm(){
        if(Auth::isLogged()){
            header("Location:"._SPPATH."mydashboard");
            exit();
        }
        ?>
        <div class="container attop" >
            <div class="col-md-4 col-md-offset-4">
                <div class="appear_logo_pages">
                    <a href="<?=_SPPATH;?>">
                        <img src="<?=_SPPATH;?>images/registration.png" >
                    </a>
                </div>
                <div class="berpadding" style="padding-top: 30px; padding-bottom: 50px;">
                    <p style="text-align: center;">
                        Please insert your email or username below, and we will send you a link to reset your password
                    </p>
                    <form id="formreg" class="form-horizontal" role="form" >
                        <input type="text" class="form-control">
                        <button style="margin-top: 10px; width: 100%;" class="btn btn-primary btn-appeargreen">Send New Password To My Email</button>
                        <div class="back_to_button" >
                            <a href="<?=_SPPATH;?>loginpage">back to login</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    <?
    }
} 