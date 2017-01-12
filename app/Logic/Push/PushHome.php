<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 11/25/15
 * Time: 2:45 PM
 */

class PushHome extends WebApps{

    function index ()
    {
        $acc = new AccountLogin();
        $acc->loginForm();
    }

    var $access_home = "admin";
    function home(){
//        Registor::redirectOpenLW("Balance", "PushHome/home?st=App_Account");

    }
    function home2(){

        header("Location:"._SPPATH."PushHome/home?st=App_Account");
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

    var $access_selection = "normal_user";
    function selection(){


        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title><?= $title; ?></title>
            <?= $metaKey; ?>
            <?= $metaDescription; ?>
            <!-- Tell the browser to be responsive to screen width -->
            <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
            <!-- Bootstrap 3.3.5 -->
            <link rel="stylesheet" href="<?=_SPPATH._THEMEPATH;?>/bootstrap/css/bootstrap.min.css">
            <!-- Font Awesome -->
            <link rel="stylesheet" href="<?=_SPPATH._THEMEPATH;?>/css/font-awesome.min.css">
            <!-- Ionicons -->
            <?/*<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">*/?>
            <!-- Theme style -->
            <link rel="stylesheet" href="<?=_SPPATH._THEMEPATH;?>/dist/css/AdminLTE.min.css">
            <!-- iCheck -->
            <link rel="stylesheet" href="<?=_SPPATH._THEMEPATH;?>/plugins/iCheck/square/blue.css">

            <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
            <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
            <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
        </head>
        <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                Hello <?=Account::getMyName();?>,
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <h4 style="text-align: center;">Select your App</h4>

                <?
                if(in_array("master_admin",Account::getMyRoles())){

                    $acc = new AppAccount();
                    $apps = $acc->getAll();
//

                }else{
                    $acc = new App2Acc();
                    $apps = $acc->getWhereFromMultipleTable("ac_admin_id = '".Account::getMyID()."' AND ac_app_id = app_id AND app_active = 1",array("AppAccount"));

                }

                foreach($apps as $ap){
                    pr("");
                    ?>
                    <button onclick="document.location='<?=_SPPATH;?>PushHome/setID?app_id=<?=$ap->app_id;?>';" class="btn btn-default" style="width: 100%; margin: 5px;"><?=$ap->app_name;?></button>
                <?
                }

                //            pr($apps);
                ?>



            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->

        <!-- jQuery 2.1.4 -->
        <script src="<?=_SPPATH._THEMEPATH;?>/plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="<?=_SPPATH._THEMEPATH;?>/bootstrap/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="<?=_SPPATH._THEMEPATH;?>/plugins/iCheck/icheck.min.js"></script>
        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
        </script>
        </body>
        </html>

        <?
        die();
    }

    var $access_setID = "normal_user";
    function setID(){

        if(in_array("master_admin",Account::getMyRoles())){

            $acc = new AppAccount();
            $apps = $acc->getAll();
//

        }else{
            $acc = new App2Acc();
            $apps = $acc->getWhereFromMultipleTable("ac_admin_id = '".Account::getMyID()."' AND ac_app_id = app_id AND app_active = 1",array("AppAccount"));

        }

        $arrApp = array();
        foreach($apps as $ap){
            $semua[] = $ap->app_id;
            $arrApp[$ap->app_id] = $ap;
        }

        if(in_array($_GET['app_id'],$semua)){
            //ok
            $_SESSION['app_active'] = $arrApp[$_GET['app_id']];
            $_SESSION['app_id'] = addslashes($_GET['app_id']);
            header("Location:"._SPPATH."PushHome/home?st=Balance");
            die();
        }
        else{
            //not ok
            die("hacking attempt");
        }
    }


} 