<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 12/4/15
 * Time: 11:45 AM
 */

class Goo extends WebApps{

    function index(){
        header("Location:"._SPPATH."loginpage");
        die();
    }


    /*
	 * login webview
	 */
    function login ()
    {
        /*
         * login logic
         */
        $acc = new AccountLogin();
        $acc->login_hook = array (
            "PortalHierarchy" => "getSelectedHierarchy",
            "NewsChannel"     => "loadSubscription",
            "Role"            => "loadRoleToSession"
        );

        $acc->process_login();
    }

    /*
     * Web View For logout
     */
    function logout ()
    {
        $acc = new AccountLogin();
        $acc->process_logout();
    }
    function forgotpassword(){
        AppearRegister::forgotPasswordForm();
    }

    function register(){

        AppearRegister::registerForm();
    }

    function validateUname(){

        AppearRegister::validateUname();
    }
    function check_your_email(){

        AppearRegister::check_email();
    }

    function verify(){
        AppearRegister::verify();
    }



    function processRegister(){
        AppearRegister::processRegister();
    }

    function loginpage ()
    {
//        if(Auth::isLogged()){
//            //loginin pakai cookie
//
//            header("Location:"._SPPATH."myapps");
//            exit();
//        }

//        pr($_COOKIE);
//        pr($_SESSION);
        ?>
        <style>
            @media (max-width: 768px) {

                .monly {
                    display: initial;
                }

                .donly {
                    display: none;
                }

                .loginbox{
                    margin: 0 auto;
                    margin-top: 50px;
                    width: 300px;

                }


            }

            @media (min-width: 768px) {
                .monly {
                    display: none;
                }

                .donly {
                    display: initial;
                }

                .loginbox{
                    margin: 0 auto;
                    margin-top: 80px;
                    width: 300px;
                }


            }
        </style>
        <div class="container attop" >

        <div class=" loginbox " style="text-align: center; ">
            <div style="padding: 20px; padding-bottom: 30px;">
                <img class="animated zoomIn" src="<?=_SPPATH;?>images/logo_sempoa.png" style="max-width: 100%;">
            </div>

            <div class="berpadding">
            <?
            $acc = new AccountLogin();
            $acc->loginForm();
            ?>
            <style>
                .checkbox input[type=checkbox], .checkbox-inline input[type=checkbox], .radio input[type=radio], .radio-inline input[type=radio] {
                     margin-left: 0px;
                    display: none;
                }
                .checkboxspan{
                    margin-left: 20px;
                    display: none;
                }
                .btn-primary {
                    color: #fff;
                    background-color: #008247;
                    border-color: #008247;
                }
                .btn-primary:hover,.btn-primary:focus{
                    background-color: #00a157;
                    border-color: #00a157;
                }
                a{
                    color: #005c32;
                    text-decoration: underline;
                }
                a:hover{
                    color: #008d4c;
                }
                .pure-toggle-label{
                    display: none;
                }

                body,.pure-pusher,#maincontent{
                    font-weight: normal;
                    background-color: #f3a637;
                    color: #73879C;
                }
            </style>
                <?/*
            <div style="margin-top: 10px; text-align: right;color: #005c32;">
<!--                <a class="btn btn-default"  href="--><?//=_SPPATH;?><!--forgotpassword">forgot password</a>-->
                <a  href="<?=_SPPATH;?>register">register</a> <i class="glyphicon glyphicon-option-vertical"></i> <a  href="<?=_SPPATH;?>enquiry">learn more</a> <i class="glyphicon glyphicon-option-vertical"></i> <a  href="<?=_SPPATH;?>forgotpassword">forgot password</a>
            </div>
<!--            <h1 class="hype" style="margin-bottom: 30px;">OR</h1>-->
<!--            <a class="btn btn-lg btn-success btn-block" href="--><?//=_SPPATH;?><!--register">Register</a>-->
<!--            -->
*/?>
            </div>
        </div>

        <div class="clearfix" ></div>
<!--        <div style="text-align: center; padding-top: 30px;">-->
<!--            Copyright &copy; PT. Indo Mega Byte-->
<!--        </div>-->

        </div>
       <?
    }

    function enquiry(){
        ?>
        <div class="container attop"  >
        <div class="col-md-8 col-md-offset-2">

            <div class="appear_logo_pages">
                <a href="<?=_SPPATH;?>">
                    <img src="<?=_SPPATH;?>images/appear-icontext.png" >
                </a>
            </div>

            <?
            $page = new Page();
            $arrPages = $page->getWhere("post_gallery_id = 1 AND post_status = 'publish' ORDER BY ID ASC");

            ?>


            <div class="panel-group" id="accordion">
                <?
                foreach($arrPages as $num=>$page){
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$num;?>">
                                <?=stripslashes($page->post_title);?></a>
                        </h4>
                    </div>
                    <div id="collapse<?=$num;?>" class="panel-collapse collapse <?if($num==0)echo 'in';?>">
                        <div class="panel-body">
                            <?=stripslashes($page->post_content);?>
                        </div>
                    </div>
                </div>
                    <? } ?>

            </div>
        </div>
        </div>


        <?
    }

    var $access_mydashboard = "normal_user";
    function mydashboard(){

//        pr($_SESSION);

        MyDashboard::mysales();
//        MyDashboard::getMyDashboard();
    }

    var $access_home = "normal_user";
    function home(){
        MyApps2::getMyApps();
//        MyApps::getMyApps();
    }


    var $access_delete_app = "normal_user";
    function delete_app(){

        $id = addslashes($_GET['app_id']);

        $acc = new App2Acc();


        $apps = $acc->getWhereFromMultipleTable("ac_admin_id = '".Account::getMyID()."' AND ac_app_id = app_id AND ac_app_id = '$id' ",array("AppAccount"));

        if(count($apps)<1){
            die("hacking attempt");
        }else{
            $app = $apps[0];
        }

        if($app->app_active){


            header("Location:"._SPPATH."myapps");
            die();
        }

        AppAccount::checkOwnership($app);


        $appAcc = new AppAccount();
        $appAcc->delete($id);

        $app2Acc = new App2Acc();
        $app2Acc->delete($app->ac_id);

        //delete JSON also
        unlink(_PHOTOPATH."json/". $app->app_keywords.".json");

        header("Location:"._SPPATH."myapps");
        die();
    }

    function contact(){

        //TODO harus dibikin
        ?>
        <h1>Contact Us</h1>
        <?
    }
    var $access_mysales = "normal_user";
    function mysales(){
        MyDashboard::mysales();
    }

    var $access_myearning = "normal_user";
    function myearning(){
        MyDashboard::myearning();
    }

    var $access_mypayout = "normal_user";
    function mypayout(){
        MyDashboard::mypayout();
    }

    var $access_myfreebies = "normal_user";
    function myfreebies(){
        MyDashboard::myfreebies();
    }


    var $access_myOrders = "normal_user";
    function myOrders(){

        MyOrders::myorderspage();

    }


    function finishing(){

        die('not used');
        //cek apakah sudah bayar atau blom..kalau sudah bayar...header saja location success ...
        //update success dan redirect ....

        ZAppFeature::clearSession();

        $id = addslashes($_GET['id']);
        ?>
        <div class="container attop"  >
        <div class="col-md-8 col-md-offset-2">

        <div style="text-align: center; padding: 20px;">
            <a href="<?=_SPPATH;?>">
                <img src="<?=_SPPATH;?>images/appear-icontext.png" style="max-width: 300px;">
            </a>
        </div>

            <div style="text-align: center;">

            <h1>Create the App for your Business</h1>
                <p>Let's upload your Appear App to Google Play.<br>
                    so that your loyal customers can find you right away.</p>
                <a class="btn btn-danger btn-lg" href="<?=_SPPATH;?>PaymentWeb/pay?app_id=<?=$id;?>">checkout now</a>
                <hr>

                If your App is for social, spiritual, education or religion Organizations
                <br><br>
                <a class="btn btn-default btn-sm" href="<?=_SPPATH;?>MyApp/free?id=<?=$id;?>">activate Appear for FREE</a>

            <hr>
            <h5>Download Appear Capsule to <a href="<?=_SPPATH;?>preview?id=<?=$id;?>">preview your App</a> on mobile phones
            OR
            <a href="<?=_SPPATH;?>mydashboard">go to dashboard</a> </h5>

            </div>
        </div>
        </div>

        <?
    }

    var $access_apply_free = "normal_user";
    function apply_free(){
        AppearForm::freeForm();
    }
    var $access_processFree = "normal_user";
    function processFree(){
        AppearForm::processFree();
    }

    var $access_become_agent = "normal_user";
    function become_agent(){
        AppearForm::become_agent();
    }

    var $access_processAgent = "normal_user";
    function processAgent(){
        AppearForm::processAgent();
    }

    var $access_invite = "normal_user";
    function invite(){
        ?>
        <div class="container attop"  >
            <div class="col-md-6 col-md-offset-3">
                <div class="appear_logo_pages">
                    <a href="<?=_SPPATH;?>">
                        <img src="<?=_SPPATH;?>images/appear-agent.png" >
                    </a>
                </div>

                <div style="text-align: center;" >
                    <p>Please insert the email addresses of the people you wish to invite <br> (comma separated)</p>
                </div>
                <div style="text-align: center; margin-bottom: 100px;">
                    <form id="formreg" class="form-horizontal" role="form" >



                                <textarea name="addresss" id="addresss" class="form-control" rows="3"></textarea>
                                <div id="address_err" class="err"></div>
                        <button style="width: 100%; margin-top: 10px;" type="submit" class="btn btn-primary btn-lg">Invite</button>
                        <div style="text-align: right; margin-top: 5px;" >
                        <a href="<?=_SPPATH;?>mydashboard">back to dashboard</a>
                        </div>



                        <div id="resultajax" style="display: none; text-align: center;" class="alert alert-danger"></div>

                    </form>


                </div>
            </div>
        </div>
    <?
    }

    function testEmail(){

        die();

        $judul = "It's Official: You're On The Appear Team";

        $message = '<html><body>';
        $message .= '
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center">
            <img src="'._BPATH.'images/registration.png" alt="Appear Registration" />
            <h1>Thank you for registering with us.</h1>
            <h2>OUR MISSION IS CLEAR: APPEAR IS THE APP FOR YOUR BUSINESS.</h2>
            <p>Here are your registration credentials:</p>
        </td>
    </tr>
    <tr>
        <td>';

        $message .= '<table rules="all" width="100%" style="border-color: #666;" cellpadding="10">';
        $message .= "<tr style='background: #eee;'><td><strong>Username:</strong> </td><td>" . strip_tags("elroy") . "</td></tr>";
        $message .= "<tr><td><strong>Email:</strong> </td><td>" . strip_tags("elroy.hardoyo@gmail.com") . "</td></tr>";
        $message .= "</table>";

        $message .= '</td>
    </tr>
</table>';

//        $message .= '<img src="'._BPATH.'images/registration.png" alt="Appear Registration" />';
//        $message .= '<h1>Thank you for registering with us.</h1>';
//        $message .= '<h2>OUR MISSION IS CLEAR: APPEAR IS THE APP FOR YOUR BUSINESS.</h2>';
//        $message .= '<p>Here are your registration credentials:</p>';

        $message .= "</body></html>";

        $isi = $message;

                        $isi = "
                        <h1>Thank you for registering with us!!</h1>
                        <br>

                        ";

        $lep = new Leapmail2();
        $hasil = $lep->sendHTMLEmail("elroy.hardoyo@gmail.com",$judul,$isi,$message);

//        pr($hasil);

        pr($hasil->success());

        $hasil->success() && var_dump($hasil->getData());

    }

    function preview(){
        $id = addslashes($_GET['id']);

        $app = new AppAccount();
        $app->getByID($id);

        AppAccount::checkOwnership($app);


//        pr($app);
        ?>

        <div class="container attop"  >
            <div class="col-md-8 col-md-offset-2">
                <div class="appear_logo_pages">
                    <a href="<?=_SPPATH;?>">
                        <img src="<?=_SPPATH;?>images/appear-capsule.png" >
                    </a>
                </div>


                <div style="text-align: center; padding-top: 20px;">
                <p>You can preview your App by installing our Appear Capsule App</p>


                    <div class="strike">
                        <span>1.Download Appear Capsule App</span>
                    </div>
                    <div class="steps">

                        <img src="<?=_SPPATH;?>images/gplay.png" width="150px">
                        <img src="<?=_SPPATH;?>images/appstore.png" width="150px">

                    </div>

                    <div class="strike">
                        <span>2.Login with your Appear Credentials</span>
                    </div>

                    <div class="steps">

                        Screen shots

                    </div>

                    <div class="strike">
                        <span>3.Select the App</span>
                    </div>
                    <div class="steps">

                        Screen shots

                    </div>

<!--                <div style="float: left;">-->
<!--                    <div class="app" style="text-align: center;width: 100px;">-->
<!--                    <img src="--><?//=$app->app_icon;?><!--" width="50px"><br>-->
<!--                    --><?//=$app->app_name;?>
<!--                    </div>-->
<!--                </div>-->

                    <?
                    if($app->app_active <1){
                        ?>
                        <div class="strike">
                            <span>4.Activate the App</span>
                        </div>
                        <div class="steps">

                            Your App has not been activated.
                            <br>That means you'll missed all the business opportunities through Google play and App Store Listing.

                            <br><br>
                            <a href="<?=_SPPATH;?>PaymentWeb/pay?app_id=<?=$id;?>">
                                <img src="<?=_SPPATH;?>images/appear-active.png" width="250px">
                                </a>

                        </div>
                        <?
                    }

                    ?>
                    <br>
                <h5><a href="<?=_SPPATH;?>myapps">back to my apps</a> </h5>
                    <br><br>

                </div>
            </div>
        </div>

        <?
    }

    function become_great_agent(){
        ?>
        how to become great agents
        <?
    }

    function resetPassword(){

        //GET
        //hkd utk admin_hash
        //rdid utk admin_id
        //ptt utk random number //ignore

        //adminhash di update setelah request ini...

        $id = addslashes($_GET['id']);
        $hk = addslashes($_GET['hk']);
        $mx = addslashes($_GET['mx']);

        $acc = new Account();
        $acc->getByID($id);

        if($acc->admin_hash != $hk){
            die("Not Matched");
        }
        $succ = 0;

        if($_POST['ijin']){
            if($_POST['ijin'] == $_SESSION['kode_mx']){

                $pwd = addslashes($_POST['pwd1']);
                $pwd2 = addslashes($_POST['pwd2']);

                if($pwd != $pwd2){
                    ?>
                    Password Mismatched!!
                    <?
                }
                else{
                    $crypt = Account::cryptPassword($pwd);
                    $acc->admin_password = $crypt;
                    $succ = $acc->save();


                    ?>
                    Password sudah direset, silahkan login ulang!!
                    <?
                }

            }
        }else {
            $_SESSION['kode_mx'] = base64_encode(time() . "helo" . rand(0, 100));
        }

        if(!$succ) {
            ?>


            <form method="post"
                  action="<?= _SPPATH; ?>resetPassword?mx=<?= $_SESSION['kode_mx']; ?>&id=<?= $id; ?>&hk=<?= $hk; ?>">
                New Password : <input type="password" name="pwd1" required>
                <br>
                Repeat Password : <input type="password" name="pwd2" required>
                <br>
                <input type="hidden" name="ijin" value="<?= $_SESSION['kode_mx']; ?>">
                <button type="submit">reset</button>
            </form>
        <?
        }
    }


    function testvp(){
        $str = 'O:22:"Veritrans_Notification":1:{s:8:"response";O:8:"stdClass":14:{s:11:"status_code";s:3:"200";s:14:"status_message";s:26:"Success, transaction found";s:14:"transaction_id";s:36:"a293ec21-9572-4333-9a41-640a6789b713";s:11:"masked_card";s:11:"518323-9790";s:8:"order_id";s:10:"1084599542";s:12:"gross_amount";s:8:"10000.00";s:12:"payment_type";s:11:"credit_card";s:16:"transaction_time";s:19:"2016-02-17 15:20:37";s:18:"transaction_status";s:10:"settlement";s:12:"fraud_status";s:6:"accept";s:13:"approval_code";s:6:"T08489";s:13:"signature_key";s:128:"12a2c1d52cdd03326727b1ee0cc8a9f658146dbaedac46490f269183291885772e5a31a121c94ebde9f501733c8e7802cf74c3bb839ad687188456c3bf0d45e0";s:4:"bank";s:3:"bni";s:3:"eci";s:2:"02";}} ||| {"status_code":"200","status_message":"Veritrans payment notification","transaction_id":"a293ec21-9572-4333-9a41-640a6789b713","masked_card":"518323-9790","order_id":"1084599542","gross_amount":"10000.00","payment_type":"credit_card","transaction_time":"2016-02-17 15:20:37","transaction_status":"settlement","fraud_status":"accept","approval_code":"T08489","signature_key":"12a2c1d52cdd03326727b1ee0cc8a9f658146dbaedac46490f269183291885772e5a31a121c94ebde9f501733c8e7802cf74c3bb839ad687188456c3bf0d45e0","bank":"bni","eci":"02"}';

        $exp = explode(" ||| ",$str);

        $obj = unserialize($exp[0]);

        pr($obj);

        pr($exp[1]);

        $vp = new VpData();
        $vp->printColumlistAsAttributes();

        $tt = new VpTransaction();
        $tt->printColumlistAsAttributes();

        $km = new KomisiModel();
        $km->printColumlistAsAttributes();

        $bk = new BonusKomisi();
        BonusKomisi::fillBK();

        $bg = new EmailLog();
        $bg->printColumlistAsAttributes();
    }

    function testSendEmail(){
        $de = new DataEmail();

        pr($de->registrationSuccessWithOutVerify("elroy.hardoyo@gmail.com","elroy"));
    }

    function testDate(){
        $date = new DateTime();
        $date->setDate(2016, 31, 1);
        $ymd= $date->format('Y-m-d');


        $ymd = "2016-01-31";

        $prev_mon = date('Y-m-d',strtotime($ymd." +1 month"));
        $prev_year = date('Y-m-d',strtotime($ymd." +4 months"));

        echo "     &nbsp; &nbsp; &nbsp; ".$prev_mon." ".$prev_year;

        $curMonth = 7;
        $curYear = 2016;

        if ($curMonth == 12)
            $firstDayNextMonth = mktime(0, 0, 0, 0, 0, $curYear+1);
        else
            $firstDayNextMonth = mktime(0, 0, 0, $curMonth+1, 1);

        pr(date("Y-m-d",$firstDayNextMonth));


        pr(getFirstDayOfNextMonth($curMonth,$curYear));
        pr(getFirstDayOfNext4Month($curMonth,$curYear));

        $app = new AppAccount();
        $app->getByID(19);

        $vpt = new VpTransaction();
        $vpt->getByID("14720056041915");
        $vpt->order_id = 1122;

//        KomisiModel::log($app,$vpt);

        $nn = new AppFree();
        $nn->printColumlistAsAttributes();
    }


    function crypt(){

//        die("no");
        $acc = new Account();

        $arr = $acc->getAll();
        foreach($arr as $acc){

            $username = $acc->admin_username;
            $password = $acc->admin_password;

            // A higher "cost" is more secure but consumes more processing power
            $cost = 10;

// Create a random salt
            $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');

// Prefix information about the hash so PHP knows how to verify it later.
// "$2a$" Means we're using the Blowfish algorithm. The following two digits are the cost parameter.
            $salt = sprintf("$2a$%02d$", $cost) . $salt;

// Value:
// $2a$10$eImiTXuWVxfM37uY4JANjQ==

// Hash the password with the salt
            $hash = crypt($password, $salt);

            $acc->load = 1;
            $acc->admin_password = $hash;
            $acc->save();
        }
    }

    function testDraft(){

        //var $crud_webservice_allowed = "draft_id,draft_app_id,draft_obj,draft_date,draft_type";
        $prod = new MProdModel();
        $prod->prod_id = 9;
        $prod->prod_stock = 1;
        $prod->prod_name = "Kobe Bryant";
        $prod->prod_pic = "186.jpg";
        $prod->prod_kode = "kode";
        $prod->prod_active = 1;
        $prod->prod_cat_id = 1;
        $prod->prod_app_id = 1;
        $prod->saveAsDraft($prod->prod_app_id,"product");




    }

    function realdeal(){
        $prod = new MProdModel();
        $prod->updateRealDatabase(1);
    }
} 