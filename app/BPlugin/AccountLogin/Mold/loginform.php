<?php
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];

}
?>


    <form class="form-signin" role="form" action="<?= _SPPATH; ?>login" method="post" id="loginform" name="loginform">

        
        <? if (isset($msg)) { ?>
            <div class=" animated tada" style="margin-bottom: 20px;">

            <div class="alert alert-danger" role="alert">
                <?= $msg; ?>
            </div>

            </div>
        <? } ?>

        <input id="user_login" type="text" name="admin_username" class="form-control" placeholder="Username" required
               autofocus style="margin-bottom: 5px;">
        <input id="user_pass" type="password" name="admin_password" class="form-control" placeholder="Password"
               required>
        <label class="checkbox">
            <input checked="true" type="checkbox" value="1" id="rememberme" name="rememberme"> <span
                class="checkboxspan"><?= Lang::t('remember'); ?></span>
        </label>
        <button class="btn btn-lg btn-primary btn-block" type="submit"><?= Lang::t("submit"); ?></button>
    </form>
<?

