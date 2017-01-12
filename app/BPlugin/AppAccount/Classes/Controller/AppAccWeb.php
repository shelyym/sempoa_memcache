<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 11/26/15
 * Time: 9:05 AM
 */

class AppAccWeb extends WebService{

    /*
    * nama fungsi dan nama kelas harus sama spy crudnya bs jalan
    * untuk mengisi calendar
    */
    var $access_AppAccount = "admin";
    public function AppAccount ()
    {
        //create the model object
        $cal = new AppAccount();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }

    var $access_AppPulsa = "admin";
    public function AppPulsa ()
    {
        //create the model object
        $cal = new AppPulsa();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }

    var $access_App2Acc = "admin";
    public function App2Acc ()
    {
        //create the model object
        $cal = new App2Acc();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }

    var $access_impersonate = "admin";
    function impersonate(){

        if(in_array("master_admin",Account::getMyRoles())){

            $acc = new Account();
            $arr = $acc->getWhere("admin_type = 1 ORDER BY admin_nama_depan ASC");
//            pr($arr);
            ?>
            <select id="clientselector">
                <option value=""></option>
                <?
                foreach($arr as $user){
                    ?>
                    <option value="<?=$user->admin_id;?>"><?=$user->admin_nama_depan;?></option>
                <? } ?>
            </select>
            <script>
//                $("#clientselector").change(function(){
//                    var slc = $("#clientselector").val();
////                    alert(slc);
//                    $('#clientdata').load("<?//=_SPPATH;?>//AppStats/loadDataApp?clientID="+slc);
//                });
            </script>
        <?

        }
    }

    var $access_addpulsa = 'admin';
    function addpulsa(){

        $ap = new AppAccount();
        $arrAp = $ap->getOrderBy("app_name ASC");
        ?>
        <div class="form-group">
            <label for="app">Pilih App</label>
            <select class="form-control" id="app_pulsa">

                <?
                foreach($arrAp as $ap){
                    ?>
                    <option value="<?=$ap->app_id;?>"><?=$ap->app_name;?></option>
                <? } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="app">Jumlah Pulsa</label>
            <input type="number" class="form-control" id="jumlah_pulsa">
        </div>
        <button id="isikan" class="btn btn-primary">Isi</button>
        <script>
            $("#isikan").click(function(){
               var app_id = $("#app_pulsa").val();
                var jml = $('#jumlah_pulsa').val();

                $.post('<?=_SPPATH;?>AppAccWeb/addpulsatrans',{
                    app_id : app_id,
                    jml : jml
                },function(data){
                    alert(data);
                });
            });
        </script>
        <?
    }

    var $access_addpulsatrans = "admin";
    function addpulsatrans(){
        $app_id = addslashes($_POST['app_id']);
        $jml = addslashes($_POST['jml']);

        if($jml < 1)die("jumlah nol");
        if($app_id=="" || $app_id<1)die("app id nol");

        $app = new AppAccount();
        $app->getByID($app_id);

        $add = new AppPulsa();
        $add->pulsa_acc_id = Account::getMyID();
        $add->pulsa_action = 'credit';
        $add->pulsa_jumlah = $jml;
        $add->pulsa_app_id = $app_id;
        $add->pulsa_old = $app->app_pulsa;
        $add->pulsa_new = $app->app_pulsa +  $jml;
        $add->pulsa_date = leap_mysqldate();
        $add->pulsa_camp_id = 0;
        $s1 = $add->save();

        if($s1) {
            $app->app_pulsa = $add->pulsa_new;
            $app->load = 1;
            $s2 = $app->save();

            if($s2){
                die("Saved");
            }
            else{
                die("Error on adding pulsa to AppAcc");
            }
        }
        else{
            die("Error on adding pulsa to AppPulsa");
        }


    }
} 