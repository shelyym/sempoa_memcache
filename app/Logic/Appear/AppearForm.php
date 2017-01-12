<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 4/7/16
 * Time: 4:38 PM
 */

class AppearForm {

    public static function become_agent(){

        $rand = time().rand(0,100);

        $_SESSION['rand'] = $rand;

        $acc = Account::getAccountObject();
        if($acc->admin_isAgent == 1){
            die('Already Agent');
        }
//        pr($acc);
        ?>
        <style>
            .foto100{
                width: 100px;
                height: 100px;
                overflow: hidden;
                cursor: pointer;
            }
            .foto100 img{
                /*width: 100%;*/
            }
            @media (max-width: 768px) {

                .monly {
                    display: initial;
                }

                .donly {
                    display: none;
                }
                .fotowadah{
                    text-align: center;
                }
                .foto100{
                    margin: 0 auto;
                }

                input[type="file"]{
                    text-align: center;
                    margin: 0 auto;
                }
            }

            @media (min-width: 768px) {
                .monly {
                    display: none;
                }

                .donly {
                    display: initial;
                }


            }
        </style>
        <div class="container attop"  >
            <div class="col-md-8 col-md-offset-2">

                <div class="appear_logo_pages">
                    <a href="<?=_SPPATH;?>">
                        <img src="<?=_SPPATH;?>images/appear-agent.png" >
                    </a>
                </div>

                <div id="waitingApproval" <? if($acc->admin_isAgent != -1){?>style="display: none;"<?}?>>
                    <h3 style="text-align: center;">Your request is being processed. Please wait for our updates.</h3>
                    <div class="back_to_button" style="text-align: center;" >
                        <a href="<?=_SPPATH;?>mydashboard">back to dashboard</a>
                    </div>
                </div>
                <? if($acc->admin_isAgent != -1){?>
                <div id="uploadKTP">
                <div style="text-align: center; padding: 15px;">
                    <p>Please upload your KTP and NPWP, and do not forget to fill your bank credentials to receive payment.</p>
                </div>
                <div class="berpadding" style="text-align: center; margin-bottom: 100px;">
                    <form id="form_agent" class="form-horizontal" role="form" >
                        <input type="hidden" name="token" value="<?=$rand;?>">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="ktp">KTP : </label>
                            <div class="col-sm-10 fotowadah">
                                <?
                                $file = new \Leap\View\InputFoto("ktp","ktp","");
                                $file->p();
                                ?>
                                <div id="ktp_err" class="err"></div>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="npwp">NPWP : </label>
                            <div class="col-sm-10 fotowadah">
                                <?
                                $file = new \Leap\View\InputFoto("npwp","npwp","");
                                $file->p();
                                ?>
                                <div id="npwp_err" class="err"></div>
                            </div>
                        </div>
                            </div>
                        <div class="clearfix"></div>
                        <hr>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="bank_name">Bank Name : </label>
                            <div class="col-sm-10">
                                <input name="bank_name" type="text" class="form-control" id="bank_name" placeholder="Bank Name">
                                <div id="bank_name_err" class="err"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="account_nr">Account Number : </label>
                            <div class="col-sm-10">
                                <input name="account_nr" type="text" class="form-control" id="account_nr" placeholder="Account Number">
                                <div id="account_nr_err" class="err"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="account_name">Account Name : </label>
                            <div class="col-sm-10">
                                <input name="account_name" type="text" class="form-control" id="account_name" placeholder="Account Name">
                                <div id="account_name_err" class="err"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="branch_name">Branch Name (KCU) : </label>
                            <div class="col-sm-10">
                                <input name="branch_name" type="text" class="form-control" id="branch_name" placeholder="Branch Name">
                                <div id="branch_name_err" class="err"></div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="tos">Terms and Conditions: </label>
                            <div class="col-sm-10" style="text-align: left;  ">
                                <input type="checkbox" name="tos" id="tos" value="1"  > I accept the terms and conditions.
                                <div class="read"> <a target="_blank" href="<?=_SPPATH;?>tos/agent">read terms and conditions</a></div>
                                <div id="tos_err" class="err"></div>
                            </div>
                        </div>

                        <hr>

                        <div id="resultajax" style="display: none; text-align: center;" class="alert alert-danger"></div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button style="width: 100%;" type="submit" class="btn btn-primary btn-appeargreen">Verify</button>

                                <div class="back_to_button" >
                                    <a href="<?=_SPPATH;?>mydashboard">back to dashboard</a>
                                </div>
                            </div>
                        </div>
                    </form>


                </div>
                </div>
                <? } ?>
            </div>
        </div>

        <script>
            $( "#form_agent" ).submit(function( event ) {
                if(allowed) {
                    if (validateFormOnSubmit(this)) {
//                        alert("benar semua1");
                        var $form = $(this);
                        var url = "<?=_SPPATH;?>processAgent";

                        $(".err").hide();

                        // Send the data using post
                        var posting = $.post(url, $form.serialize(), function (data) {
                            console.log(data);
                            if (data.bool) {
                                $('#waitingApproval').show();
                                $('#uploadKTP').hide();
                                //kalau success masuk ke check your email....
//                                document.location = "<?//=_SPPATH;?>//check_your_email?type=<?//=$type;?>//";
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

            var allowed = 1;

        </script>
        <script>
            function validateFormOnSubmit(theForm) {
                var reason = "";


                reason += validateEmpty(theForm.tos);

                reason += validateEmpty(theForm.ktp);
                reason += validateEmpty(theForm.npwp);

                reason += validateEmpty(theForm.account_nr);
                reason += validateEmpty(theForm.account_name);
                reason += validateEmpty(theForm.bank_name);
                reason += validateEmpty(theForm.branch_name);

                if(!document.getElementById("tos").checked){
                    var texterr = "Please Accept Agreement";
                    reason += texterr;
                    $('#tos_err').css( "color", "red").show().html(texterr);
//                    $('#tos_err').html(texterr);
                }else{
                    $('#tos_err').hide();
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


            function trim(s)
            {
                return s.replace(/^\s+|\s+$/, '');
            }


        </script>
    <?
    }

    public static function processAgent($mode = "web"){

        $json = array();
        $json['err'] = "";
        $json['bool'] = 0;

        $json['status_code'] = 0;
        $json['status_message'] = "Failed";

        if($mode == "web") {

            $rand = $_SESSION['rand'];
            $token = $_POST['token'];

            if ($rand != $token) {
                $json['err'] .= "Wrong Token<br>";
            }
        }

        //check username
        $ktp = addslashes($_POST['ktp']);
        if($ktp==""){
            $json['err'] .= "Ktp cannot be empty<br>";
        }


        //check username
        $npwp = addslashes($_POST['npwp']);
//        if($npwp==""){
//            $json['err'] .= "Npwp cannot be empty<br>";
//        }



        //check username
        $bank_name = addslashes($_POST['bank_name']);
        if($bank_name ==""){
            $json['err'] .= "Bank Name cannot be empty<br>";
        }

        //check username
        $account_nr = addslashes($_POST['account_nr']);
        if($account_nr ==""){
            $json['err'] .= "Bank Name cannot be empty<br>";
        }

        //check username
        $account_name = addslashes($_POST['account_name']);
        if($account_name ==""){
            $json['err'] .= "Bank Name cannot be empty<br>";
        }

        //check username
        $branch_name = addslashes($_POST['branch_name']);
        if($branch_name ==""){
            $json['err'] .= "Bank Name cannot be empty<br>";
        }
        if($mode == "web") {
            //check username
            $tos = addslashes($_POST['tos']);
            if ($tos == "") {
                $json['err'] .= "Please accept Terms of Service<br>";
            }
        }

        if($json['err'] == ""){

            //process npwp or ktp
            if($mode == "web"){
                $npwp_dipakai = $npwp;
            }else{
                if($npwp != "")
                    $npwp_dipakai =  Crud::savePic($npwp);
            }

            if($mode == "web"){
                $ktp_dipakai = $ktp;
            }else{
                if($ktp != "")
                    $ktp_dipakai =  Crud::savePic($ktp);
            }

            $acc = new Account();
            $acc->getByID(Account::getMyID());

            $acc->admin_bank = $bank_name;
            $acc->admin_bank_acc = $account_nr;
            $acc->admin_bank_acc_name = $account_name;
            $acc->admin_bank_kcu = $branch_name;
            $acc->admin_ktp = $ktp_dipakai;
            $acc->admin_npwp = $npwp_dipakai;
            $acc->admin_isAgent = -1;
            $succ = $acc->save();

            if($succ)
            $_SESSION['account'] = $acc;

            $json['bool'] = $succ;

            if($succ) {
                $json['status_code'] = 1;
                $json['status_message'] = "Submission Successful, Waiting for Approval";
            }
        }



//        $json['post'] = $_POST;

        echo json_encode($json);
        die();
    }

    public static function freeForm(){
        $rand = time().rand(0,100);

        $_SESSION['rand'] = $rand;

        $id = addslashes($_GET['id']);

        $app = new AppAccount();
        $app->getByID($id);

        AppAccount::checkOwnership($app);

        if($app->app_active == 2){
            die("App already active");
        }

        if($app->app_active == 1 && $app->app_type == 0){
            die("App already active");
        }
        ?>
        <style>
            .foto100{
                width: 100px;
                height: 100px;
                overflow: hidden;
                cursor: pointer;
            }
            .foto100 img{
                /*width: 100%;*/
            }
            @media (max-width: 768px) {

                .monly {
                    display: initial;
                }

                .donly {
                    display: none;
                }
                .fotowadah{
                    text-align: center;
                }
                .foto100{
                    margin: 0 auto;
                }

                input[type="file"]{
                    text-align: center;
                    margin: 0 auto;
                }
            }

            @media (min-width: 768px) {
                .monly {
                    display: none;
                }

                .donly {
                    display: initial;
                }


            }
        </style>
        <div class="container attop"  >
            <div class="col-md-8 col-md-offset-2">

                <div class="appear_logo_pages">
                    <a href="<?=_SPPATH;?>">
                        <img src="<?=_SPPATH;?>images/appear-free.png" >
                    </a>
                </div>

                <div id="waitingApproval" <? if(!($app->app_active == 1 && $app->app_type == 1)){?>style="display: none;"<?}?>>
                    <h3 style="text-align: center;">Your request is being processed. Please wait for our updates.</h3>
                    <div class="back_to_button" style="text-align: center;" >
                        <a href="<?=_SPPATH;?>mydashboard">back to dashboard</a>
                    </div>
                </div>
                <? if(!($app->app_active == 1 && $app->app_type == 1)){?>
                <div id="uploadFree">
                <div style="text-align: center; padding: 15px;">
                    <p>Please upload your organization credentials, and fill your contact person credentials to be able to apply as free apps registrants.</p>
                </div>
                <div class="berpadding" style="text-align: center; margin-bottom: 100px;">
                    <form id="formreg_free" class="form-horizontal" role="form" >
                        <input type="hidden" name="token" value="<?=$rand;?>">
                        <input type="hidden" name="app_id" value="<?=$id;?>">
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="org_doc">Organization Documents : </label>
                            <div class="col-sm-9 fotowadah">
                                <?
                                $file = new \Leap\View\InputGallery("org_doc","org_doc","");
                                $file->p();
                                ?>
                                <div id="org_doc_err" class="err"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="org_name">Organization Name : </label>
                            <div class="col-sm-9" >
                                <input name="org_name" type="text" class="form-control" id="org_name" placeholder="Organization Name">
                                <div id="org_name_err" class="err"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="org_type">Organization Type : </label>
                            <div class="col-sm-9">
                                <select id="org_type" name="org_type" class="form-control">
                                    <option value="Educational">Educational</option>
                                    <option value="Spiritual">Spiritual/Religion</option>
                                    <option value="Social">Social</option>
                                    <option value="Other">Other Non-profit</option>
                                </select>
                                <div id="org_type_err" class="err"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="org_addresss">Address : </label>
                            <div class="col-sm-9">
                                <textarea name="org_addresss" id="org_addresss" class="form-control" rows="5"></textarea>
                                <div id="org_addresss_err" class="err"></div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="contact_name">Contact Person : </label>
                            <div class="col-sm-9">
                                <input name="contact_name" type="text" class="form-control" id="contact_name" placeholder="Contact Person">
                                <div id="contact_name_err" class="err"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="contact_phone">Mobile Phone : </label>
                            <div class="col-sm-9">
                                <input name="contact_phone" type="tel" class="form-control" id="contact_phone" placeholder="Enter mobile phone">
                                <div id="contact_phone_err" class="err"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="contact_email">Email : </label>
                            <div class="col-sm-9">
                                <input name="contact_email" type="email" class="form-control" id="contact_email" placeholder="Enter email">
                                <div id="contact_email_err" class="err"></div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="tos">Terms and Conditions: </label>
                            <div class="col-sm-9" style="text-align: left;  ">
                                <input type="checkbox" name="tos" id="tos" value="1"  > I accept the terms and conditions.
                                <div class="read"> <a target="_blank" href="<?=_SPPATH;?>tos/free_app">read terms and conditions</a></div>
                                <div id="tos_err" class="err"></div>
                            </div>
                        </div>

                        <hr>

                        <div id="resultajax" style="display: none; text-align: center;" class="alert alert-danger"></div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button style="width: 100%;" type="submit" class="btn btn-primary btn-appeargreen">Apply as FREE Apps</button>

                                <div class="back_to_button" >
                                    <a href="<?=_SPPATH;?>PaymentWeb/pay?app_id=<?=$_GET['id'];?>">back to payment</a> | <a href="<?=_SPPATH;?>mydashboard">back to dashboard</a>
                                </div>
                            </div>
                        </div>
                    </form>


                </div>

                </div>
                <? } ?>
            </div>
        </div>
        <script>
            $( "#formreg_free" ).submit(function( event ) {
                if(allowed) {
                    if (validateFormOnSubmit(this)) {
//                        alert("benar semua1");
                        var $form = $(this);
                        var url = "<?=_SPPATH;?>processFree";

                        $(".err").hide();

                        // Send the data using post
                        var posting = $.post(url, $form.serialize(), function (data) {
                            console.log(data);
                            if (data.bool) {
                                $('#waitingApproval').show();
                                $('#uploadFree').hide();
                                //kalau success masuk ke check your email....
//                                document.location = "<?//=_SPPATH;?>//check_your_email?type=<?//=$type;?>//";
//                                alert(data.bool);
                            }
                            else {
                                $("#resultajax").show();
                                $("#resultajax").html(data.err);
                            }
                        },'json');

                    } else {

                    }
                }else{
                    alert("Please complete registration");
                }


                event.preventDefault();
            });

            var allowed = 1;

        </script>
        <script>
            function validateFormOnSubmit(theForm) {
                var reason = "";


                reason += validateEmpty(theForm.tos);

                reason += validateEmpty(theForm.org_name);
                reason += validateEmpty(theForm.org_type);

                reason += validateEmpty(theForm.org_doc);
                reason += validateEmpty(theForm.org_addresss);
                reason += validateEmpty(theForm.contact_name);
                reason += validateEmpty(theForm.contact_phone);
                reason += validateEmpty(theForm.contact_email);


                if(!document.getElementById("tos").checked){
                    var texterr = "Please Accept Agreement";
                    reason += texterr;
                    $('#tos_err').css( "color", "red").show().html(texterr);
//                    $('#tos_err').html(texterr);
                }else{
                    $('#tos_err').hide();
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


            function trim(s)
            {
                return s.replace(/^\s+|\s+$/, '');
            }


        </script>
    <?
    }

    public static function processFree(){

        $json = array();
        $json['err'] = "";
        $json['bool'] = 0;

        $rand = $_SESSION['rand'];
        $token = $_POST['token'];

        if($rand != $token){
            $json['err'] .= "Wrong Token<br>";
        }

        $id = addslashes($_POST['app_id']);

        $app = new AppAccount();
        $app->getByID($id);

        AppAccount::checkOwnership($app);

        if($app->app_active){
            $json['err'] .= "App already active<br>";
        }

//        reason += validateEmpty(theForm.tos);
//
//        reason += validateEmpty(theForm.org_name);
//        reason += validateEmpty(theForm.org_type);
//
//        reason += validateEmpty(theForm.org_doc);
//        reason += validateEmpty(theForm.org_addresss);
//        reason += validateEmpty(theForm.contact_name);
//        reason += validateEmpty(theForm.contact_phone);
//        reason += validateEmpty(theForm.contact_email);

        //check username
        $tos = addslashes($_POST['tos']);
        if($tos==""){
            $json['err'] .= "Please accept Terms of Service<br>";
        }

        //check username
        $org_name = addslashes($_POST['org_name']);
        if($org_name==""){
            $json['err'] .= "Organization Name cannot be empty<br>";
        }

        //check username
        $org_type = addslashes($_POST['org_type']);
        if($org_type==""){
            $json['err'] .= "Organization Type cannot be empty<br>";
        }

        //check username
        $org_doc = addslashes($_POST['org_doc']);
        if($org_doc==""){
            $json['err'] .= "Documents cannot be empty<br>";
        }

        //check username
        $org_addresss = addslashes($_POST['org_addresss']);
        if($org_addresss==""){
            $json['err'] .= "Adress cannot be empty<br>";
        }

        //check username
        $contact_name = addslashes($_POST['contact_name']);
        if($contact_name==""){
            $json['err'] .= "Contact cannot be empty<br>";
        }

        //check username
        $contact_phone = addslashes($_POST['contact_phone']);
        if($contact_phone==""){
            $json['err'] .= "Phone cannot be empty<br>";
        }

        //check username
        $contact_email = addslashes($_POST['contact_email']);
        if($contact_email==""){
            $json['err'] .= "Email cannot be empty<br>";
        }

        if($json['err'] == ""){

            $app->app_type = 1;
            $app->app_paket_id = 1; //FREE
            $app->app_active = 1;

            $succ = $app->save();



            //TODO hahah
            if($succ){

                $free = new AppFree();
                $free->free_app_id = $app->app_id;
                $free->free_address = $org_addresss;
                $free->free_contact_email = $contact_email;
                $free->free_org_name = $org_name;
                $free->free_org_docs = $org_doc;
                $free->free_org_type = $org_type;
                $free->free_contact_name = $contact_name;
                $free->free_contact_phone = $contact_phone;
                $free->free_date = leap_mysqldate();
                $free->save(1);

            }


            $json['bool'] = $succ;

        }

//        $json['post'] = $_POST;

        echo json_encode($json);
        die();
    }
} 