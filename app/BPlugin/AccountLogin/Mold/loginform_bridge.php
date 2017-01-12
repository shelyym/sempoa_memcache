<?php
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];

}
?>
<style>
    /* Change the white to any color ;) */
    input:-webkit-autofill {
        -webkit-box-shadow: 0 0 0px 1000px #f3a637 inset;
        -webkit-text-fill-color: white !important;

    }
    .uname{
        background-image:url(<?=_SPPATH;?>images/orang.png);
        background-repeat:no-repeat;
        background-size: 20px 20px;
        background-position:6px;
        width: 300px;
        height: 50px;

        border-bottom: 1px solid #706e77;
    }
    .pass2{
        background-image:url(<?=_SPPATH;?>images/gembok.png);
        background-repeat:no-repeat;
        background-size: 20px 20px;
        background-position:6px;
        width: 300px;
        height: 50px;

        border-bottom: 0px solid #706e77;
    }
    input#user_login,input#user_pass{
        background-color: transparent;
/*        background-image:url(*/<?//=_SPPATH;?>/*images/orang.png);*/
/*        background-repeat:no-repeat;*/
/*        background-size: 20px 20px;*/
/*        background-position:6px;*/
        border:0px solid #DADADA;
        /*border-bottom: 1px solid #706e77;*/
        /*margin-top:10px;*/
        width: 265px;
        margin-left: 35px;

        height:45px;
        font-size:14px;
        color: white;
        margin-top: 3px;
    }

    ::-webkit-input-placeholder {
        text-align: left;
    }

    :-moz-placeholder { /* Firefox 18- */
        text-align: left;
    }

    ::-moz-placeholder {  /* Firefox 19+ */
        text-align: left;
    }

    :-ms-input-placeholder {
        text-align: left;
    }

    button.gantibtn{
        background-color: #E65100 !important;
        border: 1px solid #E65100 !important;
        border-radius: 5px;
        color: #FFFFFF;
    }
</style>


    <form class="form-signin" role="form" action="<?= _SPPATH; ?>login" method="post" id="loginform" name="loginform">

        
        <? if (isset($msg)) { ?>
            <div class=" animated tada" style="margin-bottom: 20px;">

            <div class="alert alert-danger" role="alert">
                <?= $msg; ?>
            </div>

            </div>
        <? } ?>

        <div class="uname">
        <input id="user_login" type="text" name="admin_username"  placeholder="Email/Username" required autofocus>
        </div>
        <div class="pass2">
        <input id="user_pass" type="password" name="admin_password"  placeholder="Password"
               required>
        </div>

        <label class="checkbox">
            <input checked="true" type="checkbox" value="1" id="rememberme" name="rememberme"> <span
                class="checkboxspan"><?= Lang::t('remember'); ?></span>
        </label>
        <button class="btn btn-lg btn-primary btn-block gantibtn" type="submit"><?= Lang::t("login"); ?></button>
    </form>
<?

